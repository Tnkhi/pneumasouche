<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Vehicule::withCount('pneus')
            ->with(['pneus' => function($query) {
                $query->select('vehicule_id', 'prix_achat', 'kilometrage', 'duree_vie');
            }]);

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('immatriculation', 'like', "%{$searchTerm}%")
                  ->orWhere('marque', 'like', "%{$searchTerm}%")
                  ->orWhere('modele', 'like', "%{$searchTerm}%")
                  ->orWhere('type_vehicule', 'like', "%{$searchTerm}%")
                  ->orWhere('chauffeur', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $vehicules = $query->orderBy('created_at', 'desc')->paginate(15);
        $vehicules->appends($request->query());

        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('vehicules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'immatriculation' => 'required|string|max:255|unique:vehicules',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'nullable|integer|min:1900|max:' . date('Y'),
            'type_vehicule' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'chauffeur' => 'nullable|string|max:255'
        ]);

        $vehicule = Vehicule::create($validated);

        // Créer une notification pour la création du véhicule
        NotificationService::vehiculeCree($vehicule, auth()->id());

        return redirect()->route('vehicules.index')
            ->with('success', 'Véhicule créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicule $vehicule): View
    {
        $vehicule->load(['pneus.fournisseur']);
        
        // Calculer les statistiques
        $statistiques = [
            'nombre_pneus' => $vehicule->pneus->count(),
            'valeur_totale' => $vehicule->pneus->sum('prix_achat'),
            'taux_usure_moyen' => $vehicule->pneus->avg(function($pneu) {
                return $pneu->calculerTauxUsure();
            }),
            'kilometrage_moyen' => $vehicule->pneus->avg('kilometrage'),
            'duree_vie_moyenne' => $vehicule->pneus->avg('duree_vie')
        ];

        return view('vehicules.show', compact('vehicule', 'statistiques'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicule $vehicule): View
    {
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicule $vehicule): RedirectResponse
    {
        // Seuls les administrateurs peuvent modifier un véhicule
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent modifier un véhicule.');
        }

        $validated = $request->validate([
            'immatriculation' => 'required|string|max:255|unique:vehicules,immatriculation,' . $vehicule->id,
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'nullable|integer|min:1900|max:' . date('Y'),
            'type_vehicule' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'chauffeur' => 'nullable|string|max:255'
        ]);

        $vehicule->update($validated);

        // Créer une notification pour la modification du véhicule
        NotificationService::vehiculeModifie($vehicule, auth()->id());

        return redirect()->route('vehicules.index')
            ->with('success', 'Véhicule mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicule $vehicule): RedirectResponse
    {
        // Seuls les administrateurs peuvent supprimer un véhicule
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer un véhicule.');
        }

        // Vérifier s'il y a des pneus associés
        if ($vehicule->pneus()->count() > 0) {
            return redirect()->route('vehicules.index')
                ->with('error', 'Impossible de supprimer ce véhicule car il a des pneus associés.');
        }

        // Sauvegarder les informations avant suppression pour la notification
        $immatriculation = $vehicule->immatriculation;
        $marque = $vehicule->marque;

        $vehicule->delete();

        // Créer une notification pour la suppression du véhicule
        NotificationService::vehiculeSupprime($immatriculation, $marque, auth()->id());

        return redirect()->route('vehicules.index')
            ->with('success', 'Véhicule supprimé avec succès.');
    }
}
