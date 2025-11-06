@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-plus text-success"></i> Créer un Utilisateur</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
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
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <strong>Nom complet <span class="text-danger">*</span></strong>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <strong>Email <span class="text-danger">*</span></strong>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <strong>Mot de passe <span class="text-danger">*</span></strong>
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <strong>Confirmer le mot de passe <span class="text-danger">*</span></strong>
                                </label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">
                                    <strong>Rôle <span class="text-danger">*</span></strong>
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" name="role" required>
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="direction" {{ old('role') == 'direction' ? 'selected' : '' }}>Direction</option>
                                    <option value="declarateur" {{ old('role') == 'declarateur' ? 'selected' : '' }}>Déclarateur de bon</option>
                                    <option value="mecanicien" {{ old('role') == 'mecanicien' ? 'selected' : '' }}>Mécanicien</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">
                                    <strong>Téléphone</strong>
                                </label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone') }}" 
                                       placeholder="Ex: +237 6XX XXX XXX">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Créer l'Utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Rôles Disponibles
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6><strong>Administrateur</strong></h6>
                    <small class="text-muted">Accès complet à toutes les fonctionnalités, peut créer des utilisateurs.</small>
                </div>
                
                <div class="mb-3">
                    <h6><strong>Direction</strong></h6>
                    <small class="text-muted">Peut valider ou rejeter les déclarations de maintenance.</small>
                </div>
                
                <div class="mb-3">
                    <h6><strong>Déclarateur de bon</strong></h6>
                    <small class="text-muted">Peut compléter les déclarations de maintenance (référence, bon, prix).</small>
                </div>
                
                <div class="mb-3">
                    <h6><strong>Mécanicien</strong></h6>
                    <small class="text-muted">Peut déclarer et terminer les maintenances.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
