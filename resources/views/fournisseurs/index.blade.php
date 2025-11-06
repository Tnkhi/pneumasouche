@extends('layouts.app')

@section('title', 'Liste des Fournisseurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-truck text-success"></i> Gestion des Fournisseurs</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('fournisseurs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajouter un Fournisseur
        </a>
    @endif
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('fournisseurs.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par nom, contact, téléphone, email ou adresse...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
        @if(request('search'))
            <div class="mt-2">
                <small class="text-muted">
                    Résultats pour : "{{ request('search') }}" 
                    <a href="{{ route('fournisseurs.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </small>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Liste des Fournisseurs ({{ $fournisseurs->total() }} fournisseurs)</h5>
    </div>
    <div class="card-body">
        @if($fournisseurs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Nombre de Pneus</th>
                            <th>Valeur Totale</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fournisseurs as $fournisseur)
                            <tr>
                                <td>
                                    <strong>{{ $fournisseur->nom }}</strong>
                                </td>
                                <td>{{ $fournisseur->contact ?? 'N/A' }}</td>
                                <td>
                                    @if($fournisseur->telephone)
                                        <a href="tel:{{ $fournisseur->telephone }}" class="text-decoration-none">
                                            <i class="fas fa-phone"></i> {{ $fournisseur->telephone }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($fournisseur->email)
                                        <a href="mailto:{{ $fournisseur->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope"></i> {{ $fournisseur->email }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $fournisseur->pneus_count }}</span>
                                </td>
                                <td>
                                    @if($fournisseur->pneus_count > 0)
                                        <strong class="text-success">{{ number_format($fournisseur->valeur_totale, 0) }} FCFA</strong>
                                    @else
                                        <span class="text-muted">Aucun pneu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($fournisseur->pneus_count >= 10)
                                        <span class="badge bg-success">Principal</span>
                                    @elseif($fournisseur->pneus_count >= 5)
                                        <span class="badge bg-warning">Régulier</span>
                                    @elseif($fournisseur->pneus_count > 0)
                                        <span class="badge bg-info">Occasionnel</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                        {{ $fournisseur->pneus_count > 0 ? 'disabled' : '' }}>
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
                {{ $fournisseurs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun fournisseur enregistré</h4>
                <p class="text-muted">Commencez par ajouter votre premier fournisseur.</p>
                <a href="{{ route('fournisseurs.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter un Fournisseur
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
                        <h4>{{ $fournisseurs->total() }}</h4>
                        <p class="mb-0">Total Fournisseurs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-truck fa-2x"></i>
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
                        <h4>{{ $fournisseurs->where('pneus_count', '>=', 10)->count() }}</h4>
                        <p class="mb-0">Fournisseurs Principaux</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x"></i>
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
                        <h4>{{ $fournisseurs->where('pneus_count', '>=', 5)->where('pneus_count', '<', 10)->count() }}</h4>
                        <p class="mb-0">Fournisseurs Réguliers</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
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
                        <h4>{{ $fournisseurs->where('pneus_count', '>', 0)->where('pneus_count', '<', 5)->count() }}</h4>
                        <p class="mb-0">Fournisseurs Occasionnels</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
