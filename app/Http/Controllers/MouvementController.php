<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Vehicule;
use App\Services\NotificationService;
use App\Services\DistanceUsureService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MouvementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Mouvement::with(['vehicule', 'user']);

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('destination', 'like', "%{$searchTerm}%")
                  ->orWhere('observations', 'like', "%{$searchTerm}%")
                  ->orWhereHas('vehicule', function ($q) use ($searchTerm) {
                      $q->where('immatriculation', 'like', "%{$searchTerm}%")
                        ->orWhere('marque', 'like', "%{$searchTerm}%")
                        ->orWhere('modele', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('user', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $mouvements = $query->orderBy('date_mouvement', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $mouvements->appends($request->query());

        return view('mouvements.index', compact('mouvements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('mouvements.create', compact('vehicules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DistanceUsureService $distanceUsureService): RedirectResponse
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date_mouvement' => 'required|date',
            'destination' => 'required|string|max:255',
            'observations' => 'nullable|string|max:1000',
            'calculer_distance_auto' => 'boolean'
        ]);

        $vehicule = Vehicule::findOrFail($request->input('vehicule_id'));
        $destination = $request->input('destination');
        $calculerDistanceAuto = $request->boolean('calculer_distance_auto', true);

        // Calculer la distance automatiquement si demandé
        $distance = 0;
        if ($calculerDistanceAuto && $vehicule->position_actuelle && $destination) {
            $distance = $distanceUsureService->calculerDistance($vehicule->position_actuelle, $destination);
        }

        // Si la distance automatique n'a pas fonctionné, demander à l'utilisateur
        if ($distance <= 0) {
            $request->validate([
                'distance_parcourue' => 'required|numeric|min:0.1'
            ]);
            $distance = $request->input('distance_parcourue');
        }

        $mouvement = Mouvement::create([
            'vehicule_id' => $request->input('vehicule_id'),
            'date_mouvement' => $request->input('date_mouvement'),
            'distance_parcourue' => $distance,
            'destination' => $destination,
            'observations' => $request->input('observations'),
            'user_id' => auth()->id()
        ]);

        // Mettre à jour l'usure des pneus automatiquement
        $resultatsUsure = $distanceUsureService->mettreAJourUsurePneus($vehicule, $distance);

        // Mettre à jour la position actuelle du véhicule
        $vehicule->update(['position_actuelle' => $destination]);

        // Créer une notification pour le mouvement enregistré
        NotificationService::mouvementEnregistre($mouvement, auth()->id());

        // Message de succès avec détails
        $message = 'Mouvement enregistré avec succès !';
        $message .= ' Distance: ' . number_format($distance, 2) . ' km.';
        $message .= ' ' . $distanceUsureService->obtenirResumeMiseAJour($resultatsUsure);

        return redirect()->route('mouvements.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mouvement $mouvement): View
    {
        $mouvement->load(['vehicule', 'user']);
        return view('mouvements.show', compact('mouvement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mouvement $mouvement): View
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('mouvements.edit', compact('mouvement', 'vehicules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mouvement $mouvement): RedirectResponse
    {
        // Seuls les administrateurs peuvent modifier un mouvement
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent modifier un mouvement.');
        }

        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date_mouvement' => 'required|date',
            'distance_parcourue' => 'required|integer|min:1',
            'destination' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:1000'
        ]);

        // Calculer la différence de distance pour ajuster le kilométrage des pneus
        $ancienneDistance = $mouvement->distance_parcourue;
        $nouvelleDistance = $request->input('distance_parcourue');
        $difference = $nouvelleDistance - $ancienneDistance;

        $mouvement->update([
            'vehicule_id' => $request->input('vehicule_id'),
            'date_mouvement' => $request->input('date_mouvement'),
            'distance_parcourue' => $request->input('distance_parcourue'),
            'destination' => $request->input('destination'),
            'observations' => $request->input('observations')
        ]);

        // Ajuster le kilométrage des pneus si nécessaire
        if ($difference != 0) {
            $vehicule = $mouvement->vehicule;
            $pneus = \App\Models\Pneu::where('vehicule_id', $vehicule->id)->get();
            
            foreach ($pneus as $pneu) {
                $nouveauKilometrage = $pneu->kilometrage + $difference;
                $pneu->update(['kilometrage' => max(0, $nouveauKilometrage)]);
            }
        }

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mouvement $mouvement): RedirectResponse
    {
        // Seuls les administrateurs peuvent supprimer un mouvement
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer un mouvement.');
        }

        // Soustraire la distance du kilométrage des pneus avant suppression
        $vehicule = $mouvement->vehicule;
        $pneus = \App\Models\Pneu::where('vehicule_id', $vehicule->id)->get();
        
        foreach ($pneus as $pneu) {
            $nouveauKilometrage = $pneu->kilometrage - $mouvement->distance_parcourue;
            $pneu->update(['kilometrage' => max(0, $nouveauKilometrage)]);
        }

        $mouvement->delete();

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement supprimé avec succès. Le kilométrage des pneus a été ajusté.');
    }
}
