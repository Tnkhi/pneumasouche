@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-route text-primary"></i> Gestion des Mouvements</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('mouvements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Mouvement
        </a>
    @endif
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('mouvements.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par véhicule, destination, utilisateur...">
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
                    <a href="{{ route('mouvements.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </small>
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list"></i> Liste des Mouvements
        </h5>
    </div>
    <div class="card-body">
        @if($mouvements->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Véhicule</th>
                            <th>Distance</th>
                            <th>Destination</th>
                            <th>Enregistré par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mouvements as $mouvement)
                            <tr>
                                <td>
                                    <strong>{{ $mouvement->date_formatee }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $mouvement->vehicule->immatriculation }}</strong><br>
                                    <small class="text-muted">{{ $mouvement->vehicule->marque }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $mouvement->distance_formatee }}</span>
                                </td>
                                <td>
                                    {{ $mouvement->destination ?? 'Non spécifiée' }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ $mouvement->user->name }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mouvements.show', $mouvement) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ? Le kilométrage des pneus sera ajusté.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
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
                {{ $mouvements->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-route fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun mouvement enregistré</h4>
                <p class="text-muted">Commencez par enregistrer le premier mouvement d'un véhicule.</p>
                <a href="{{ route('mouvements.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Enregistrer un Mouvement
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
