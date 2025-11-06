@extends('layouts.app')

@section('title', 'Gestion des Pièces Détachées')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-cogs text-warning"></i> Gestion des Pièces Détachées</h1>
    <a href="{{ route('maintenances.declarateur') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Informations de la maintenance -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Maintenance #{{ $maintenance->id }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Véhicule:</strong><br>
                        <span class="text-success">{{ $maintenance->vehicule->immatriculation }}</span>
                        <br><small class="text-muted">{{ $maintenance->vehicule->marque }} {{ $maintenance->vehicule->modele }}</small>
                    </div>
                    <div class="col-md-6">
                        <strong>Intervention:</strong><br>
                        <span class="badge bg-danger">
                            <i class="{{ $maintenance->sous_type_curative_icon }}"></i>
                            {{ $maintenance->sous_type_curative_name }}
                        </span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <strong>Problème:</strong><br>
                        <div class="alert alert-warning mb-0">
                            {{ $maintenance->explication_cause }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire d'ajout de pièce -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus"></i> Ajouter une Pièce Détachée
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pieces-detachees.store') }}" method="POST" id="pieceForm">
                    @csrf
                    <input type="hidden" name="maintenance_id" value="{{ $maintenance->id }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type_piece" class="form-label">Type de pièce détachée <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('type_piece') is-invalid @enderror" 
                                       id="type_piece" name="type_piece" value="{{ old('type_piece') }}" required
                                       placeholder="Ex: Filtre à huile, Courroie, etc.">
                                @error('type_piece')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marque" class="form-label">Marque <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('marque') is-invalid @enderror" 
                                       id="marque" name="marque" value="{{ old('marque') }}" required
                                       placeholder="Ex: Bosch, Valeo, etc.">
                                @error('marque')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reference" class="form-label">Référence <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('reference') is-invalid @enderror" 
                                       id="reference" name="reference" value="{{ old('reference') }}" required
                                       placeholder="Ex: 123456789">
                                @error('reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="constructeur" class="form-label">Constructeur</label>
                                <input type="text" class="form-control @error('constructeur') is-invalid @enderror" 
                                       id="constructeur" name="constructeur" value="{{ old('constructeur') }}"
                                       placeholder="Ex: Mercedes, Volvo, etc.">
                                @error('constructeur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fournisseur" class="form-label">Fournisseur</label>
                                <input type="text" class="form-control @error('fournisseur') is-invalid @enderror" 
                                       id="fournisseur" name="fournisseur" value="{{ old('fournisseur') }}"
                                       placeholder="Ex: AutoPièces Plus, etc.">
                                @error('fournisseur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="cout_unitaire" class="form-label">Coût de la pièce (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('cout_unitaire') is-invalid @enderror" 
                                       id="cout_unitaire" name="cout_unitaire" value="{{ old('cout_unitaire') }}" 
                                       min="0" step="0.01" required>
                                @error('cout_unitaire')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre', 1) }}" 
                                       min="1" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Ajouter la Pièce
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des pièces détachées -->
        @if($maintenance->piecesDetachees->count() > 0)
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list"></i> Pièces Détachées ({{ $maintenance->piecesDetachees->count() }})
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
                                <th>Actions</th>
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
                                    <td>
                                        <form action="{{ route('pieces-detachees.destroy', $piece) }}" method="POST" 
                                              style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette pièce ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <th colspan="7">TOTAL GÉNÉRAL</th>
                                <th class="text-success">{{ $maintenance->montant_total_pieces_formate }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune pièce détachée</h5>
                <p class="text-muted">Ajoutez des pièces détachées pour cette maintenance.</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Résumé et actions -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calculator"></i> Résumé
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nombre de pièces:</strong><br>
                    <span class="badge bg-primary fs-6">{{ $maintenance->piecesDetachees->count() }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Montant total:</strong><br>
                    <span class="badge bg-success fs-5">{{ $maintenance->montant_total_pieces_formate }}</span>
                </div>
                
                @if($maintenance->piecesDetachees->count() > 0)
                <div class="d-grid">
                    <form action="{{ route('pieces-detachees.finaliser', $maintenance) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir finaliser cette maintenance ? Cette action l\'enverra à la direction pour validation.')">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-check-circle"></i> Finaliser la Maintenance
                        </button>
                    </form>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Ajoutez au moins une pièce détachée pour pouvoir finaliser la maintenance.
                </div>
                @endif
            </div>
        </div>

        <!-- Instructions -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Instructions
                </h5>
            </div>
            <div class="card-body">
                <h6>Étapes à suivre :</h6>
                <ol>
                    <li>Ajoutez toutes les pièces détachées nécessaires</li>
                    <li>Vérifiez les informations saisies</li>
                    <li>Cliquez sur "Finaliser la Maintenance"</li>
                    <li>La maintenance sera envoyée à la direction</li>
                </ol>
                
                <div class="alert alert-warning mt-3">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Attention:</strong> Une fois finalisée, la maintenance sera envoyée à la direction pour validation et vous ne pourrez plus la modifier.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Calcul automatique du total
document.getElementById('cout_unitaire').addEventListener('input', calculerTotal);
document.getElementById('nombre').addEventListener('input', calculerTotal);

function calculerTotal() {
    const coutUnitaire = parseFloat(document.getElementById('cout_unitaire').value) || 0;
    const nombre = parseInt(document.getElementById('nombre').value) || 0;
    const total = coutUnitaire * nombre;
    
    // Mise à jour visuelle du total (optionnel)
    console.log('Total calculé:', total);
}
</script>
@endsection
