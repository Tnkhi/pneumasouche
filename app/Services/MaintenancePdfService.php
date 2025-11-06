<?php

namespace App\Services;

use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MaintenancePdfService
{
    /**
     * Générer un PDF de validation de maintenance
     */
    public function generateValidationPdf(Maintenance $maintenance): string
    {
        // Charger les relations nécessaires
        $maintenance->load([
            'pneu.vehicule',
            'pneu.fournisseur',
            'mecanicien',
            'declarateur',
            'direction'
        ]);

        // Données pour le PDF
        $data = [
            'maintenance' => $maintenance,
            'pneu' => $maintenance->pneu,
            'vehicule' => $maintenance->pneu->vehicule,
            'fournisseur' => $maintenance->pneu->fournisseur,
            'mecanicien' => $maintenance->mecanicien,
            'declarateur' => $maintenance->declarateur,
            'direction' => $maintenance->direction,
            'date_generation' => now()->format('d/m/Y H:i'),
            'numero_document' => 'MAINT-' . str_pad($maintenance->id, 6, '0', STR_PAD_LEFT) . '-' . now()->format('Y'),
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('pdfs.maintenance-validation-compact', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        // Nom du fichier
        $filename = 'maintenance_validation_' . $maintenance->id . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        // Sauvegarder le PDF
        $pdfPath = 'maintenances/' . $filename;
        Storage::disk('public')->put($pdfPath, $pdf->output());

        return $pdfPath;
    }

    /**
     * Télécharger le PDF généré
     */
    public function downloadPdf(string $pdfPath): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $fullPath = Storage::disk('public')->path($pdfPath);
        
        if (!file_exists($fullPath)) {
            abort(404, 'Fichier PDF non trouvé');
        }

        return response()->download($fullPath, basename($pdfPath));
    }

    /**
     * Obtenir l'URL publique du PDF
     */
    public function getPdfUrl(string $pdfPath): string
    {
        // Forcer l'URL correcte pour éviter les problèmes avec localhost
        return 'http://127.0.0.1:8000/storage/' . $pdfPath;
    }
}
