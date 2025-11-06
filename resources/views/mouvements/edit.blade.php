@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit text-warning"></i> Modifier le Mouvement</h1>
    <div>
        <a href="{{ route('mouvements.show', $mouvement) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir
        </a>
        <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-route"></i> Modifier les Informations
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mouvements.update', $mouvement) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                                        <option value="{{ $vehicule->id }}" 
                                                {{ old('vehicule_id', $mouvement->vehicule_id) == $vehicule->id ? 'selected' : '' }}>
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
                                       value="{{ old('date_mouvement', $mouvement->date_mouvement->format('Y-m-d')) }}" required>
                                @error('date_mouvement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="distance_parcourue" class="form-label">
                                    <strong>Distance Parcourue (km) <span class="text-danger">*</span></strong>
                                </label>
                                <input type="number" class="form-control @error('distance_parcourue') is-invalid @enderror" 
                                       id="distance_parcourue" name="distance_parcourue" 
                                       value="{{ old('distance_parcourue', $mouvement->distance_parcourue) }}" 
                                       min="1" step="1" required>
                                @error('distance_parcourue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="destination" class="form-label">
                                    <strong>Destination</strong>
                                </label>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                                       id="destination" name="destination" 
                                       value="{{ old('destination', $mouvement->destination) }}" 
                                       placeholder="Ex: Douala, Yaoundé...">
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observations" class="form-label">
                            <strong>Observations</strong>
                        </label>
                        <textarea class="form-control @error('observations') is-invalid @enderror" 
                                  id="observations" name="observations" rows="4" 
                                  placeholder="Détails du trajet, conditions de route, etc...">{{ old('observations', $mouvement->observations) }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mouvements.show', $mouvement) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Mettre à Jour
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
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Attention :</strong> Modifier la distance parcourue ajustera automatiquement le kilométrage des pneus en conséquence.
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Note :</strong> Le taux d'usure des pneus sera recalculé automatiquement.
                </div>
                
                <div class="border rounded p-3">
                    <h6><strong>Distance actuelle :</strong></h6>
                    <span class="badge bg-info fs-6">{{ $mouvement->distance_formatee }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
