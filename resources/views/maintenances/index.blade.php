@extends('layouts.app')

@section('title', 'Maintenances')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-wrench text-primary"></i> Maintenances</h1>
    @if(auth()->user()->isMecanicien() || auth()->user()->isAdmin())
        <a href="{{ route('maintenances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Déclarer une Maintenance
        </a>
    @endif
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filtres</h5>
                <form method="GET" action="{{ route('maintenances.index') }}">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Rechercher par véhicule, mécanicien...">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Navigation</h5>
                <div class="d-flex gap-2">
                    @if(auth()->user()->isDeclarateur() || auth()->user()->isAdmin())
                        <a href="{{ route('maintenances.declarateur') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-user-check"></i> Session Déclarateur
                        </a>
                    @endif
                    @if(auth()->user()->isDirection())
                        <a href="{{ route('maintenances.direction') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-gavel"></i> Session Direction
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Liste des Maintenances ({{ $maintenances->total() }} maintenances)</h5>
    </div>
    <div class="card-body">
        @if($maintenances->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Véhicule</th>
                            <th>Intervention</th>
                            <th>Statut</th>
                            <th>Étape</th>
                            <th>Mécanicien</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenances as $maintenance)
                            <tr>
                                <td>
                                    <strong>#{{ $maintenance->id }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $maintenance->type_maintenance === 'curative' ? 'warning' : 'info' }}">
                                        {{ $maintenance->type_maintenance_name }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $maintenance->vehicule->immatriculation }}</strong>
                                    <br><small class="text-muted">{{ $maintenance->vehicule->marque }} {{ $maintenance->vehicule->modele }}</small>
                                </td>
                                <td>
                                    @if($maintenance->type_maintenance === 'curative')
                                        <span class="badge bg-danger">
                                            <i class="{{ $maintenance->sous_type_curative_icon }}"></i>
                                            {{ $maintenance->sous_type_curative_name }}
                                        </span>
                                    @else
                                        <span class="badge bg-info">Préventive</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $maintenance->statut_color }} fs-6">
                                        {{ $maintenance->statut_name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $maintenance->etape_name }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $maintenance->mecanicien->name }}</strong>
                                    <br><small class="text-muted">{{ $maintenance->mecanicien->role_name }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $maintenance->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $maintenances->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-wrench fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune maintenance trouvée</h5>
                <p class="text-muted">Il n'y a actuellement aucune maintenance dans le système.</p>
                @if(auth()->user()->isMecanicien() || auth()->user()->isAdmin())
                    <a href="{{ route('maintenances.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Déclarer la première maintenance
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection