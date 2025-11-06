<?php

namespace App\Http\Controllers;

use App\Models\Pneu;
use App\Models\Fournisseur;
use App\Models\Vehicule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PneuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Pneu::with(['fournisseur', 'vehicule']);

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('numero_serie', 'like', "%{$searchTerm}%")
                  ->orWhere('marque', 'like', "%{$searchTerm}%")
                  ->orWhere('modele', 'like', "%{$searchTerm}%")
                  ->orWhere('dimension', 'like', "%{$searchTerm}%")
                  ->orWhereHas('fournisseur', function ($q) use ($searchTerm) {
                      $q->where('nom', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('vehicule', function ($q) use ($searchTerm) {
                      $q->where('immatriculation', 'like', "%{$searchTerm}%")
                        ->orWhere('marque', 'like', "%{$searchTerm}%")
                        ->orWhere('modele', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $pneus = $query->orderBy('created_at', 'desc')->paginate(15);
        $pneus->appends($request->query());

        return view('pneus.index', compact('pneus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        
        return view('pneus.create', compact('fournisseurs', 'vehicules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string|max:255|unique:pneus',
            'prix_achat' => 'required|numeric|min:0',
            'date_montage' => 'required|date',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'marque' => 'required|string|max:255',
            'largeur' => 'required|integer|min:1',
            'hauteur_flanc' => 'required|integer|min:1',
            'diametre_interieur' => 'required|integer|min:1',
            'indice_vitesse' => 'required|string|max:10',
            'indice_charge' => 'required|string|max:10',
            'duree_vie' => 'required|integer|min:1',
            'kilometrage' => 'nullable|integer|min:0',
            'vehicule_id' => 'required|exists:vehicules,id'
        ]);

        $validated['kilometrage'] = $validated['kilometrage'] ?? 0;

        $pneu = Pneu::create($validated);

        // Créer une notification pour la création du pneu
        NotificationService::pneuCree($pneu, auth()->id());

        return redirect()->route('pneus.index')
            ->with('success', 'Pneu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pneu $pneu): View
    {
        $pneu->load(['fournisseur', 'vehicule']);
        return view('pneus.show', compact('pneu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pneu $pneu): View
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        
        return view('pneus.edit', compact('pneu', 'fournisseurs', 'vehicules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pneu $pneu): RedirectResponse
    {
        // Seuls les administrateurs peuvent modifier un pneu
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent modifier un pneu.');
        }

        $validated = $request->validate([
            'numero_serie' => 'required|string|max:255|unique:pneus,numero_serie,' . $pneu->id,
            'prix_achat' => 'required|numeric|min:0',
            'date_montage' => 'required|date',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'marque' => 'required|string|max:255',
            'largeur' => 'required|integer|min:1',
            'hauteur_flanc' => 'required|integer|min:1',
            'diametre_interieur' => 'required|integer|min:1',
            'indice_vitesse' => 'required|string|max:10',
            'indice_charge' => 'required|string|max:10',
            'duree_vie' => 'required|integer|min:1',
            'kilometrage' => 'nullable|integer|min:0',
            'vehicule_id' => 'required|exists:vehicules,id'
        ]);

        $validated['kilometrage'] = $validated['kilometrage'] ?? 0;

        $pneu->update($validated);

        // Créer une notification pour la modification du pneu
        NotificationService::pneuModifie($pneu, auth()->id());

        return redirect()->route('pneus.index')
            ->with('success', 'Pneu mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pneu $pneu): RedirectResponse
    {
        // Seuls les administrateurs peuvent supprimer un pneu
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer un pneu.');
        }

        // Sauvegarder les informations avant suppression pour la notification
        $numeroSerie = $pneu->numero_serie;
        $marque = $pneu->marque;

        $pneu->delete();

        // Créer une notification pour la suppression du pneu
        NotificationService::pneuSupprime($numeroSerie, $marque, auth()->id());

        return redirect()->route('pneus.index')
            ->with('success', 'Pneu supprimé avec succès.');
    }

}
