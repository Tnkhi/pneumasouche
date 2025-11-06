@extends('layouts.app')

@section('title', 'Modifier le Pneu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit text-warning"></i> Modifier le Pneu</h1>
    <div>
        <a href="{{ route('pneus.show', $pneu) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir
        </a>
        <a href="{{ route('pneus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier les Informations du Pneu</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pneus.update', $pneu) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="numero_serie" class="form-label">Numéro de Série *</label>
                            <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                   id="numero_serie" name="numero_serie" value="{{ old('numero_serie', $pneu->numero_serie) }}" required>
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="marque" class="form-label">Marque *</label>
                            <input type="text" class="form-control @error('marque') is-invalid @enderror" 
                                   id="marque" name="marque" value="{{ old('marque', $pneu->marque) }}" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="largeur" class="form-label">Largeur *</label>
                            <input type="number" class="form-control @error('largeur') is-invalid @enderror" 
                                   id="largeur" name="largeur" value="{{ old('largeur', $pneu->largeur) }}" min="1" required>
                            @error('largeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="hauteur_flanc" class="form-label">Hauteur du Flanc *</label>
                            <input type="number" class="form-control @error('hauteur_flanc') is-invalid @enderror" 
                                   id="hauteur_flanc" name="hauteur_flanc" value="{{ old('hauteur_flanc', $pneu->hauteur_flanc) }}" min="1" required>
                            @error('hauteur_flanc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="diametre_interieur" class="form-label">Diamètre Intérieur *</label>
                            <input type="number" class="form-control @error('diametre_interieur') is-invalid @enderror" 
                                   id="diametre_interieur" name="diametre_interieur" value="{{ old('diametre_interieur', $pneu->diametre_interieur) }}" min="1" required>
                            @error('diametre_interieur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="indice_vitesse" class="form-label">Indice de Vitesse *</label>
                            <input type="text" class="form-control @error('indice_vitesse') is-invalid @enderror" 
                                   id="indice_vitesse" name="indice_vitesse" value="{{ old('indice_vitesse', $pneu->indice_vitesse) }}" required>
                            @error('indice_vitesse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="indice_charge" class="form-label">Indice de Charge *</label>
                            <input type="text" class="form-control @error('indice_charge') is-invalid @enderror" 
                                   id="indice_charge" name="indice_charge" value="{{ old('indice_charge', $pneu->indice_charge) }}" required>
                            @error('indice_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prix_achat" class="form-label">Prix d'Achat (FCFA) *</label>
                            <input type="number" class="form-control @error('prix_achat') is-invalid @enderror" 
                                   id="prix_achat" name="prix_achat" value="{{ old('prix_achat', $pneu->prix_achat) }}" min="0" step="0.01" required>
                            @error('prix_achat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="date_montage" class="form-label">Date de Montage *</label>
                            <input type="date" class="form-control @error('date_montage') is-invalid @enderror" 
                                   id="date_montage" name="date_montage" value="{{ old('date_montage', $pneu->date_montage->format('Y-m-d')) }}" required>
                            @error('date_montage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duree_vie" class="form-label">Durée de Vie (km) *</label>
                            <input type="number" class="form-control @error('duree_vie') is-invalid @enderror" 
                                   id="duree_vie" name="duree_vie" value="{{ old('duree_vie', $pneu->duree_vie) }}" min="1" required>
                            @error('duree_vie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kilometrage" class="form-label">Kilométrage Actuel (km)</label>
                            <input type="number" class="form-control @error('kilometrage') is-invalid @enderror" 
                                   id="kilometrage" name="kilometrage" value="{{ old('kilometrage', $pneu->kilometrage) }}" min="0">
                            @error('kilometrage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fournisseur_id" class="form-label">Fournisseur *</label>
                            <select class="form-select @error('fournisseur_id') is-invalid @enderror" 
                                    id="fournisseur_id" name="fournisseur_id" required>
                                <option value="">Sélectionner un fournisseur</option>
                                @foreach($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}" 
                                        {{ old('fournisseur_id', $pneu->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                        {{ $fournisseur->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fournisseur_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="vehicule_id" class="form-label">Véhicule *</label>
                            <select class="form-select @error('vehicule_id') is-invalid @enderror" 
                                    id="vehicule_id" name="vehicule_id" required>
                                <option value="">Sélectionner un véhicule</option>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" 
                                        {{ old('vehicule_id', $pneu->vehicule_id) == $vehicule->id ? 'selected' : '' }}>
                                        {{ $vehicule->immatriculation }} - {{ $vehicule->marque }} {{ $vehicule->modele }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('pneus.show', $pneu) }}" class="btn btn-secondary me-2">Annuler</a>
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
                <h6 class="card-title mb-0">État Actuel</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Taux d'Usure</h6>
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar 
                            @if($pneu->taux_usure < 30) bg-success
                            @elseif($pneu->taux_usure < 70) bg-warning
                            @else bg-danger
                            @endif" 
                            style="width: {{ $pneu->taux_usure }}%">
                            {{ number_format($pneu->taux_usure, 1) }}%
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Valeur Restante</h6>
                    <h5 class="text-success">{{ number_format($pneu->valeur_exploitation_restante, 0) }} FCFA</h5>
                </div>
                
                <div class="mb-3">
                    <h6>Dimension</h6>
                    <span class="badge bg-primary fs-6">{{ $pneu->dimension }}</span>
                </div>
                
                <div class="mb-3">
                    <h6>Âge</h6>
                    <p class="mb-0">{{ $pneu->age }} jours</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
