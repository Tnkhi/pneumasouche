@extends('layouts.app')

@section('title', 'Gestion des Mutations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exchange-alt text-warning"></i> Gestion des Mutations</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('mutations.create') }}" class="btn btn-warning">
            <i class="fas fa-plus"></i> Effectuer une Mutation
        </a>
    @endif
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('mutations.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par pneu, véhicule, motif, opérateur...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning w-100">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
        @if(request('search'))
            <div class="mt-2">
                <small class="text-muted">
                    Résultats pour : "{{ request('search') }}" 
                    <a href="{{ route('mutations.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </small>
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Historique des Mutations ({{ $mutations->total() }} mutations)</h5>
    </div>
    <div class="card-body">
        @if($mutations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Pneu</th>
                            <th>Type</th>
                            <th>Véhicule Source</th>
                            <th>Véhicule Destination</th>
                            <th>Opérateur</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mutations as $mutation)
                            <tr>
                                <td>
                                    <strong>{{ $mutation->date_mutation->format('d/m/Y') }}</strong>
                                    <br><small class="text-muted">{{ $mutation->age_mutation }} jours</small>
                                </td>
                                <td>
                                    <strong>{{ $mutation->pneu->numero_serie }}</strong>
                                    <br><small class="text-muted">{{ $mutation->pneu->marque }} - {{ $mutation->pneu->dimension }}</small>
                                </td>
                                <td>
                                    @if($mutation->type_mutation == 'Montage initial')
                                        <span class="badge bg-success">{{ $mutation->type_mutation }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $mutation->type_mutation }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($mutation->vehiculeSource)
                                        <strong>{{ $mutation->vehiculeSource->immatriculation }}</strong>
                                        <br><small class="text-muted">{{ $mutation->vehiculeSource->marque }} {{ $mutation->vehiculeSource->modele }}</small>
                                    @else
                                        <span class="text-muted">Nouveau pneu</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $mutation->vehiculeDestination->immatriculation }}</strong>
                                    <br><small class="text-muted">{{ $mutation->vehiculeDestination->marque }} {{ $mutation->vehiculeDestination->modele }}</small>
                                </td>
                                <td>
                                    @if($mutation->operateur)
                                        <i class="fas fa-user"></i> {{ $mutation->operateur }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($mutation->motif)
                                        <small>{{ Str::limit($mutation->motif, 30) }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mutations.show', $mutation) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mutations.edit', $mutation) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('mutations.delete', $mutation) }}" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Supprimer"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mutation ?\n\nPneu: {{ $mutation->pneu->numero_serie }}\nDate: {{ $mutation->date_mutation->format('d/m/Y') }}\nType: {{ $mutation->type_mutation }}\n\nCette action est irréversible !')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $mutations->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucune mutation enregistrée</h4>
                <p class="text-muted">Commencez par effectuer votre première mutation de pneu.</p>
                <a href="{{ route('mutations.create') }}" class="btn btn-warning">
                    <i class="fas fa-plus"></i> Effectuer une Mutation
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Statistiques globales -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $mutations->total() }}</h4>
                        <p class="mb-0">Total Mutations</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exchange-alt fa-2x"></i>
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
                        <h4>{{ $mutations->where('vehicule_source_id', null)->count() }}</h4>
                        <p class="mb-0">Montages Initiaux</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-plus-circle fa-2x"></i>
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
                        <h4>{{ $mutations->where('vehicule_source_id', '!=', null)->count() }}</h4>
                        <p class="mb-0">Mutations</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-arrows-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $mutations->where('date_mutation', '>=', now()->subDays(30))->count() }}</h4>
                        <p class="mb-0">Ce Mois</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
