@extends('layouts.app')

@section('title', 'Détails de la Mutation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exchange-alt text-info"></i> Détails de la Mutation</h1>
    <div>
        <a href="{{ route('mutations.edit', $mutation) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
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
                <h5 class="card-title mb-0">Informations de la Mutation</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Date de Mutation:</strong></td>
                                <td>{{ $mutation->date_mutation->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    @if($mutation->type_mutation == 'Montage initial')
                                        <span class="badge bg-success fs-6">{{ $mutation->type_mutation }}</span>
                                    @else
                                        <span class="badge bg-warning fs-6">{{ $mutation->type_mutation }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Opérateur:</strong></td>
                                <td>
                                    @if($mutation->operateur)
                                        <i class="fas fa-user"></i> {{ $mutation->operateur }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kilométrage:</strong></td>
                                <td>
                                    @if($mutation->kilometrage_au_moment_mutation)
                                        {{ $mutation->kilometrage_au_moment_mutation }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Motif:</strong></td>
                                <td>
                                    @if($mutation->motif)
                                        {{ $mutation->motif }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Âge de la mutation:</strong></td>
                                <td>{{ $mutation->age_mutation }} jours</td>
                            </tr>
                            <tr>
                                <td><strong>Date de création:</strong></td>
                                <td>{{ $mutation->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dernière modification:</strong></td>
                                <td>{{ $mutation->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($mutation->observations)
                    <div class="mt-3">
                        <h6>Observations :</h6>
                        <p class="text-muted">{{ $mutation->observations }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Informations du pneu -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Pneu</h6>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-tire fa-3x text-primary mb-3"></i>
                <h5>{{ $mutation->pneu->numero_serie }}</h5>
                <p class="text-muted">{{ $mutation->pneu->marque }} - {{ $mutation->pneu->dimension }}</p>
                <p class="text-muted">Fournisseur: {{ $mutation->pneu->fournisseur->nom }}</p>
                <a href="{{ route('pneus.show', $mutation->pneu) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye"></i> Voir le pneu
                </a>
            </div>
        </div>

        <!-- Véhicule source -->
        @if($mutation->vehiculeSource)
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Véhicule Source</h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-car fa-3x text-warning mb-3"></i>
                    <h5>{{ $mutation->vehiculeSource->immatriculation }}</h5>
                    <p class="text-muted">{{ $mutation->vehiculeSource->marque }} {{ $mutation->vehiculeSource->modele }}</p>
                    <a href="{{ route('vehicules.show', $mutation->vehiculeSource) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-eye"></i> Voir le véhicule
                    </a>
                </div>
            </div>
        @endif

        <!-- Véhicule destination -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Véhicule Destination</h6>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-car fa-3x text-success mb-3"></i>
                <h5>{{ $mutation->vehiculeDestination->immatriculation }}</h5>
                <p class="text-muted">{{ $mutation->vehiculeDestination->marque }} {{ $mutation->vehiculeDestination->modele }}</p>
                <a href="{{ route('vehicules.show', $mutation->vehiculeDestination) }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-eye"></i> Voir le véhicule
                </a>
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('mutations.edit', $mutation) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('mutations.destroy', $mutation) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette mutation ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
