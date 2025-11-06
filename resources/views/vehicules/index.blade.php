@extends('layouts.app')

@section('title', 'Liste des Véhicules')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-car text-primary"></i> Gestion des Véhicules</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('vehicules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Véhicule
        </a>
    @endif
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('vehicules.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par immatriculation, marque, modèle, type, chauffeur...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
        @if(request('search'))
            <div class="mt-2">
                <small class="text-muted">
                    Résultats pour : "{{ request('search') }}" 
                    <a href="{{ route('vehicules.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </small>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Liste des Véhicules ({{ $vehicules->total() }} véhicules)</h5>
    </div>
    <div class="card-body">
        @if($vehicules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Immatriculation</th>
                            <th>Marque/Modèle</th>
                            <th>Année</th>
                            <th>Type</th>
                            <th>Chauffeur</th>
                            <th>Nombre de Pneus</th>
                            <th>Valeur Pneus</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicules as $vehicule)
                            <tr>
                                <td>
                                    <strong>{{ $vehicule->immatriculation }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $vehicule->marque }}</strong><br>
                                    <small class="text-muted">{{ $vehicule->modele }}</small>
                                </td>
                                <td>
                                    @if($vehicule->annee)
                                        {{ $vehicule->annee }}
                                        <br><small class="text-muted">({{ $vehicule->age }} ans)</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($vehicule->type_vehicule)
                                        <span class="badge bg-info">{{ $vehicule->type_vehicule }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($vehicule->chauffeur)
                                        <i class="fas fa-user"></i> {{ $vehicule->chauffeur }}
                                    @else
                                        <span class="text-muted">Non assigné</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $vehicule->pneus_count }}</span>
                                </td>
                                <td>
                                    @if($vehicule->pneus_count > 0)
                                        <strong class="text-success">{{ number_format($vehicule->valeur_totale_pneus, 0) }} FCFA</strong>
                                    @else
                                        <span class="text-muted">Aucun pneu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($vehicule->pneus_count > 0)
                                        <span class="badge bg-{{ $vehicule->couleur_statut }}">
                                            {{ $vehicule->statut }}
                                        </span>
                                        <br><small class="text-muted">{{ number_format($vehicule->taux_usure_moyen, 1) }}% usure</small>
                                    @else
                                        <span class="badge bg-secondary">Sans pneus</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                        {{ $vehicule->pneus_count > 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $vehicules->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-car fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun véhicule enregistré</h4>
                <p class="text-muted">Commencez par ajouter votre premier véhicule.</p>
                <a href="{{ route('vehicules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un Véhicule
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Statistiques globales -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $vehicules->total() }}</h4>
                        <p class="mb-0">Total Véhicules</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-car fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $vehicules->where('pneus_count', '>', 0)->count() }}</h4>
                        <p class="mb-0">Avec Pneus</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tire fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $vehicules->where('chauffeur', '!=', null)->count() }}</h4>
                        <p class="mb-0">Avec Chauffeur</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $vehicules->where('pneus_count', 0)->count() }}</h4>
                        <p class="mb-0">Sans Pneus</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
