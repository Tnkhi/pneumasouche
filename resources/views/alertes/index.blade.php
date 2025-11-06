@extends('layouts.app')

@section('title', 'Alertes Intelligentes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exclamation-triangle text-warning"></i> Alertes Intelligentes</h1>
    <div>
        <a href="{{ route('alertes.generer') }}" class="btn btn-primary">
            <i class="fas fa-sync-alt"></i> Générer Alertes
        </a>
    </div>
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

<!-- Statistiques des alertes -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $statistiques['critiques'] ?? 0 }}</h4>
                        <p class="mb-0">Critiques</p>
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $statistiques['actives'] ?? 0 }}</h4>
                        <p class="mb-0">Actives</p>
                    </div>
                    <i class="fas fa-bell fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $statistiques['total'] ?? 0 }}</h4>
                        <p class="mb-0">Total</p>
                    </div>
                    <i class="fas fa-list fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ ($statistiques['total'] ?? 0) - ($statistiques['actives'] ?? 0) }}</h4>
                        <p class="mb-0">Résolues</p>
                    </div>
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('alertes.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="resolue" {{ request('statut') == 'resolue' ? 'selected' : '' }}>Résolue</option>
                    <option value="ignoree" {{ request('statut') == 'ignoree' ? 'selected' : '' }}>Ignorée</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="priorite" class="form-label">Priorité</label>
                <select name="priorite" id="priorite" class="form-select">
                    <option value="">Toutes les priorités</option>
                    <option value="critique" {{ request('priorite') == 'critique' ? 'selected' : '' }}>Critique</option>
                    <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select name="categorie" id="categorie" class="form-select">
                    <option value="">Toutes les catégories</option>
                    <option value="usure" {{ request('categorie') == 'usure' ? 'selected' : '' }}>Usure</option>
                    <option value="maintenance" {{ request('categorie') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="mutation" {{ request('categorie') == 'mutation' ? 'selected' : '' }}>Mutation</option>
                    <option value="stock" {{ request('categorie') == 'stock' ? 'selected' : '' }}>Stock</option>
                    <option value="performance" {{ request('categorie') == 'performance' ? 'selected' : '' }}>Performance</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Recherche</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des alertes -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Liste des Alertes</h5>
    </div>
    <div class="card-body">
        @if($alertes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Priorité</th>
                            <th>Titre</th>
                            <th>Message</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alertes as $alerte)
                            <tr class="{{ $alerte->est_urgente ? 'table-danger' : '' }}">
                                <td>
                                    <span class="badge bg-{{ $alerte->couleur_priorite }}">
                                        {{ ucfirst($alerte->priorite) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $alerte->titre }}</strong>
                                    @if($alerte->pneu)
                                        <br><small class="text-muted">Pneu: {{ $alerte->pneu->numero_serie }}</small>
                                    @endif
                                    @if($alerte->vehicule)
                                        <br><small class="text-muted">Véhicule: {{ $alerte->vehicule->immatriculation }}</small>
                                    @endif
                                </td>
                                <td>{{ Str::limit($alerte->message, 100) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($alerte->categorie) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $alerte->statut == 'active' ? 'success' : ($alerte->statut == 'resolue' ? 'info' : 'secondary') }}">
                                        {{ ucfirst($alerte->statut) }}
                                    </span>
                                </td>
                                <td>{{ $alerte->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('alertes.show', $alerte) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($alerte->statut == 'active')
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="resoudreAlerte({{ $alerte->id }})">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="ignorerAlerte({{ $alerte->id }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="reactiverAlerte({{ $alerte->id }})">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $alertes->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune alerte trouvée</h5>
                <p class="text-muted">Générez des alertes intelligentes pour analyser votre flotte.</p>
                <a href="{{ route('alertes.generer') }}" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Générer Alertes
                </a>
            </div>
        @endif
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
let alerteIdEnCours = null;

function resoudreAlerte(id) {
    alerteIdEnCours = id;
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
    
    if (!alerteIdEnCours) return;
    
    const commentaire = document.getElementById('commentaire').value;
    
    // Créer un formulaire pour envoyer la requête POST avec le token CSRF
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/alertes/${alerteIdEnCours}/resoudre`;
    
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

// Réinitialiser le modal quand il se ferme
document.getElementById('modalResoudre').addEventListener('hidden.bs.modal', function() {
    alerteIdEnCours = null;
    document.getElementById('commentaire').value = '';
});
</script>
@endsection
