@extends('layouts.app')

@section('title', 'Session Direction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-gavel text-success"></i> Session Direction</h1>
    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fas fa-info-circle"></i>
            <strong>Rôle Direction:</strong> Vous devez valider ou rejeter les maintenances curatives finalisées par les déclarateurs.
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Maintenances en Attente d'Approbation ({{ $maintenances->total() }} maintenances)</h5>
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
                            <th>Déclarateur</th>
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
                                    <strong>{{ $maintenance->declarateur->name }}</strong>
                                    <br><small class="text-muted">{{ $maintenance->declarateur->role_name }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $maintenance->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $maintenance->piecesDetachees->count() }} pièce(s)
                                    </span>
                                    <br><small class="text-success">{{ $maintenance->montant_total_pieces_formate }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('maintenances.direction-details', $maintenance) }}" class="btn btn-sm btn-info" title="Voir détails">
                                            <i class="fas fa-eye"></i> Détails
                                        </a>
                                        @if($maintenance->peutEtreValideeParDirection())
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    data-bs-toggle="modal" data-bs-target="#validerModal{{ $maintenance->id }}" title="Valider">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" data-bs-target="#rejeterModal{{ $maintenance->id }}" title="Rejeter">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <span class="badge bg-{{ $maintenance->statut === 'validee' ? 'success' : 'danger' }}">
                                                {{ $maintenance->statut === 'validee' ? 'Validée' : 'Rejetée' }}
                                            </span>
                                        @endif
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
                <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune maintenance en attente</h5>
                <p class="text-muted">Il n'y a actuellement aucune maintenance curative en attente d'approbation par la direction.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modals de validation et rejet -->
@foreach($maintenances as $maintenance)
    <!-- Modal de validation -->
    <div class="modal fade" id="validerModal{{ $maintenance->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check"></i> Valider la Maintenance #{{ $maintenance->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('maintenances.valider-direction', $maintenance) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <strong>Véhicule:</strong> {{ $maintenance->vehicule->immatriculation }}<br>
                            <strong>Intervention:</strong> {{ $maintenance->sous_type_curative_name }}<br>
                            <strong>Coût total:</strong> {{ $maintenance->montant_total_pieces_formate }}
                        </div>
                        
                        <div class="mb-3">
                            <label for="commentaire_validation" class="form-label">Commentaire de validation (optionnel)</label>
                            <textarea class="form-control" id="commentaire_validation" name="commentaire_validation" 
                                      rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Valider la Maintenance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de rejet -->
    <div class="modal fade" id="rejeterModal{{ $maintenance->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times"></i> Rejeter la Maintenance #{{ $maintenance->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('maintenances.rejeter-direction', $maintenance) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <strong>Véhicule:</strong> {{ $maintenance->vehicule->immatriculation }}<br>
                            <strong>Intervention:</strong> {{ $maintenance->sous_type_curative_name }}<br>
                            <strong>Coût total:</strong> {{ $maintenance->montant_total_pieces_formate }}
                        </div>
                        
                        <div class="mb-3">
                            <label for="motif_rejet" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('motif_rejet') is-invalid @enderror" 
                                      id="motif_rejet" name="motif_rejet" rows="3" required
                                      placeholder="Expliquez pourquoi cette maintenance est rejetée..."></textarea>
                            @error('motif_rejet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Rejeter la Maintenance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Informations sur le workflow -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Responsabilités de la Direction
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-check text-success"></i> Validation</h6>
                        <ul>
                            <li>Vérifier la pertinence de l'intervention</li>
                            <li>Contrôler les pièces détachées proposées</li>
                            <li>Valider le coût total</li>
                            <li>Approuver l'exécution</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-times text-danger"></i> Rejet</h6>
                        <ul>
                            <li>Intervention non justifiée</li>
                            <li>Pièces détachées inappropriées</li>
                            <li>Coût trop élevé</li>
                            <li>Informations manquantes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
