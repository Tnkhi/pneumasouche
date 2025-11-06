@extends('layouts.app')

@section('title', 'Dashboard - PNEUMA-SOUCHE')

@section('content')
<div class="container-fluid">
    <!-- En-tête du dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tachometer-alt text-primary"></i> Dashboard</h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt"></i> {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_pneus'] }}</h4>
                            <p class="card-text">Total Pneus</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tire fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_vehicules'] }}</h4>
                            <p class="card-text">Total Véhicules</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_fournisseurs'] }}</h4>
                            <p class="card-text">Total Fournisseurs</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_maintenances'] }}</h4>
                            <p class="card-text">Total Maintenances</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-wrench fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_mutations'] }}</h4>
                            <p class="card-text">Total Mutations</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_utilisateurs'] }}</h4>
                            <p class="card-text">Total Utilisateurs</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes critiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Alertes Critiques</h5>
                    <div>
                        <a href="{{ route('alertes.generer') }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-sync-alt"></i> Générer Alertes
                        </a>
                        <a href="{{ route('alertes.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-external-link-alt"></i> Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $alertesCritiques = \App\Models\Alerte::critiques()->with(['pneu', 'vehicule'])->limit(5)->get();
                    @endphp
                    
                    @if($alertesCritiques->count() > 0)
                        <div class="row">
                            @foreach($alertesCritiques as $alerte)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="alert alert-danger h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="alert-heading mb-2">
                                                    <i class="fas fa-exclamation-circle"></i> {{ $alerte->titre }}
                                                </h6>
                                                <p class="mb-2 small">{{ Str::limit($alerte->message, 100) }}</p>
                                                @if($alerte->pneu)
                                                    <small class="text-muted">
                                                        <i class="fas fa-circle"></i> Pneu: {{ $alerte->pneu->numero_serie }}
                                                    </small>
                                                @endif
                                                @if($alerte->vehicule)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-truck"></i> Véhicule: {{ $alerte->vehicule->immatriculation }}
                                                    </small>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $alerte->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Aucune alerte critique</h5>
                            <p class="text-muted">Votre flotte est en bon état !</p>
                            <a href="{{ route('alertes.generer') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sync-alt"></i> Analyser la flotte
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées des maintenances -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-wrench"></i> Statut des Maintenances</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-exclamation-circle text-info"></i> Déclarées</span>
                                <span class="badge bg-info fs-6">{{ $maintenances_stats['declarees'] }}</span>
                            </div>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-info" style="width: {{ $stats['total_maintenances'] > 0 ? ($maintenances_stats['declarees'] / $stats['total_maintenances']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-clock text-warning"></i> En Attente</span>
                                <span class="badge bg-warning fs-6">{{ $maintenances_stats['en_attente'] }}</span>
                            </div>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: {{ $stats['total_maintenances'] > 0 ? ($maintenances_stats['en_attente'] / $stats['total_maintenances']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-check-circle text-success"></i> Validées</span>
                                <span class="badge bg-success fs-6">{{ $maintenances_stats['validees'] }}</span>
                            </div>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: {{ $stats['total_maintenances'] > 0 ? ($maintenances_stats['validees'] / $stats['total_maintenances']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-flag-checkered text-secondary"></i> Terminées</span>
                                <span class="badge bg-secondary fs-6">{{ $maintenances_stats['terminees'] }}</span>
                            </div>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-secondary" style="width: {{ $stats['total_maintenances'] > 0 ? ($maintenances_stats['terminees'] / $stats['total_maintenances']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Résumé des notifications -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-bell"></i> Notifications</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-bell fa-3x text-info mb-3"></i>
                        <h3 class="text-info">{{ $stats['notifications_non_lues'] }}</h3>
                        <p class="text-muted">Notifications non lues</p>
                    </div>
                    <a href="{{ route('notifications.index') }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Voir les notifications
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité récente -->
    <div class="row mb-4">
        <!-- Dernières maintenances -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-wrench"></i> Dernières Maintenances</h5>
                    <a href="{{ route('maintenances.index') }}" class="btn btn-sm btn-light">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($dernieres_maintenances->count() > 0)
                        @foreach($dernieres_maintenances->take(3) as $maintenance)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                            <div>
                                <strong class="text-primary">{{ $maintenance->pneu->numero_serie ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $maintenance->pneu->marque ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $maintenance->statut === 'validee' ? 'success' : ($maintenance->statut === 'en_attente' ? 'warning' : 'info') }}">
                                    {{ ucfirst($maintenance->statut) }}
                                </span><br>
                                <small class="text-muted">{{ $maintenance->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Aucune maintenance récente</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Dernières mutations -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Dernières Mutations</h5>
                    <a href="{{ route('mutations.index') }}" class="btn btn-sm btn-light">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($dernieres_mutations->count() > 0)
                        @foreach($dernieres_mutations->take(3) as $mutation)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                            <div>
                                <strong class="text-primary">{{ $mutation->pneu->numero_serie ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $mutation->pneu->marque ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-success">{{ $mutation->vehiculeDestination->immatriculation ?? 'N/A' }}</small><br>
                                <small class="text-muted">{{ $mutation->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Aucune mutation récente</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Derniers mouvements -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-route"></i> Derniers Mouvements</h5>
                    <a href="{{ route('mouvements.index') }}" class="btn btn-sm btn-light">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($derniers_mouvements->count() > 0)
                        @foreach($derniers_mouvements->take(3) as $mouvement)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                            <div>
                                <strong class="text-primary">{{ $mouvement->vehicule->immatriculation ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $mouvement->destination ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-info">{{ number_format($mouvement->distance_parcourue) }} km</span><br>
                                <small class="text-muted">{{ $mouvement->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Aucun mouvement récent</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 des pneus les plus usés -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Top 5 des Pneus les Plus Usés</h5>
                    <a href="{{ route('pneus.index') }}" class="btn btn-sm btn-light">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($pneus_plus_uses->count() > 0)
                        <div class="row">
                            @foreach($pneus_plus_uses as $pneu)
                            <div class="col-lg-6 col-xl-4 mb-3">
                                <div class="card border-{{ $pneu->taux_usure > 80 ? 'danger' : ($pneu->taux_usure > 60 ? 'warning' : 'success') }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title text-primary mb-0">{{ $pneu->numero_serie }}</h6>
                                            <span class="badge bg-{{ $pneu->taux_usure > 80 ? 'danger' : ($pneu->taux_usure > 60 ? 'warning' : 'success') }}">
                                                {{ $pneu->taux_usure }}%
                                            </span>
                                        </div>
                                        <p class="card-text text-muted mb-2">{{ $pneu->marque }}</p>
                                        <div class="mb-2">
                                            <small class="text-muted">Véhicule:</small><br>
                                            <span class="text-success">
                                                @if($pneu->vehicule)
                                                    {{ $pneu->vehicule->immatriculation }}
                                                @else
                                                    <span class="text-muted">Non assigné</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Kilométrage:</small><br>
                                            <span class="text-info">{{ number_format($pneu->kilometrage) }} km</span>
                                        </div>
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $pneu->taux_usure > 80 ? 'danger' : ($pneu->taux_usure > 60 ? 'warning' : 'success') }}" 
                                                 style="width: {{ $pneu->taux_usure }}%"></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="badge bg-{{ $pneu->statut === 'en_service' ? 'success' : ($pneu->statut === 'en_maintenance' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($pneu->statut) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Aucun pneu trouvé</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
