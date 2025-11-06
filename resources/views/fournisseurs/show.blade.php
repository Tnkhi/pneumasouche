@extends('layouts.app')

@section('title', 'Détails du Fournisseur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-truck text-info"></i> Détails du Fournisseur</h1>
    <div>
        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">
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
                                <td><strong>Nom:</strong></td>
                                <td>{{ $fournisseur->nom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact:</strong></td>
                                <td>{{ $fournisseur->contact ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Téléphone:</strong></td>
                                <td>
                                    @if($fournisseur->telephone)
                                        <a href="tel:{{ $fournisseur->telephone }}" class="text-decoration-none">
                                            <i class="fas fa-phone"></i> {{ $fournisseur->telephone }}
                                        </a>
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
                                <td><strong>Email:</strong></td>
                                <td>
                                    @if($fournisseur->email)
                                        <a href="mailto:{{ $fournisseur->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope"></i> {{ $fournisseur->email }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date d'ajout:</strong></td>
                                <td>{{ $fournisseur->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dernière modification:</strong></td>
                                <td>{{ $fournisseur->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($fournisseur->adresse)
                    <div class="mt-3">
                        <h6>Adresse :</h6>
                        <p class="text-muted">{{ $fournisseur->adresse }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistiques</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-primary">{{ $statistiques['nombre_pneus'] }}</h3>
                            <p class="mb-0">Pneus Fournis</p>
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
                            <h3 class="text-info">{{ number_format($statistiques['duree_vie_moyenne'], 0) }} km</h3>
                            <p class="mb-0">Durée de Vie Moy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes automatiques -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Évaluation Automatique</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <i class="fas fa-chart-line"></i>
                    <strong>Notes basées sur les statistiques :</strong>
                    <p class="mb-0 mt-2">{{ $fournisseur->notes }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Statut du fournisseur -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Statut</h6>
            </div>
            <div class="card-body text-center">
                @if($statistiques['nombre_pneus'] >= 10)
                    <i class="fas fa-star fa-3x text-success mb-3"></i>
                    <h5 class="text-success">Fournisseur Principal</h5>
                    <p class="text-muted">Plus de 10 pneus fournis</p>
                @elseif($statistiques['nombre_pneus'] >= 5)
                    <i class="fas fa-check-circle fa-3x text-warning mb-3"></i>
                    <h5 class="text-warning">Fournisseur Régulier</h5>
                    <p class="text-muted">Entre 5 et 9 pneus fournis</p>
                @elseif($statistiques['nombre_pneus'] > 0)
                    <i class="fas fa-clock fa-3x text-info mb-3"></i>
                    <h5 class="text-info">Fournisseur Occasionnel</h5>
                    <p class="text-muted">Moins de 5 pneus fournis</p>
                @else
                    <i class="fas fa-exclamation-triangle fa-3x text-secondary mb-3"></i>
                    <h5 class="text-secondary">Fournisseur Inactif</h5>
                    <p class="text-muted">Aucun pneu fourni</p>
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
                    <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    @if($statistiques['nombre_pneus'] == 0)
                        <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
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

<!-- Liste des pneus fournis -->
@if($fournisseur->pneus->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pneus Fournis ({{ $fournisseur->pneus->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>N° Série</th>
                            <th>Marque</th>
                            <th>Dimension</th>
                            <th>Véhicule</th>
                            <th>Prix</th>
                            <th>Usure</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fournisseur->pneus as $pneu)
                            <tr>
                                <td>{{ $pneu->numero_serie }}</td>
                                <td>{{ $pneu->marque }}</td>
                                <td><span class="badge bg-secondary">{{ $pneu->dimension }}</span></td>
                                <td>{{ $pneu->vehicule->immatriculation }}</td>
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
