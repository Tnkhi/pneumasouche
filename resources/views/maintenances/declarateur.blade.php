@extends('layouts.app')

@section('title', 'Session Déclarateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-check text-warning"></i> Session Déclarateur</h1>
    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Rôle Déclarateur:</strong> Vous devez compléter les maintenances curatives déclarées par les mécaniciens en ajoutant les pièces détachées nécessaires.
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Maintenances en Attente de Validation ({{ $maintenances->total() }} maintenances)</h5>
    </div>
    <div class="card-body">
        @if($maintenances->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Véhicule</th>
                            <th>Intervention</th>
                            <th>Mécanicien</th>
                            <th>Date</th>
                            <th>Pièces</th>
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
                                    <strong>{{ $maintenance->vehicule->immatriculation }}</strong>
                                    <br><small class="text-muted">{{ $maintenance->vehicule->marque }} {{ $maintenance->vehicule->modele }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="{{ $maintenance->sous_type_curative_icon }}"></i>
                                        {{ $maintenance->sous_type_curative_name }}
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
                                    @if($maintenance->piecesDetachees->count() > 0)
                                        <span class="badge bg-success">
                                            {{ $maintenance->piecesDetachees->count() }} pièce(s)
                                        </span>
                                        <br><small class="text-success">{{ $maintenance->montant_total_pieces_formate }}</small>
                                    @else
                                        <span class="badge bg-warning">Aucune pièce</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pieces-detachees.create', $maintenance) }}" class="btn btn-sm btn-warning" title="Gérer les pièces">
                                            <i class="fas fa-cogs"></i> Gérer les Pièces
                                        </a>
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
                <i class="fas fa-user-check fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune maintenance en attente</h5>
                <p class="text-muted">Il n'y a actuellement aucune maintenance curative en attente de validation par le déclarateur.</p>
            </div>
        @endif
    </div>
</div>

<!-- Informations sur le workflow -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Workflow des Maintenances Curatives
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="badge bg-primary rounded-circle p-3 mb-2">
                                <i class="fas fa-wrench fa-2x"></i>
                            </div>
                            <h6>1. Déclaration</h6>
                            <small class="text-muted">Le mécanicien déclare la maintenance curative</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="badge bg-warning rounded-circle p-3 mb-2">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                            <h6>2. Validation Déclarateur</h6>
                            <small class="text-muted">Vous ajoutez les pièces détachées</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="badge bg-success rounded-circle p-3 mb-2">
                                <i class="fas fa-gavel fa-2x"></i>
                            </div>
                            <h6>3. Approbation Direction</h6>
                            <small class="text-muted">La direction valide ou rejette</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="badge bg-info rounded-circle p-3 mb-2">
                                <i class="fas fa-tools fa-2x"></i>
                            </div>
                            <h6>4. Exécution</h6>
                            <small class="text-muted">Le mécanicien exécute la maintenance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
