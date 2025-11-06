@extends('layouts.app')

@section('title', 'Modifier le Véhicule')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit text-warning"></i> Modifier le Véhicule</h1>
    <div>
        <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir
        </a>
        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier les Informations du Véhicule</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vehicules.update', $vehicule) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="immatriculation" class="form-label">Immatriculation *</label>
                            <input type="text" class="form-control @error('immatriculation') is-invalid @enderror" 
                                   id="immatriculation" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" 
                                   placeholder="Ex: CI-123-AB" required>
                            @error('immatriculation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="chauffeur" class="form-label">Chauffeur</label>
                            <input type="text" class="form-control @error('chauffeur') is-invalid @enderror" 
                                   id="chauffeur" name="chauffeur" value="{{ old('chauffeur', $vehicule->chauffeur) }}" 
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
                                   id="marque" name="marque" value="{{ old('marque', $vehicule->marque) }}" 
                                   placeholder="Ex: Toyota" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modele" class="form-label">Modèle *</label>
                            <input type="text" class="form-control @error('modele') is-invalid @enderror" 
                                   id="modele" name="modele" value="{{ old('modele', $vehicule->modele) }}" 
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
                                   id="annee" name="annee" value="{{ old('annee', $vehicule->annee) }}" 
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
                                <option value="Voiture" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Voiture' ? 'selected' : '' }}>Voiture</option>
                                <option value="Pick-up" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Pick-up' ? 'selected' : '' }}>Pick-up</option>
                                <option value="Fourgon" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Fourgon' ? 'selected' : '' }}>Fourgon</option>
                                <option value="Camion" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Camion' ? 'selected' : '' }}>Camion</option>
                                <option value="Bus" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Bus' ? 'selected' : '' }}>Bus</option>
                                <option value="Moto" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Moto' ? 'selected' : '' }}>Moto</option>
                                <option value="Autre" {{ old('type_vehicule', $vehicule->type_vehicule) == 'Autre' ? 'selected' : '' }}>Autre</option>
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
                                  placeholder="Description du véhicule (optionnel)">{{ old('description', $vehicule->description) }}</textarea>
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
                               value="{{ old('position_actuelle', $vehicule->position_actuelle) }}" 
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
                        <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Statistiques Actuelles</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Nombre de Pneus</h6>
                    <h4 class="text-primary">{{ $vehicule->nombre_pneus }}</h4>
                </div>
                
                <div class="mb-3">
                    <h6>Valeur Totale des Pneus</h6>
                    <h5 class="text-success">{{ number_format($vehicule->valeur_totale_pneus, 0) }} FCFA</h5>
                </div>
                
                <div class="mb-3">
                    <h6>Taux d'Usure Moyen</h6>
                    <h5 class="text-warning">{{ number_format($vehicule->taux_usure_moyen, 1) }}%</h5>
                </div>
                
                <div class="mb-3">
                    <h6>Statut</h6>
                    @if($vehicule->nombre_pneus > 0)
                        <span class="badge bg-{{ $vehicule->couleur_statut }} fs-6">{{ $vehicule->statut }}</span>
                    @else
                        <span class="badge bg-secondary fs-6">Sans Pneus</span>
                    @endif
                </div>
                
                @if($vehicule->annee)
                    <div class="mb-3">
                        <h6>Âge du Véhicule</h6>
                        <p class="mb-0">{{ $vehicule->age }} ans</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
