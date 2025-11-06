<?php

namespace App\Http\Controllers;

use App\Models\Pneu;
use App\Models\Fournisseur;
use App\Models\User;
use App\Models\Vehicule;
use App\Models\Mutation;
use App\Models\Mouvement;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistiques générales
        $stats = [
            'total_pneus' => Pneu::count(),
            'total_fournisseurs' => Fournisseur::count(),
            'total_utilisateurs' => User::count(),
            'total_vehicules' => Vehicule::count(),
            'total_mutations' => Mutation::count(),
            'total_mouvements' => Mouvement::count(),
            'notifications_non_lues' => Notification::nonLues()->count(),
        ];


        // Top 5 des pneus les plus usés
        $pneus_plus_uses = Pneu::orderBy('taux_usure', 'desc')
            ->with('vehicule')
            ->limit(5)
            ->get();

        // Top 5 des véhicules avec le plus de kilométrage
        $vehicules_plus_utilises = Vehicule::withCount('pneus')
            ->orderBy('kilometrage_total', 'desc')
            ->limit(5)
            ->get();

        // Activité récente (dernières 7 actions)
        $activite_recente = collect();


        // Dernières mutations
        $dernieres_mutations = Mutation::with(['pneu', 'vehiculeSource', 'vehiculeDestination'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers mouvements
        $derniers_mouvements = Mouvement::with(['vehicule', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Statistiques mensuelles (derniers 6 mois)
        $stats_mensuelles = $this->getStatsMensuelles();

        return view('dashboard.index', compact(
            'stats',
            'pneus_plus_uses',
            'vehicules_plus_utilises',
            'dernieres_mutations',
            'derniers_mouvements',
            'stats_mensuelles'
        ));
    }

    private function getStatsMensuelles()
    {
        $mois = [];
        $mutations = [];
        $mouvements = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $mois[] = $date->format('M Y');
                
            $mutations[] = Mutation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $mouvements[] = Mouvement::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'mois' => $mois,
            'mutations' => $mutations,
            'mouvements' => $mouvements,
        ];
    }
}
