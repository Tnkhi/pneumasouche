@extends('layouts.app')

@section('title', 'Détails de l\'Alerte')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exclamation-triangle text-warning"></i> Détails de l'Alerte</h1>
    <a href="{{ route('alertes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<!-- Messages de succès/erreur -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <!-- Informations principales -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $alerte->titre }}</h5>
                <div>
                    <span class="badge bg-{{ $alerte->couleur_priorite }} me-2">
                        {{ ucfirst($alerte->priorite) }}
                    </span>
                    <span class="badge bg-{{ $alerte->statut == 'active' ? 'success' : ($alerte->statut == 'resolue' ? 'info' : 'secondary') }}">
                        {{ ucfirst($alerte->statut) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Type:</strong> 
                        <span class="badge bg-{{ $alerte->couleur_type }}">
                            {{ ucfirst($alerte->type) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Catégorie:</strong> 
                        <span class="badge bg-secondary">{{ ucfirst($alerte->categorie) }}</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <strong>Message:</strong>
                    <p class="mt-2">{{ $alerte->message }}</p>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Date de création:</strong> {{ $alerte->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Dernière mise à jour:</strong> {{ $alerte->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                @if($alerte->date_resolution)
                    <div class="alert alert-info">
                        <strong>Résolue le:</strong> {{ $alerte->date_resolution->format('d/m/Y H:i') }}
                        @if($alerte->commentaire_resolution)
                            <br><strong>Commentaire:</strong> {{ $alerte->commentaire_resolution }}
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Données de contexte -->
        @if($alerte->donnees_contexte)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Données de Contexte</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            @foreach($alerte->donnees_contexte as $key => $value)
                                <tr>
                                    <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong></td>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Informations liées -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Éléments Liés</h5>
            </div>
            <div class="card-body">
                @if($alerte->pneu)
                    <div class="mb-3">
                        <strong>Pneu:</strong>
                        <div class="mt-1">
                            <a href="{{ route('pneus.show', $alerte->pneu) }}" class="btn btn-sm btn-outline-primary">
                                {{ $alerte->pneu->numero_serie }}
                            </a>
                            <br><small class="text-muted">{{ $alerte->pneu->marque }} {{ $alerte->pneu->modele }}</small>
                        </div>
                    </div>
                @endif

                @if($alerte->vehicule)
                    <div class="mb-3">
                        <strong>Véhicule:</strong>
                        <div class="mt-1">
                            <a href="{{ route('vehicules.show', $alerte->vehicule) }}" class="btn btn-sm btn-outline-primary">
                                {{ $alerte->vehicule->immatriculation }}
                            </a>
                            <br><small class="text-muted">{{ $alerte->vehicule->marque }} {{ $alerte->vehicule->modele }}</small>
                        </div>
                    </div>
                @endif

                @if($alerte->maintenance)
                    <div class="mb-3">
                        <strong>Maintenance:</strong>
                        <div class="mt-1">
                            <a href="{{ route('maintenances.show', $alerte->maintenance) }}" class="btn btn-sm btn-outline-primary">
                                #{{ $alerte->maintenance->id }}
                            </a>
                            <br><small class="text-muted">{{ $alerte->maintenance->motif }}</small>
                        </div>
                    </div>
                @endif

                @if($alerte->user)
                    <div class="mb-3">
                        <strong>Utilisateur:</strong>
                        <div class="mt-1">
                            <span class="badge bg-info">{{ $alerte->user->name }}</span>
                            <br><small class="text-muted">{{ $alerte->user->role }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                @if($alerte->statut == 'active')
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="resoudreAlerte({{ $alerte->id }})">
                            <i class="fas fa-check"></i> Résoudre
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="ignorerAlerte({{ $alerte->id }})">
                            <i class="fas fa-times"></i> Ignorer
                        </button>
                    </div>
                @else
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-warning" onclick="reactiverAlerte({{ $alerte->id }})">
                            <i class="fas fa-redo"></i> Réactiver
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal pour résoudre une alerte -->
<div class="modal fade" id="modalResoudre" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Résoudre l'alerte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formResoudre">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Décrivez comment l'alerte a été résolue..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Résoudre</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function resoudreAlerte(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalResoudre'));
    modal.show();
}

function ignorerAlerte(id) {
    if (confirm('Êtes-vous sûr de vouloir ignorer cette alerte ?')) {
        // Créer un formulaire pour envoyer la requête POST avec le token CSRF
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/alertes/${id}/ignorer`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function reactiverAlerte(id) {
    if (confirm('Êtes-vous sûr de vouloir réactiver cette alerte ?')) {
        // Créer un formulaire pour envoyer la requête POST avec le token CSRF
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/alertes/${id}/reactiver`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Gestion du formulaire de résolution
document.getElementById('formResoudre').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const commentaire = document.getElementById('commentaire').value;
    const alerteId = {{ $alerte->id }};
    
    // Créer un formulaire pour envoyer la requête POST avec le token CSRF
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/alertes/${alerteId}/resoudre`;
    
    // Ajouter le token CSRF
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfToken);
    
    // Ajouter le commentaire
    if (commentaire) {
        const commentaireField = document.createElement('input');
        commentaireField.type = 'hidden';
        commentaireField.name = 'commentaire';
        commentaireField.value = commentaire;
        form.appendChild(commentaireField);
    }
    
    document.body.appendChild(form);
    form.submit();
});
</script>
@endsection
