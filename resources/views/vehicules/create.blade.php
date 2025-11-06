@extends('layouts.app')

@section('title', 'Ajouter un Véhicule')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus text-primary"></i> Ajouter un Véhicule</h1>
    <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations du Véhicule</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vehicules.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="immatriculation" class="form-label">Immatriculation *</label>
                            <input type="text" class="form-control @error('immatriculation') is-invalid @enderror" 
                                   id="immatriculation" name="immatriculation" value="{{ old('immatriculation') }}" 
                                   placeholder="Ex: CI-123-AB" required>
                            @error('immatriculation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="chauffeur" class="form-label">Chauffeur</label>
                            <input type="text" class="form-control @error('chauffeur') is-invalid @enderror" 
                                   id="chauffeur" name="chauffeur" value="{{ old('chauffeur') }}" 
                                   placeholder="Nom du chauffeur">
                            @error('chauffeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="marque" class="form-label">Marque *</label>
                            <input type="text" class="form-control @error('marque') is-invalid @enderror" 
                                   id="marque" name="marque" value="{{ old('marque') }}" 
                                   placeholder="Ex: Toyota" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modele" class="form-label">Modèle *</label>
                            <input type="text" class="form-control @error('modele') is-invalid @enderror" 
                                   id="modele" name="modele" value="{{ old('modele') }}" 
                                   placeholder="Ex: Hilux" required>
                            @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="annee" class="form-label">Année</label>
                            <input type="number" class="form-control @error('annee') is-invalid @enderror" 
                                   id="annee" name="annee" value="{{ old('annee') }}" 
                                   min="1900" max="{{ date('Y') }}" placeholder="Ex: 2020">
                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type_vehicule" class="form-label">Type de Véhicule</label>
                            <select class="form-select @error('type_vehicule') is-invalid @enderror" 
                                    id="type_vehicule" name="type_vehicule">
                                <option value="">Sélectionner un type</option>
                                <option value="Voiture" {{ old('type_vehicule') == 'Voiture' ? 'selected' : '' }}>Voiture</option>
                                <option value="Pick-up" {{ old('type_vehicule') == 'Pick-up' ? 'selected' : '' }}>Pick-up</option>
                                <option value="Fourgon" {{ old('type_vehicule') == 'Fourgon' ? 'selected' : '' }}>Fourgon</option>
                                <option value="Camion" {{ old('type_vehicule') == 'Camion' ? 'selected' : '' }}>Camion</option>
                                <option value="Bus" {{ old('type_vehicule') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                <option value="Moto" {{ old('type_vehicule') == 'Moto' ? 'selected' : '' }}>Moto</option>
                                <option value="Autre" {{ old('type_vehicule') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type_vehicule')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Description du véhicule (optionnel)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position_actuelle" class="form-label">
                            <i class="fas fa-map-marker-alt text-success"></i> Position Actuelle
                        </label>
                        <input type="text" class="form-control @error('position_actuelle') is-invalid @enderror" 
                               id="position_actuelle" name="position_actuelle" 
                               value="{{ old('position_actuelle') }}" 
                               placeholder="Ex: Douala, Yaoundé, Garoua...">
                        @error('position_actuelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle text-info"></i> 
                            Position actuelle du véhicule pour le calcul automatique de distance
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Informations</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note :</strong> Le nombre de pneus sera calculé automatiquement en fonction des pneus associés à ce véhicule.
                </div>
                
                <h6>Champs obligatoires :</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-primary"></i> Immatriculation</li>
                    <li><i class="fas fa-check text-primary"></i> Marque</li>
                    <li><i class="fas fa-check text-primary"></i> Modèle</li>
                </ul>
                
                <h6>Champs optionnels :</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-user text-muted"></i> Chauffeur</li>
                    <li><i class="fas fa-calendar text-muted"></i> Année</li>
                    <li><i class="fas fa-car text-muted"></i> Type de véhicule</li>
                    <li><i class="fas fa-file-alt text-muted"></i> Description</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
