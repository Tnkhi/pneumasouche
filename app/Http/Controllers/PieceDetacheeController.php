<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\PieceDetachee;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PieceDetacheeController extends Controller
{

    /**
     * Afficher le formulaire de gestion des pièces détachées
     */
    public function create(Maintenance $maintenance): View
    {
        // Vérifier que l'utilisateur est un déclarateur ou admin
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent gérer les pièces détachées.');
        }

        // Vérifier que la maintenance est en attente de validation par le déclarateur
        if ($maintenance->etape !== 'declarateur') {
            abort(403, 'Cette maintenance n\'est plus en attente de validation par le déclarateur. Elle est maintenant à l\'étape: ' . $maintenance->etape_name);
        }

        $piecesDetachees = $maintenance->piecesDetachees;
        
        return view('maintenances.pieces-detachees.create', compact('maintenance', 'piecesDetachees'));
    }

    /**
     * Ajouter une pièce détachée
     */
    public function store(Request $request): RedirectResponse
    {
        // Vérifier que l'utilisateur est un déclarateur ou admin
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent gérer les pièces détachées.');
        }

        $validated = $request->validate([
            'maintenance_id' => 'required|exists:maintenances,id',
            'type_piece' => 'required|string|max:255',
            'marque' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'constructeur' => 'nullable|string|max:255',
            'fournisseur' => 'nullable|string|max:255',
            'cout_unitaire' => 'required|numeric|min:0',
            'nombre' => 'required|integer|min:1'
        ]);

        $maintenance = Maintenance::findOrFail($validated['maintenance_id']);

        // Vérifier que la maintenance est en attente de validation par le déclarateur
        if ($maintenance->etape !== 'declarateur') {
            abort(403, 'Cette maintenance n\'est plus en attente de validation par le déclarateur.');
        }

        $piece = PieceDetachee::create([
            'maintenance_id' => $maintenance->id,
            'type_piece' => $validated['type_piece'],
            'marque' => $validated['marque'],
            'reference' => $validated['reference'],
            'constructeur' => $validated['constructeur'],
            'fournisseur' => $validated['fournisseur'],
            'cout_unitaire' => $validated['cout_unitaire'],
            'nombre' => $validated['nombre'],
            'montant_total' => $validated['cout_unitaire'] * $validated['nombre']
        ]);

        return redirect()->back()
            ->with('success', 'Pièce détachée ajoutée avec succès.');
    }

    /**
     * Supprimer une pièce détachée
     */
    public function destroy(PieceDetachee $pieceDetachee): RedirectResponse
    {
        // Vérifier que l'utilisateur est un déclarateur ou admin
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent gérer les pièces détachées.');
        }

        // Vérifier que la maintenance est en attente de validation par le déclarateur
        if ($pieceDetachee->maintenance->etape !== 'declarateur') {
            abort(403, 'Cette maintenance n\'est plus en attente de validation par le déclarateur.');
        }

        $pieceDetachee->delete();

        return redirect()->back()
            ->with('success', 'Pièce détachée supprimée avec succès.');
    }

    /**
     * Finaliser la maintenance avec les pièces détachées
     */
    public function finaliser(Maintenance $maintenance): RedirectResponse
    {
        // Vérifier que l'utilisateur est un déclarateur ou admin
        if (!auth()->user()->isDeclarateur() && !auth()->user()->isAdmin()) {
            abort(403, 'Seuls les déclarateurs et administrateurs peuvent finaliser les maintenances.');
        }

        // Vérifier que la maintenance est en attente de validation par le déclarateur
        if ($maintenance->etape !== 'declarateur') {
            abort(403, 'Cette maintenance n\'est pas en attente de validation par le déclarateur.');
        }

        // Vérifier qu'il y a au moins une pièce détachée
        if ($maintenance->piecesDetachees()->count() === 0) {
            return redirect()->back()
                ->with('error', 'Vous devez ajouter au moins une pièce détachée avant de finaliser.');
        }

        // Mettre à jour la maintenance
        $maintenance->update([
            'etape' => 'direction',
            'statut' => 'en_attente_validation',
            'declarateur_id' => auth()->user()->id,
            'date_validation_declarateur' => now(),
            'prix_maintenance' => $maintenance->montant_total_pieces, // Le prix de maintenance est le total des pièces
            'bon_necessaire' => 'Pièces détachées ajoutées via le système.' // Placeholder ou générer un résumé
        ]);

        $maintenance->ajouterAction('Maintenance complétée par le déclarateur', auth()->user(), 'Pièces détachées ajoutées et maintenance envoyée à la direction.');

        // Créer une notification pour la maintenance validée par le déclarateur
        NotificationService::maintenanceValideeDeclarateur($maintenance, auth()->id());

        return redirect()->route('maintenances.declarateur')
            ->with('success', 'Maintenance finalisée avec succès et envoyée à la direction pour approbation.');
    }
}