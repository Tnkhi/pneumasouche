@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-bell text-primary"></i> Notifications</h1>
    <div>
        <button class="btn btn-success" onclick="marquerToutesCommeLues()">
            <i class="fas fa-check-double"></i> Marquer toutes comme lues
        </button>
        <button type="button" class="btn btn-warning" onclick="supprimerLues()">
            <i class="fas fa-trash"></i> Supprimer les lues
        </button>
    </div>
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('notifications.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Rechercher par titre, message, type ou utilisateur...">
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
                    <a href="{{ route('notifications.index') }}" class="text-decoration-none ms-2">
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

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $stats['total'] }}</h5>
                <p class="card-text">Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-warning">{{ $stats['non_lues'] }}</h5>
                <p class="card-text">Non lues</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">{{ $stats['lues'] }}</h5>
                <p class="card-text">Lues</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-info">{{ $stats['aujourd_hui'] }}</h5>
                <p class="card-text">Aujourd'hui</p>
            </div>
        </div>
    </div>
</div>


<!-- Liste des notifications -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list"></i> Liste des Notifications
        </h5>
    </div>
    <div class="card-body">
        @if($notifications->count() > 0)
            <div class="list-group">
                @foreach($notifications as $notification)
                    <div class="list-group-item {{ $notification->is_read ? '' : 'bg-light' }}">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="{{ $notification->icon }} text-{{ $notification->couleur_bootstrap }}" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 {{ $notification->is_read ? '' : 'fw-bold' }}">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="badge bg-warning">Nouveau</span>
                                        @endif
                                    </h6>
                                    <p class="mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $notification->user->name }} • 
                                        <i class="fas fa-clock"></i> {{ $notification->temps_relatif }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <a href="{{ route('notifications.show', $notification) }}" class="btn btn-outline-info btn-sm" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$notification->is_read)
                                        <button class="btn btn-outline-success btn-sm" onclick="marquerCommeLu({{ $notification->id }})" title="Marquer comme lu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucune notification</h4>
                <p class="text-muted">Aucune notification ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<script>
function marquerCommeLu(notificationId) {
    console.log('Tentative de marquer comme lu:', notificationId);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF non trouvé');
        return;
    }
    
    fetch(`/notifications/${notificationId}/marquer-comme-lu`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        console.log('Réponse reçue:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Données reçues:', data);
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Erreur inconnue'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la requête: ' + error.message);
    });
}

function marquerToutesCommeLues() {
    if (confirm('Êtes-vous sûr de vouloir marquer toutes les notifications comme lues ?')) {
        console.log('Tentative de marquer toutes comme lues');
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('Token CSRF non trouvé');
            return;
        }
        
        fetch('/notifications/marquer-toutes-comme-lues', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            console.log('Réponse reçue:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Erreur inconnue'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la requête: ' + error.message);
        });
    }
}

function supprimerLues() {
    if (confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications lues ?')) {
        console.log('Tentative de suppression des notifications lues');
        
        // Redirection simple vers la route
        window.location.href = '{{ route("notifications.supprimer-lues") }}';
        return false; // Empêcher le comportement par défaut du lien
    }
    return false; // Empêcher la navigation si l'utilisateur annule
}
</script>
@endsection
