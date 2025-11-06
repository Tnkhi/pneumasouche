@extends('layouts.app')

@section('title', 'Liste des Pneus')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tire text-primary"></i> Gestion des Pneus</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('pneus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Pneu
        </a>
    @endif
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('pneus.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par numéro de série, marque, modèle, dimension, fournisseur ou véhicule...">
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
                    <a href="{{ route('pneus.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </small>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Liste des Pneus ({{ $pneus->total() }} pneus)</h5>
    </div>
    <div class="card-body">
        @if($pneus->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N° Série</th>
                            <th>Marque</th>
                            <th>Dimension</th>
                            <th>Véhicule</th>
                            <th>Fournisseur</th>
                            <th>Date Montage</th>
                            <th>Kilométrage</th>
                            <th>Taux d'Usure</th>
                            <th>Valeur Restante</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pneus as $pneu)
                            <tr>
                                <td>
                                    <strong>{{ $pneu->numero_serie }}</strong>
                                </td>
                                <td>{{ $pneu->marque }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $pneu->dimension }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $pneu->vehicule->immatriculation }}</small><br>
                                    <small>{{ $pneu->vehicule->marque }} {{ $pneu->vehicule->modele }}</small>
                                </td>
                                <td>{{ $pneu->fournisseur->nom }}</td>
                                <td>{{ $pneu->date_montage->format('d/m/Y') }}</td>
                                <td>{{ number_format($pneu->kilometrage) }} km</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                            <div class="progress-bar 
                                                @if($pneu->taux_usure < 30) bg-success
                                                @elseif($pneu->taux_usure < 70) bg-warning
                                                @else bg-danger
                                                @endif" 
                                                style="width: {{ $pneu->taux_usure }}%">
                                            </div>
                                        </div>
                                        <small>{{ number_format($pneu->taux_usure, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($pneu->valeur_exploitation_restante, 0) }} FCFA</strong>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pneus.show', $pneu) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('pneus.edit', $pneu) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pneus.destroy', $pneu) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pneu ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Supprimer définitivement">
                                                    <i class="fas fa-times"></i>
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
                {{ $pneus->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tire fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun pneu enregistré</h4>
                <p class="text-muted">Commencez par ajouter votre premier pneu.</p>
                <a href="{{ route('pneus.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un Pneu
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
