<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Fournisseur::withCount('pneus')
            ->with(['pneus' => function($query) {
                $query->select('fournisseur_id', 'prix_achat', 'kilometrage', 'duree_vie');
            }]);

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nom', 'like', "%{$searchTerm}%")
                  ->orWhere('contact', 'like', "%{$searchTerm}%")
                  ->orWhere('telephone', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('adresse', 'like', "%{$searchTerm}%");
            });
        }

        $fournisseurs = $query->orderBy('created_at', 'desc')->paginate(15);
        $fournisseurs->appends($request->query());

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('fournisseurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string'
        ]);

        $fournisseur = Fournisseur::create($validated);

        // Créer une notification pour la création du fournisseur
        NotificationService::fournisseurCree($fournisseur, auth()->id());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur): View
    {
        $fournisseur->load(['pneus.vehicule']);
        
        // Calculer les statistiques
        $statistiques = [
            'nombre_pneus' => $fournisseur->pneus->count(),
            'valeur_totale' => $fournisseur->pneus->sum('prix_achat'),
            'taux_usure_moyen' => $fournisseur->pneus->avg(function($pneu) {
                return $pneu->calculerTauxUsure();
            }),
            'duree_vie_moyenne' => $fournisseur->pneus->avg('duree_vie'),
            'kilometrage_moyen' => $fournisseur->pneus->avg('kilometrage')
        ];

        return view('fournisseurs.show', compact('fournisseur', 'statistiques'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur): View
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur): RedirectResponse
    {
        // Seuls les administrateurs peuvent modifier un fournisseur
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent modifier un fournisseur.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string'
        ]);

        $fournisseur->update($validated);

        // Créer une notification pour la modification du fournisseur
        NotificationService::fournisseurModifie($fournisseur, auth()->id());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur): RedirectResponse
    {
        // Seuls les administrateurs peuvent supprimer un fournisseur
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer un fournisseur.');
        }

        // Vérifier s'il y a des pneus associés
        if ($fournisseur->pneus()->count() > 0) {
            return redirect()->route('fournisseurs.index')
                ->with('error', 'Impossible de supprimer ce fournisseur car il a des pneus associés.');
        }

        // Sauvegarder les informations avant suppression pour la notification
        $nom = $fournisseur->nom;

        $fournisseur->delete();

        // Créer une notification pour la suppression du fournisseur
        NotificationService::fournisseurSupprime($nom, auth()->id());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur supprimé avec succès.');
    }
}
