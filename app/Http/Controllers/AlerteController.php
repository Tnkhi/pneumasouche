<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Services\AlerteIntelligenteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AlerteController extends Controller
{
    protected $alerteService;

    public function __construct(AlerteIntelligenteService $alerteService)
    {
        $this->alerteService = $alerteService;
    }

    /**
     * Afficher le dashboard des alertes
     */
    public function index(Request $request): View
    {
        $query = Alerte::with(['pneu', 'vehicule', 'maintenance', 'user']);

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->input('priorite'));
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->input('categorie'));
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('titre', 'like', "%{$searchTerm}%")
                  ->orWhere('message', 'like', "%{$searchTerm}%")
                  ->orWhereHas('pneu', function ($q) use ($searchTerm) {
                      $q->where('numero_serie', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('vehicule', function ($q) use ($searchTerm) {
                      $q->where('immatriculation', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $alertes = $query->orderBy('priorite', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        $alertes->appends($request->query());

        $statistiques = $this->alerteService->getStatistiquesAlertes();

        return view('alertes.index', compact('alertes', 'statistiques'));
    }

    /**
     * Générer de nouvelles alertes intelligentes
     */
    public function genererAlertes(): RedirectResponse
    {
        try {
            $nouvellesAlertes = $this->alerteService->analyserEtGenererAlertes();
            $count = count($nouvellesAlertes);
            
            return redirect()->route('alertes.index')
                ->with('success', "Analyse terminée. {$count} nouvelles alertes générées.");
        } catch (\Exception $e) {
            return redirect()->route('alertes.index')
                ->with('error', 'Erreur lors de la génération des alertes: ' . $e->getMessage());
        }
    }

    /**
     * Marquer une alerte comme résolue
     */
    public function resoudre(Request $request, Alerte $alerte): RedirectResponse
    {
        try {
            $request->validate([
                'commentaire' => 'nullable|string|max:500'
            ]);

            $commentaire = $request->input('commentaire');
            $success = $this->alerteService->resoudreAlerte($alerte->id, $commentaire);

            if ($success) {
                return redirect()->route('alertes.index')
                    ->with('success', 'Alerte marquée comme résolue avec succès !');
            }

            return redirect()->route('alertes.index')
                ->with('error', 'Erreur lors de la résolution de l\'alerte');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('alertes.index')
                ->with('error', 'Erreur de validation: ' . implode(', ', array_flatten($e->errors())));
        } catch (\Exception $e) {
            return redirect()->route('alertes.index')
                ->with('error', 'Erreur inattendue: ' . $e->getMessage());
        }
    }

    /**
     * Ignorer une alerte
     */
    public function ignorer(Alerte $alerte): RedirectResponse
    {
        try {
            $success = $this->alerteService->ignorerAlerte($alerte->id);

            if ($success) {
                return redirect()->route('alertes.index')
                    ->with('success', 'Alerte ignorée avec succès !');
            }

            return redirect()->route('alertes.index')
                ->with('error', 'Erreur lors de l\'ignorance de l\'alerte');

        } catch (\Exception $e) {
            return redirect()->route('alertes.index')
                ->with('error', 'Erreur inattendue: ' . $e->getMessage());
        }
    }

    /**
     * Réactiver une alerte
     */
    public function reactiver(Alerte $alerte): RedirectResponse
    {
        try {
            $alerte->reactiver();
            return redirect()->route('alertes.index')
                ->with('success', 'Alerte réactivée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('alertes.index')
                ->with('error', 'Erreur lors de la réactivation de l\'alerte');
        }
    }

    /**
     * API pour obtenir les alertes critiques
     */
    public function apiCritiques(): JsonResponse
    {
        $alertesCritiques = Alerte::critiques()
            ->with(['pneu', 'vehicule'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($alertesCritiques);
    }

    /**
     * API pour obtenir les statistiques des alertes
     */
    public function apiStatistiques(): JsonResponse
    {
        $statistiques = $this->alerteService->getStatistiquesAlertes();
        return response()->json($statistiques);
    }

    /**
     * Afficher les détails d'une alerte
     */
    public function show(Alerte $alerte): View
    {
        $alerte->load(['pneu', 'vehicule', 'maintenance', 'user']);
        return view('alertes.show', compact('alerte'));
    }
}
