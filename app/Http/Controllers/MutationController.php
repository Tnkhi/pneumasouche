<?php

namespace App\Http\Controllers;

use App\Models\Mutation;
use App\Models\Pneu;
use App\Models\Vehicule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Mutation::with(['pneu', 'vehiculeSource', 'vehiculeDestination']);

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('motif', 'like', "%{$searchTerm}%")
                  ->orWhere('operateur', 'like', "%{$searchTerm}%")
                  ->orWhere('observations', 'like', "%{$searchTerm}%")
                  ->orWhereHas('pneu', function ($q) use ($searchTerm) {
                      $q->where('numero_serie', 'like', "%{$searchTerm}%")
                        ->orWhere('marque', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('vehiculeSource', function ($q) use ($searchTerm) {
                      $q->where('immatriculation', 'like', "%{$searchTerm}%")
                        ->orWhere('marque', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('vehiculeDestination', function ($q) use ($searchTerm) {
                      $q->where('immatriculation', 'like', "%{$searchTerm}%")
                        ->orWhere('marque', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $mutations = $query->orderBy('date_mutation', 'desc')->paginate(15);
        $mutations->appends($request->query());

        return view('mutations.index', compact('mutations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pneus = Pneu::with('vehicule')->get();
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        
        return view('mutations.create', compact('pneus', 'vehicules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pneu_id' => 'required|exists:pneus,id',
            'vehicule_source_id' => 'nullable|exists:vehicules,id',
            'vehicule_destination_id' => 'required|exists:vehicules,id',
            'date_mutation' => 'required|date',
            'motif' => 'nullable|string',
            'kilometrage_au_moment_mutation' => 'nullable|string',
            'operateur' => 'nullable|string|max:255',
            'observations' => 'nullable|string'
        ]);

        // Validation supplémentaire : vérifier que le pneu n'est pas déjà sur le véhicule destination
        $pneu = Pneu::find($validated['pneu_id']);
        if ($pneu->vehicule_id == $validated['vehicule_destination_id']) {
            return redirect()->back()
                ->withErrors(['vehicule_destination_id' => 'Ce pneu est déjà monté sur ce véhicule.'])
                ->withInput();
        }

        $mutation = null;
        DB::transaction(function () use ($validated, &$mutation) {
            // Créer la mutation
            $mutation = Mutation::create($validated);
            
            // Mettre à jour le véhicule du pneu
            $pneu = Pneu::find($validated['pneu_id']);
            $pneu->update(['vehicule_id' => $validated['vehicule_destination_id']]);
        });

        // Créer une notification pour la mutation effectuée
        if ($mutation) {
            NotificationService::mutationEffectuee($mutation, auth()->id());
        }

        return redirect()->route('mutations.index')
            ->with('success', 'Mutation effectuée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutation $mutation): View
    {
        $mutation->load(['pneu.fournisseur', 'vehiculeSource', 'vehiculeDestination']);
        return view('mutations.show', compact('mutation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutation $mutation): View
    {
        $pneus = Pneu::with('vehicule')->get();
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        
        return view('mutations.edit', compact('mutation', 'pneus', 'vehicules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutation $mutation): RedirectResponse
    {
        // Seuls les administrateurs peuvent modifier une mutation
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent modifier une mutation.');
        }

        $validated = $request->validate([
            'pneu_id' => 'required|exists:pneus,id',
            'vehicule_source_id' => 'nullable|exists:vehicules,id',
            'vehicule_destination_id' => 'required|exists:vehicules,id',
            'date_mutation' => 'required|date',
            'motif' => 'nullable|string',
            'kilometrage_au_moment_mutation' => 'nullable|string',
            'operateur' => 'nullable|string|max:255',
            'observations' => 'nullable|string'
        ]);

        $mutation->update($validated);

        return redirect()->route('mutations.index')
            ->with('success', 'Mutation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutation $mutation): RedirectResponse
    {
        // Seuls les administrateurs peuvent supprimer une mutation
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer une mutation.');
        }

        try {
            DB::transaction(function () use ($mutation) {
                $mutation->delete();
            });

            return redirect()->route('mutations.index')
                ->with('success', 'Mutation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('mutations.index')
                ->with('error', 'Erreur lors de la suppression de la mutation.');
        }
    }

    /**
     * Supprimer une mutation via GET (pour éviter les problèmes CSRF)
     */
    public function delete(Mutation $mutation): RedirectResponse
    {
        try {
            DB::transaction(function () use ($mutation) {
                $mutation->delete();
            });

            return redirect()->route('mutations.index')
                ->with('success', 'Mutation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('mutations.index')
                ->with('error', 'Erreur lors de la suppression de la mutation.');
        }
    }

    /**
     * Afficher l'historique des mutations d'un pneu
     */
    public function historiquePneu(Pneu $pneu): View
    {
        $mutations = $pneu->mutations()->with(['vehiculeSource', 'vehiculeDestination'])->get();
        
        return view('mutations.historique-pneu', compact('pneu', 'mutations'));
    }

    /**
     * Afficher l'historique des mutations d'un véhicule
     */
    public function historiqueVehicule(Vehicule $vehicule): View
    {
        $mutationsSource = $vehicule->mutationsSource()->with(['pneu', 'vehiculeDestination'])->get();
        $mutationsDestination = $vehicule->mutationsDestination()->with(['pneu', 'vehiculeSource'])->get();
        
        $mutations = $mutationsSource->merge($mutationsDestination)->sortByDesc('date_mutation');
        
        return view('mutations.historique-vehicule', compact('vehicule', 'mutations'));
    }
}
