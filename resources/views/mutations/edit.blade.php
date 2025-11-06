@extends('layouts.app')

@section('title', 'Modifier une Mutation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit text-warning"></i> Modifier une Mutation</h1>
    <div>
        <a href="{{ route('mutations.show', $mutation) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir
        </a>
        <a href="{{ route('mutations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier les Informations de la Mutation</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mutations.update', $mutation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pneu_id" class="form-label">Pneu *</label>
                            <select class="form-select @error('pneu_id') is-invalid @enderror" 
                                    id="pneu_id" name="pneu_id" required>
                                <option value="">Sélectionner un pneu</option>
                                @foreach($pneus as $pneu)
                                    <option value="{{ $pneu->id }}" {{ old('pneu_id', $mutation->pneu_id) == $pneu->id ? 'selected' : '' }}>
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
                                    <option value="{{ $vehicule->id }}" {{ old('vehicule_destination_id', $mutation->vehicule_destination_id) == $vehicule->id ? 'selected' : '' }}>
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
                                   id="date_mutation" name="date_mutation" 
                                   value="{{ old('date_mutation', $mutation->date_mutation->format('Y-m-d')) }}" required>
                            @error('date_mutation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="operateur" class="form-label">Opérateur</label>
                            <input type="text" class="form-control @error('operateur') is-invalid @enderror" 
                                   id="operateur" name="operateur" 
                                   value="{{ old('operateur', $mutation->operateur) }}" 
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
                                   value="{{ old('kilometrage_au_moment_mutation', $mutation->kilometrage_au_moment_mutation) }}" 
                                   placeholder="Ex: 25000 km">
                            @error('kilometrage_au_moment_mutation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="motif" class="form-label">Motif de la Mutation</label>
                            <select class="form-select @error('motif') is-invalid @enderror" 
                                    id="motif" name="motif">
                                <option value="">Sélectionner un motif</option>
                                <option value="Usure normale" {{ old('motif', $mutation->motif) == 'Usure normale' ? 'selected' : '' }}>Usure normale</option>
                                <option value="Panne" {{ old('motif', $mutation->motif) == 'Panne' ? 'selected' : '' }}>Panne</option>
                                <option value="Maintenance préventive" {{ old('motif', $mutation->motif) == 'Maintenance préventive' ? 'selected' : '' }}>Maintenance préventive</option>
                                <option value="Optimisation du parc" {{ old('motif', $mutation->motif) == 'Optimisation du parc' ? 'selected' : '' }}>Optimisation du parc</option>
                                <option value="Remplacement d'urgence" {{ old('motif', $mutation->motif) == 'Remplacement d\'urgence' ? 'selected' : '' }}>Remplacement d'urgence</option>
                                <option value="Autre" {{ old('motif', $mutation->motif) == 'Autre' ? 'selected' : '' }}>Autre</option>
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
                                  placeholder="Observations particulières (optionnel)">{{ old('observations', $mutation->observations) }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mutations.show', $mutation) }}" class="btn btn-secondary me-2">Annuler</a>
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
                <h6 class="card-title mb-0">Informations Actuelles</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Pneu:</strong></td>
                        <td>{{ $mutation->pneu->numero_serie }}</td>
                    </tr>
                    <tr>
                        <td><strong>Véhicule Source:</strong></td>
                        <td>
                            @if($mutation->vehiculeSource)
                                {{ $mutation->vehiculeSource->immatriculation }}
                            @else
                                <span class="text-muted">Montage initial</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Véhicule Destination:</strong></td>
                        <td>{{ $mutation->vehiculeDestination->immatriculation }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ $mutation->date_mutation->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Type:</strong></td>
                        <td>
                            @if($mutation->type_mutation == 'Montage initial')
                                <span class="badge bg-success">{{ $mutation->type_mutation }}</span>
                            @else
                                <span class="badge bg-warning">{{ $mutation->type_mutation }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Attention :</strong> La modification d'une mutation peut affecter l'historique des pneus et véhicules.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
