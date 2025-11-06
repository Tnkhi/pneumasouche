@extends('layouts.app')

@section('title', 'Effectuer une Mutation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus text-warning"></i> Effectuer une Mutation</h1>
    <a href="{{ route('mutations.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations de la Mutation</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mutations.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pneu_id" class="form-label">Pneu à Muté *</label>
                            <select class="form-select @error('pneu_id') is-invalid @enderror" 
                                    id="pneu_id" name="pneu_id" required>
                                <option value="">Sélectionner un pneu</option>
                                @foreach($pneus as $pneu)
                                    <option value="{{ $pneu->id }}" {{ old('pneu_id') == $pneu->id ? 'selected' : '' }}>
                                        {{ $pneu->numero_serie }} - {{ $pneu->marque }} {{ $pneu->dimension }}
                                        @if($pneu->vehicule)
                                            (Actuellement sur {{ $pneu->vehicule->immatriculation }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('pneu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="vehicule_destination_id" class="form-label">Véhicule Destination *</label>
                            <select class="form-select @error('vehicule_destination_id') is-invalid @enderror" 
                                    id="vehicule_destination_id" name="vehicule_destination_id" required>
                                <option value="">Sélectionner un véhicule</option>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" {{ old('vehicule_destination_id') == $vehicule->id ? 'selected' : '' }}>
                                        {{ $vehicule->immatriculation }} - {{ $vehicule->marque }} {{ $vehicule->modele }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicule_destination_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_mutation" class="form-label">Date de Mutation *</label>
                            <input type="date" class="form-control @error('date_mutation') is-invalid @enderror" 
                                   id="date_mutation" name="date_mutation" value="{{ old('date_mutation', date('Y-m-d')) }}" required>
                            @error('date_mutation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="operateur" class="form-label">Opérateur</label>
                            <input type="text" class="form-control @error('operateur') is-invalid @enderror" 
                                   id="operateur" name="operateur" value="{{ old('operateur') }}" 
                                   placeholder="Nom de la personne qui effectue la mutation">
                            @error('operateur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kilometrage_au_moment_mutation" class="form-label">Kilométrage au Moment de la Mutation</label>
                            <input type="text" class="form-control @error('kilometrage_au_moment_mutation') is-invalid @enderror" 
                                   id="kilometrage_au_moment_mutation" name="kilometrage_au_moment_mutation" 
                                   value="{{ old('kilometrage_au_moment_mutation') }}" placeholder="Ex: 25000 km">
                            @error('kilometrage_au_moment_mutation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="motif" class="form-label">Motif de la Mutation</label>
                            <select class="form-select @error('motif') is-invalid @enderror" 
                                    id="motif" name="motif">
                                <option value="">Sélectionner un motif</option>
                                <option value="Usure normale" {{ old('motif') == 'Usure normale' ? 'selected' : '' }}>Usure normale</option>
                                <option value="Panne" {{ old('motif') == 'Panne' ? 'selected' : '' }}>Panne</option>
                                <option value="Maintenance préventive" {{ old('motif') == 'Maintenance préventive' ? 'selected' : '' }}>Maintenance préventive</option>
                                <option value="Optimisation du parc" {{ old('motif') == 'Optimisation du parc' ? 'selected' : '' }}>Optimisation du parc</option>
                                <option value="Remplacement d'urgence" {{ old('motif') == 'Remplacement d\'urgence' ? 'selected' : '' }}>Remplacement d'urgence</option>
                                <option value="Autre" {{ old('motif') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('motif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observations" class="form-label">Observations</label>
                        <textarea class="form-control @error('observations') is-invalid @enderror" 
                                  id="observations" name="observations" rows="3" 
                                  placeholder="Observations particulières (optionnel)">{{ old('observations') }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mutations.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-exchange-alt"></i> Effectuer la Mutation
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
                    <strong>Note :</strong> La mutation mettra automatiquement à jour le véhicule associé au pneu.
                </div>
                
                <h6>Champs obligatoires :</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-warning"></i> Pneu à muté</li>
                    <li><i class="fas fa-check text-warning"></i> Véhicule destination</li>
                    <li><i class="fas fa-check text-warning"></i> Date de mutation</li>
                </ul>
                
                <h6>Champs optionnels :</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-user text-muted"></i> Opérateur</li>
                    <li><i class="fas fa-tachometer-alt text-muted"></i> Kilométrage</li>
                    <li><i class="fas fa-clipboard-list text-muted"></i> Motif</li>
                    <li><i class="fas fa-comment text-muted"></i> Observations</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
