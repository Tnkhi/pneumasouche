@extends('layouts.app')

@section('title', 'Détails Complets - Direction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye text-info"></i> Détails Complets - Maintenance #{{ $maintenance->id }}</h1>
    <a href="{{ route('maintenances.direction') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Informations générales -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Informations Générales
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Type de Maintenance:</strong><br>
                        <span class="badge bg-warning fs-6">Maintenance Curative</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Statut:</strong><br>
                        <span class="badge bg-{{ $maintenance->statut_color }} fs-6">
                            {{ $maintenance->statut_name }}
                        </span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Étape:</strong><br>
                        <span class="badge bg-secondary">{{ $maintenance->etape_name }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Date de Déclaration:</strong><br>
                        <span class="text-muted">{{ $maintenance->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails de l'intervention -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-wrench"></i> Détails de l'Intervention
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Véhicule Concerné:</strong><br>
                        <span class="text-success fs-5">{{ $maintenance->vehicule->immatriculation }}</span>
                        <br><small class="text-muted">{{ $maintenance->vehicule->marque }} {{ $maintenance->vehicule->modele }}</small>
                        <br><small class="text-muted">Chauffeur: {{ $maintenance->vehicule->chauffeur ?? 'Non assigné' }}</small>
                    </div>
                    <div class="col-md-6">
                        <strong>Type d'Intervention:</strong><br>
                        <span class="badge bg-danger fs-6">
                            <i class="{{ $maintenance->sous_type_curative_icon }}"></i>
                            {{ $maintenance->sous_type_curative_name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spécifications techniques (Mécanicien) -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools"></i> Spécifications Techniques (Mécanicien)
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Prérequis (Besoins de base minimale):</strong><br>
                        <div class="alert alert-info mb-2">
                            {{ $maintenance->prerequis }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <strong>Requis (Ce qu'il faut vraiment):</strong><br>
                        <div class="alert alert-success mb-2">
                            {{ $maintenance->requis }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Résultat Attendu:</strong><br>
                        <div class="alert alert-primary mb-2">
                            {{ $maintenance->resultat_attendu }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <strong>Explication sur la Cause:</strong><br>
                        <div class="alert alert-secondary mb-2">
                            {{ $maintenance->explication_cause }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pièces détachées (Déclarateur) -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs"></i> Pièces Détachées (Déclarateur) - {{ $maintenance->piecesDetachees->count() }} pièce(s)
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Marque</th>
                                <th>Référence</th>
                                <th>Constructeur</th>
                                <th>Fournisseur</th>
                                <th>Quantité</th>
                                <th>Coût Unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenance->piecesDetachees as $piece)
                                <tr>
                                    <td><strong>{{ $piece->type_piece }}</strong></td>
                                    <td>{{ $piece->marque }}</td>
                                    <td><code>{{ $piece->reference }}</code></td>
                                    <td>{{ $piece->constructeur ?? '-' }}</td>
                                    <td>{{ $piece->fournisseur ?? '-' }}</td>
                                    <td><span class="badge bg-primary">{{ $piece->nombre }}</span></td>
                                    <td>{{ $piece->cout_unitaire_formate }}</td>
                                    <td><strong class="text-success">{{ $piece->montant_total_formate }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <th colspan="7">TOTAL GÉNÉRAL</th>
                                <th class="text-success fs-5">{{ $maintenance->montant_total_pieces_formate }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Utilisateurs impliqués -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users"></i> Utilisateurs Impliqués
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Mécanicien (Déclarateur):</strong><br>
                    <span class="text-info">{{ $maintenance->mecanicien->name }}</span>
                    <br><small class="text-muted">{{ $maintenance->mecanicien->role_name }}</small>
                    <br><small class="text-muted">Déclaré le {{ $maintenance->created_at->format('d/m/Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Déclarateur (Validation):</strong><br>
                    <span class="text-success">{{ $maintenance->declarateur->name }}</span>
                    <br><small class="text-muted">{{ $maintenance->declarateur->role_name }}</small>
                    @if($maintenance->date_validation_declarateur)
                        <br><small class="text-muted">Validé le {{ $maintenance->date_validation_declarateur->format('d/m/Y H:i') }}</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions de la direction -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-gavel"></i> Actions Direction
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" 
                            data-bs-toggle="modal" data-bs-target="#validerModal">
                        <i class="fas fa-check"></i> Valider la Maintenance
                    </button>
                    <button type="button" class="btn btn-danger" 
                            data-bs-toggle="modal" data-bs-target="#rejeterModal">
                        <i class="fas fa-times"></i> Rejeter la Maintenance
                    </button>
                </div>
            </div>
        </div>

        <!-- Résumé financier -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calculator"></i> Résumé Financier
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nombre de pièces:</strong><br>
                    <span class="badge bg-primary fs-6">{{ $maintenance->piecesDetachees->count() }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Coût total des pièces:</strong><br>
                    <span class="badge bg-success fs-5">{{ $maintenance->montant_total_pieces_formate }}</span>
                </div>
                
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle"></i> 
                        Ce montant représente le coût total des pièces détachées nécessaires pour cette maintenance curative.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de validation -->
<div class="modal fade" id="validerModal" tabindex="-1">
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
<div class="modal fade" id="rejeterModal" tabindex="-1">
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
@endsection
