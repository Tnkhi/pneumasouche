@extends('layouts.app')

@section('title', 'Détails du Pneu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tire text-info"></i> Détails du Pneu</h1>
    <div>
        <a href="{{ route('pneus.edit', $pneu) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('pneus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations Générales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Numéro de Série:</strong></td>
                                <td>{{ $pneu->numero_serie }}</td>
                            </tr>
                            <tr>
                                <td><strong>Marque:</strong></td>
                                <td>{{ $pneu->marque }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dimension:</strong></td>
                                <td><span class="badge bg-primary fs-6">{{ $pneu->dimension }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Indice de Vitesse:</strong></td>
                                <td><span class="badge bg-info">{{ $pneu->indice_vitesse }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Indice de Charge:</strong></td>
                                <td><span class="badge bg-info">{{ $pneu->indice_charge }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Prix d'Achat:</strong></td>
                                <td><span class="text-success fw-bold">{{ number_format($pneu->prix_achat, 0) }} FCFA</span></td>
                            </tr>
                            <tr>
                                <td><strong>Date de Montage:</strong></td>
                                <td>{{ $pneu->date_montage->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Âge:</strong></td>
                                <td>{{ $pneu->age }} jours</td>
                            </tr>
                            <tr>
                                <td><strong>Durée de Vie:</strong></td>
                                <td>{{ number_format($pneu->duree_vie) }} km</td>
                            </tr>
                            <tr>
                                <td><strong>Kilométrage:</strong></td>
                                <td>{{ number_format($pneu->kilometrage) }} km</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">État et Performance</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Taux d'Usure</h6>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar 
                                @if($pneu->taux_usure < 30) bg-success
                                @elseif($pneu->taux_usure < 70) bg-warning
                                @else bg-danger
                                @endif" 
                                style="width: {{ $pneu->taux_usure }}%">
                                {{ number_format($pneu->taux_usure, 1) }}%
                            </div>
                        </div>
                        <p class="text-muted small">
                            @if($pneu->taux_usure < 30)
                                <i class="fas fa-check-circle text-success"></i> Excellent état
                            @elseif($pneu->taux_usure < 70)
                                <i class="fas fa-exclamation-triangle text-warning"></i> Usure modérée
                            @else
                                <i class="fas fa-exclamation-circle text-danger"></i> Usure importante
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Valeur d'Exploitation Restante</h6>
                        <div class="text-center">
                            <h3 class="text-success">{{ number_format($pneu->valeur_exploitation_restante, 0) }} FCFA</h3>
                            <p class="text-muted small">
                                Valeur résiduelle basée sur l'usure
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Coûts et Dépenses - Alignée sous État et Performance -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calculator"></i> Analyse des Coûts et Dépenses
                </h6>
            </div>
            <div class="card-body">
                @php
                    $resumeCouts = $pneu->obtenirResumeCouts();
                    $historiqueDepenses = $pneu->obtenirHistoriqueDepenses();
                @endphp
                
                <!-- Résumé des coûts - Design élégant -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="text-center p-3 border rounded bg-light">
                            <h5 class="text-primary mb-1">{{ number_format($resumeCouts['prix_achat'], 0, ',', ' ') }} FCFA</h5>
                            <small class="text-muted">Prix d'achat</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 border rounded bg-light">
                            <h5 class="text-warning mb-1">{{ number_format($resumeCouts['cout_maintenances'], 0, ',', ' ') }} FCFA</h5>
                            <small class="text-muted">Coût maintenances</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="text-center p-3 border rounded bg-light">
                            <h5 class="text-success mb-1">{{ number_format($resumeCouts['prix_reviement'], 0, ',', ' ') }} FCFA</h5>
                            <small class="text-muted">Prix de revient</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 border rounded bg-light">
                            <h5 class="text-info mb-1">{{ number_format($resumeCouts['cout_par_kilometre'], 2, ',', ' ') }} FCFA/km</h5>
                            <small class="text-muted">Coût par km</small>
                        </div>
                    </div>
                </div>

                <!-- Métriques de performance -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded bg-light">
                            <h6 class="text-info mb-1">{{ number_format($resumeCouts['kilometrage'], 0, ',', ' ') }} km</h6>
                            <small class="text-muted">Kilométrage</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded bg-light">
                            <h6 class="text-warning mb-1">{{ number_format($resumeCouts['taux_usure'], 1) }}%</h6>
                            <small class="text-muted">Usure</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded bg-light">
                            <h6 class="mb-1">
                                @if($resumeCouts['cout_par_kilometre'] < 50)
                                    <span class="text-success">Excellente</span>
                                @elseif($resumeCouts['cout_par_kilometre'] < 100)
                                    <span class="text-warning">Bonne</span>
                                @else
                                    <span class="text-danger">À améliorer</span>
                                @endif
                            </h6>
                            <small class="text-muted">Efficacité</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Véhicule</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-car fa-3x text-primary mb-3"></i>
                    <h5>{{ $pneu->vehicule->immatriculation }}</h5>
                    <p class="text-muted">{{ $pneu->vehicule->marque }} {{ $pneu->vehicule->modele }}</p>
                    @if($pneu->vehicule->annee)
                        <p class="text-muted">Année: {{ $pneu->vehicule->annee }}</p>
                    @endif
                    <a href="{{ route('vehicules.show', $pneu->vehicule) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> Voir le véhicule
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Fournisseur</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-truck fa-3x text-success mb-3"></i>
                    <h5>{{ $pneu->fournisseur->nom }}</h5>
                    @if($pneu->fournisseur->contact)
                        <p class="text-muted">Contact: {{ $pneu->fournisseur->contact }}</p>
                    @endif
                    @if($pneu->fournisseur->telephone)
                        <p class="text-muted">Tél: {{ $pneu->fournisseur->telephone }}</p>
                    @endif
                    <a href="{{ route('fournisseurs.show', $pneu->fournisseur) }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-eye"></i> Voir le fournisseur
                    </a>
                </div>
            </div>
        </div>

        <!-- Historique des Dépenses -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-history"></i> Historique des Dépenses
                </h6>
            </div>
            <div class="card-body">
                @php
                    $historiqueDepenses = $pneu->obtenirHistoriqueDepenses();
                @endphp
                
                @if(count($historiqueDepenses) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th class="text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historiqueDepenses as $depense)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($depense['date'])->format('d/m/Y') }}</td>
                                        <td>
                                            @if($depense['type'] === 'achat')
                                                <span class="badge bg-primary">Achat</span>
                                            @else
                                                <span class="badge bg-warning">Maintenance</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $depense['description'] }}
                                            @if(isset($depense['details']) && $depense['details'])
                                                <br><small class="text-muted">{{ Str::limit($depense['details'], 50) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($depense['montant'], 0, ',', ' ') }} FCFA</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th colspan="3">TOTAL</th>
                                    <th class="text-end">{{ number_format($pneu->obtenirResumeCouts()['prix_reviement'], 0, ',', ' ') }} FCFA</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Aucune dépense enregistrée pour ce pneu.
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('pneus.mutations', $pneu) }}" class="btn btn-info">
                        <i class="fas fa-history"></i> Historique des Mutations
                    </a>
                    <a href="{{ route('pneus.edit', $pneu) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('pneus.destroy', $pneu) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pneu ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
