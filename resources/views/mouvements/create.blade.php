@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus text-success"></i> Nouveau Mouvement</h1>
    <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-route"></i> Informations du Mouvement
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mouvements.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vehicule_id" class="form-label">
                                    <strong>Véhicule <span class="text-danger">*</span></strong>
                                </label>
                                <select class="form-select @error('vehicule_id') is-invalid @enderror" 
                                        id="vehicule_id" name="vehicule_id" required>
                                    <option value="">Sélectionner un véhicule</option>
                                    @foreach($vehicules as $vehicule)
                                        <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                            {{ $vehicule->immatriculation }} - {{ $vehicule->marque }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicule_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_mouvement" class="form-label">
                                    <strong>Date du Mouvement <span class="text-danger">*</span></strong>
                                </label>
                                <input type="date" class="form-control @error('date_mouvement') is-invalid @enderror" 
                                       id="date_mouvement" name="date_mouvement" 
                                       value="{{ old('date_mouvement', date('Y-m-d')) }}" required>
                                @error('date_mouvement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="destination" class="form-label">
                                    <strong>Destination <span class="text-danger">*</span></strong>
                                </label>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                                       id="destination" name="destination" 
                                       value="{{ old('destination') }}" 
                                       placeholder="Ex: Douala, Yaoundé, Garoua..." required>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-info"></i> 
                                    La distance sera calculée automatiquement si le véhicule a une position actuelle
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="distance_parcourue" class="form-label">
                                    <strong>Distance Parcourue (km)</strong>
                                </label>
                                <input type="number" class="form-control @error('distance_parcourue') is-invalid @enderror" 
                                       id="distance_parcourue" name="distance_parcourue" 
                                       value="{{ old('distance_parcourue') }}" 
                                       min="0.1" step="0.1">
                                @error('distance_parcourue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-calculator text-warning"></i> 
                                    Saisie manuelle si le calcul automatique échoue
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="calculer_distance_auto" 
                                   name="calculer_distance_auto" value="1" checked>
                            <label class="form-check-label" for="calculer_distance_auto">
                                <strong>Calculer automatiquement la distance</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-map-marker-alt text-success"></i> 
                            Utilise Google Maps pour calculer la distance entre la position actuelle du véhicule et la destination
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observations" class="form-label">
                            <strong>Observations</strong>
                        </label>
                        <textarea class="form-control @error('observations') is-invalid @enderror" 
                                  id="observations" name="observations" rows="4" 
                                  placeholder="Détails du trajet, conditions de route, etc...">{{ old('observations') }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer le Mouvement
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
                    <i class="fas fa-info-circle"></i> Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <i class="fas fa-route"></i>
                    <strong>Calcul Automatique :</strong> Le système calcule automatiquement la distance et met à jour l'usure des pneus.
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <strong>Position GPS :</strong> Utilise Google Maps pour calculer la distance entre la position actuelle et la destination.
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Alertes :</strong> Des alertes automatiques seront créées si l'usure des pneus dépasse certains seuils.
                </div>

                <div class="alert alert-primary">
                    <i class="fas fa-tachometer-alt"></i>
                    <strong>Seuils d'alerte :</strong>
                    <ul class="mb-0 mt-2">
                        <li><span class="badge bg-warning">70%</span> Alerte moyenne</li>
                        <li><span class="badge bg-warning">80%</span> Alerte haute</li>
                        <li><span class="badge bg-danger">90%</span> Alerte critique</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
