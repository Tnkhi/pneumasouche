@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user text-info"></i> Détails de l'Utilisateur</h1>
    <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> Informations de l'Utilisateur
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nom complet:</strong></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Rôle:</strong></td>
                            <td>
                                @switch($user->role)
                                    @case('admin')
                                        <span class="badge bg-danger">Administrateur</span>
                                        @break
                                    @case('direction')
                                        <span class="badge bg-warning">Direction</span>
                                        @break
                                    @case('declarateur')
                                        <span class="badge bg-info">Déclarateur de bon</span>
                                        @break
                                    @case('mecanicien')
                                        <span class="badge bg-success">Mécanicien</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $user->role }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @if($user->telephone)
                        <tr>
                            <td><strong>Téléphone:</strong></td>
                            <td>{{ $user->telephone }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Date de création:</strong></td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dernière modification:</strong></td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
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
                    <i class="fas fa-cogs"></i> Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Permissions
                </h5>
            </div>
            <div class="card-body">
                @switch($user->role)
                    @case('admin')
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Accès complet</li>
                            <li><i class="fas fa-check text-success"></i> Créer des utilisateurs</li>
                            <li><i class="fas fa-check text-success"></i> Gérer toutes les données</li>
                        </ul>
                        @break
                    @case('direction')
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Valider/rejeter maintenances</li>
                            <li><i class="fas fa-check text-success"></i> Consulter toutes les données</li>
                        </ul>
                        @break
                    @case('declarateur')
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Compléter les maintenances</li>
                            <li><i class="fas fa-check text-success"></i> Consulter les données</li>
                        </ul>
                        @break
                    @case('mecanicien')
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Déclarer maintenances</li>
                            <li><i class="fas fa-check text-success"></i> Terminer maintenances</li>
                            <li><i class="fas fa-check text-success"></i> Consulter les données</li>
                        </ul>
                        @break
                @endswitch
            </div>
        </div>
    </div>
</div>
@endsection
