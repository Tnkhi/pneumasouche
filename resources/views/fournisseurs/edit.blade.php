@extends('layouts.app')

@section('title', 'Modifier le Fournisseur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit text-warning"></i> Modifier le Fournisseur</h1>
    <div>
        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir
        </a>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier les Informations du Fournisseur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom du Fournisseur *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $fournisseur->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Personne de Contact</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                                   id="contact" name="contact" value="{{ old('contact', $fournisseur->contact) }}">
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                   id="telephone" name="telephone" value="{{ old('telephone', $fournisseur->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $fournisseur->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                  id="adresse" name="adresse" rows="3">{{ old('adresse', $fournisseur->adresse) }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-secondary me-2">Annuler</a>
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
                    <h6>Nombre de Pneus Fournis</h6>
                    <h4 class="text-primary">{{ $fournisseur->nombre_pneus_fournis }}</h4>
                </div>
                
                <div class="mb-3">
                    <h6>Valeur Totale</h6>
                    <h5 class="text-success">{{ number_format($fournisseur->valeur_totale, 0) }} FCFA</h5>
                </div>
                
                <div class="mb-3">
                    <h6>Taux d'Usure Moyen</h6>
                    <h5 class="text-warning">{{ number_format($fournisseur->taux_usure_moyen, 1) }}%</h5>
                </div>
                
                <div class="mb-3">
                    <h6>Statut</h6>
                    @if($fournisseur->nombre_pneus_fournis >= 10)
                        <span class="badge bg-success fs-6">Fournisseur Principal</span>
                    @elseif($fournisseur->nombre_pneus_fournis >= 5)
                        <span class="badge bg-warning fs-6">Fournisseur Régulier</span>
                    @elseif($fournisseur->nombre_pneus_fournis > 0)
                        <span class="badge bg-info fs-6">Fournisseur Occasionnel</span>
                    @else
                        <span class="badge bg-secondary fs-6">Fournisseur Inactif</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Notes Automatiques</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <small>{{ $fournisseur->notes }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
