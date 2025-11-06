@extends('layouts.app')

@section('title', 'Détails du Véhicule')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-car text-info"></i> Détails du Véhicule</h1>
    <div>
        <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">
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
                                <td><strong>Immatriculation:</strong></td>
                                <td><span class="badge bg-primary fs-6">{{ $vehicule->immatriculation }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Marque:</strong></td>
                                <td>{{ $vehicule->marque }}</td>
                            </tr>
                            <tr>
                                <td><strong>Modèle:</strong></td>
                                <td>{{ $vehicule->modele }}</td>
                            </tr>
                            <tr>
                                <td><strong>Année:</strong></td>
                                <td>
                                    @if($vehicule->annee)
                                        {{ $vehicule->annee }} 
                                        <small class="text-muted">({{ $vehicule->age }} ans)</small>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    @if($vehicule->type_vehicule)
                                        <span class="badge bg-info">{{ $vehicule->type_vehicule }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Chauffeur:</strong></td>
                                <td>
                                    @if($vehicule->chauffeur)
                                        <i class="fas fa-user"></i> {{ $vehicule->chauffeur }}
                                    @else
                                        <span class="text-muted">Non assigné</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date d'ajout:</strong></td>
                                <td>{{ $vehicule->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dernière modification:</strong></td>
                                <td>{{ $vehicule->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($vehicule->description)
                    <div class="mt-3">
                        <h6>Description :</h6>
                        <p class="text-muted">{{ $vehicule->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistiques des Pneus</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-primary">{{ $statistiques['nombre_pneus'] }}</h3>
                            <p class="mb-0">Pneus Montés</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-success">{{ number_format($statistiques['valeur_totale'], 0) }} FCFA</h3>
                            <p class="mb-0">Valeur Totale</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-warning">{{ number_format($statistiques['taux_usure_moyen'], 1) }}%</h3>
                            <p class="mb-0">Usure Moyenne</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-info">{{ number_format($statistiques['kilometrage_moyen'], 0) }} km</h3>
                            <p class="mb-0">Kilométrage Moy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Statut du véhicule -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Statut</h6>
            </div>
            <div class="card-body text-center">
                @if($statistiques['nombre_pneus'] > 0)
                    @if($vehicule->statut == 'Excellent')
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">Excellent</h5>
                        <p class="text-muted">Tous les pneus sont en bon état</p>
                    @elseif($vehicule->statut == 'Bon')
                        <i class="fas fa-thumbs-up fa-3x text-info mb-3"></i>
                        <h5 class="text-info">Bon</h5>
                        <p class="text-muted">État général satisfaisant</p>
                    @elseif($vehicule->statut == 'À surveiller')
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="text-warning">À surveiller</h5>
                        <p class="text-muted">Usure modérée détectée</p>
                    @else
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                        <h5 class="text-danger">Critique</h5>
                        <p class="text-muted">Usure importante - Remplacement urgent</p>
                    @endif
                @else
                    <i class="fas fa-exclamation-triangle fa-3x text-secondary mb-3"></i>
                    <h5 class="text-secondary">Sans Pneus</h5>
                    <p class="text-muted">Aucun pneu monté</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    @if($statistiques['nombre_pneus'] == 0)
                        <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @else
                        <button class="btn btn-danger" disabled title="Impossible de supprimer car il y a des pneus associés">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des pneus montés -->
@if($vehicule->pneus->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pneus Montés ({{ $vehicule->pneus->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>N° Série</th>
                            <th>Marque</th>
                            <th>Dimension</th>
                            <th>Fournisseur</th>
                            <th>Prix</th>
                            <th>Usure</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicule->pneus as $pneu)
                            <tr>
                                <td>{{ $pneu->numero_serie }}</td>
                                <td>{{ $pneu->marque }}</td>
                                <td><span class="badge bg-secondary">{{ $pneu->dimension }}</span></td>
                                <td>{{ $pneu->fournisseur->nom }}</td>
                                <td>{{ number_format($pneu->prix_achat, 0) }} FCFA</td>
                                <td>
                                    <div class="progress" style="height: 15px; width: 80px;">
                                        <div class="progress-bar 
                                            @if($pneu->taux_usure < 30) bg-success
                                            @elseif($pneu->taux_usure < 70) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            style="width: {{ $pneu->taux_usure }}%">
                                        </div>
                                    </div>
                                    <small>{{ number_format($pneu->taux_usure, 1) }}%</small>
                                </td>
                                <td>
                                    <a href="{{ route('pneus.show', $pneu) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection
