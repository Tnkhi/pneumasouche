<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Vehicule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MaintenanceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $maintenances = Maintenance::with(['vehicule', 'mecanicien', 'declarateur', 'piecesDetachees'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Seuls les mécaniciens et admins peuvent déclarer une maintenance
        if (!auth()->user()->isMecanicien() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les mécaniciens et administrateurs peuvent déclarer une maintenance.');
        }

        $vehicules = Vehicule::all();
        return view('maintenances.create', compact('vehicules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Seuls les mécaniciens et admins peuvent déclarer une maintenance
        if (!auth()->user()->isMecanicien() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les mécaniciens et administrateurs peuvent déclarer une maintenance.');
        }

        $validated = $request->validate([
            'type_maintenance' => 'required|in:preventive,curative',
            'sous_type_curative' => 'required_if:type_maintenance,curative|in:intervention_moteur,intervention_boite_vitesse,intervention_volant_embrayage,intervention_suspension_freinage,intervention_pont_transmission,intervention_refroidissement,intervention_tableau_bord,intervention_carrosserie',
            'vehicule_id' => 'required|exists:vehicules,id',
            'prerequis' => 'required|string',
            'requis' => 'required|string',
            'resultat_attendu' => 'required|string',
            'explication_cause' => 'required|string'
        ]);

        $maintenance = Maintenance::create([
            ...$validated,
            'mecanicien_id' => auth()->user()->id,
            'statut' => 'declaree',
            'etape' => 'declarateur'
        ]);

        $maintenance->ajouterAction('Déclaration créée', auth()->user(), 'Maintenance curative déclarée par ' . auth()->user()->role_name);

        // Créer une notification pour la maintenance déclarée
        NotificationService::maintenanceDeclaree($maintenance, auth()->id());

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance curative déclarée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['vehicule', 'mecanicien', 'declarateur', 'direction', 'piecesDetachees']);
        return view('maintenances.show', compact('maintenance'));
    }

    /**
     * Vue pour le déclarateur
     */
    public function declarateur(): View
    {
        // Seuls les déclarateurs et admins peuvent accéder à cette vue
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent accéder à cette vue.');
        }

        $maintenances = Maintenance::with(['vehicule', 'mecanicien', 'piecesDetachees'])
            ->where('etape', 'declarateur')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('maintenances.declarateur', compact('maintenances'));
    }

    /**
     * Vue pour la direction
     */
    public function direction(): View
    {
        // Seule la direction peut accéder à cette vue
        if (!auth()->user()->isDirection()) {
            abort(403, 'Seule la direction peut accéder à cette vue.');
        }

        $maintenances = Maintenance::with(['vehicule', 'mecanicien', 'declarateur', 'piecesDetachees'])
            ->where('etape', 'direction')
            ->orderBy('date_validation_declarateur', 'desc')
            ->paginate(15);

        return view('maintenances.direction', compact('maintenances'));
    }

    /**
     * Valider une maintenance par le déclarateur
     */
    public function validerDeclarateur(Request $request, Maintenance $maintenance): RedirectResponse
    {
        // Seuls les déclarateurs et admins peuvent valider
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent valider les maintenances.');
        }

        // Vérifier que la maintenance est en attente de validation par le déclarateur
        if (!$maintenance->peutEtreValideeParDeclarateur()) {
            abort(403, 'Cette maintenance ne peut pas être validée par le déclarateur.');
        }

        $validated = $request->validate([
            'numero_reference' => 'required|string',
            'bon_necessaire' => 'required|string',
            'prix_maintenance' => 'required|numeric|min:0'
        ]);

        $maintenance->update([
            'etape' => 'direction',
            'statut' => 'en_attente_validation',
            'declarateur_id' => auth()->user()->id,
            'date_validation_declarateur' => now(),
            ...$validated
        ]);

        $maintenance->ajouterAction('Validation par le déclarateur', auth()->user(), 'Maintenance validée par ' . auth()->user()->role_name);

        // Créer une notification pour la maintenance validée par le déclarateur
        NotificationService::maintenanceValideeDeclarateur($maintenance, auth()->id());

        return redirect()->route('maintenances.declarateur')
            ->with('success', 'Maintenance validée avec succès et transmise à la direction.');
    }

    /**
     * Afficher les détails complets pour la direction
     */
    public function directionDetails(Maintenance $maintenance): View
    {
        // Seule la direction peut voir les détails
        if (!auth()->user()->isDirection()) {
            abort(403, 'Seule la direction peut voir les détails des maintenances.');
        }

        // Charger les relations nécessaires
        $maintenance->load(['vehicule', 'mecanicien', 'declarateur', 'direction', 'piecesDetachees']);

        return view('maintenances.direction-details', compact('maintenance'));
    }

    /**
     * Valider une maintenance par la direction
     */
    public function validerDirection(Request $request, Maintenance $maintenance): RedirectResponse
    {
        // Seule la direction peut valider
        if (!auth()->user()->isDirection()) {
            abort(403, 'Seule la direction peut valider les maintenances.');
        }

        // Vérifier que la maintenance est en attente de validation par la direction
        if (!$maintenance->peutEtreValideeParDirection()) {
            abort(403, 'Cette maintenance ne peut pas être validée par la direction.');
        }

        $maintenance->update([
            'statut' => 'validee',
            'direction_id' => auth()->user()->id,
            'date_validation_direction' => now(),
            'commentaire_direction' => $request->input('commentaire_direction')
        ]);

        $maintenance->ajouterAction('Validation par la direction', auth()->user(), 'Maintenance approuvée par ' . auth()->user()->role_name);

        // Créer une notification pour la maintenance validée par la direction
        NotificationService::maintenanceValideeDirection($maintenance, auth()->id());

        return redirect()->route('maintenances.direction')
            ->with('success', 'Maintenance approuvée avec succès.');
    }

    /**
     * Rejeter une maintenance par la direction
     */
    public function rejeterDirection(Request $request, Maintenance $maintenance): RedirectResponse
    {
        // Seule la direction peut rejeter
        if (!auth()->user()->isDirection()) {
            abort(403, 'Seule la direction peut rejeter les maintenances.');
        }

        // Vérifier que la maintenance est en attente de validation par la direction
        if (!$maintenance->peutEtreValideeParDirection()) {
            abort(403, 'Cette maintenance ne peut pas être rejetée par la direction.');
        }

        $validated = $request->validate([
            'commentaire_direction' => 'required|string'
        ]);

        $maintenance->update([
            'statut' => 'rejetee',
            'direction_id' => auth()->user()->id,
            'date_validation_direction' => now(),
            'commentaire_direction' => $validated['commentaire_direction']
        ]);

        $maintenance->ajouterAction('Rejet par la direction', auth()->user(), 'Maintenance rejetée par ' . auth()->user()->role_name);

        // Créer une notification pour la maintenance rejetée par la direction
        NotificationService::maintenanceRejeteeDirection($maintenance, auth()->id());

        return redirect()->route('maintenances.direction')
            ->with('success', 'Maintenance rejetée avec succès.');
    }

    /**
     * Terminer une maintenance
     */
    public function terminer(Request $request, Maintenance $maintenance): RedirectResponse
    {
        // Seuls les mécaniciens et admins peuvent terminer
        if (!auth()->user()->isMecanicien() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les mécaniciens et administrateurs peuvent terminer les maintenances.');
        }

        // Vérifier que la maintenance peut être terminée
        if (!$maintenance->peutEtreTerminee()) {
            abort(403, 'Cette maintenance ne peut pas être terminée.');
        }

        $validated = $request->validate([
            'rapport_finalisation' => 'required|string'
        ]);

        $maintenance->update([
            'etape' => 'terminee',
            'statut' => 'terminee',
            'date_finalisation' => now(),
            'rapport_finalisation' => $validated['rapport_finalisation']
        ]);

        $maintenance->ajouterAction('Finalisation', auth()->user(), 'Maintenance terminée par ' . auth()->user()->role_name);

        // Créer une notification pour la maintenance terminée
        NotificationService::maintenanceTerminee($maintenance, auth()->id());

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance terminée avec succès.');
    }
}