@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-bell text-info"></i> Détails de la Notification</h1>
    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="{{ $notification->icon }} text-{{ $notification->couleur_bootstrap }}"></i> {{ $notification->title }}
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Message:</strong></td>
                            <td>{{ $notification->message }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type d'action:</strong></td>
                            <td>
                                <span class="badge bg-{{ $notification->couleur_bootstrap }}">
                                    {{ ucfirst($notification->type) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Modèle concerné:</strong></td>
                            <td>{{ $notification->model_type }}</td>
                        </tr>
                        @if($notification->model_id)
                        <tr>
                            <td><strong>ID de l'objet:</strong></td>
                            <td>{{ $notification->model_id }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Utilisateur:</strong></td>
                            <td>{{ $notification->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date de création:</strong></td>
                            <td>{{ $notification->date_formatee }}</td>
                        </tr>
                        <tr>
                            <td><strong>Statut:</strong></td>
                            <td>
                                @if($notification->is_read)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Lue
                                    </span>
                                    @if($notification->read_at)
                                        <small class="text-muted">({{ $notification->read_at->format('d/m/Y H:i') }})</small>
                                    @endif
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i> Non lue
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informations Supplémentaires
                </h5>
            </div>
            <div class="card-body">
                @if($notification->data && count($notification->data) > 0)
                    <h6><strong>Données associées:</strong></h6>
                    <ul class="list-unstyled">
                        @foreach($notification->data as $key => $value)
                            <li>
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucune donnée supplémentaire disponible.</p>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs"></i> Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(!$notification->is_read)
                        <button class="btn btn-success" onclick="marquerCommeLu({{ $notification->id }})">
                            <i class="fas fa-check"></i> Marquer comme lu
                        </button>
                    @else
                        <button class="btn btn-warning" onclick="marquerCommeNonLu({{ $notification->id }})">
                            <i class="fas fa-undo"></i> Marquer comme non lu
                        </button>
                    @endif
                    
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function marquerCommeLu(notificationId) {
    fetch(`/notifications/${notificationId}/marquer-comme-lu`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

function marquerCommeNonLu(notificationId) {
    fetch(`/notifications/${notificationId}/marquer-comme-non-lu`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
</script>
@endsection
