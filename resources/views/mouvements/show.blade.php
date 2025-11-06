@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye text-info"></i> Détails du Mouvement</h1>
    <div>
        <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
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
                    <i class="fas fa-route"></i> Informations du Mouvement
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Date du Mouvement:</strong></td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $mouvement->date_formatee }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Véhicule:</strong></td>
                            <td>
                                <strong>{{ $mouvement->vehicule->immatriculation }}</strong><br>
                                <small class="text-muted">{{ $mouvement->vehicule->marque }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Distance Parcourue:</strong></td>
                            <td>
                                <span class="badge bg-info fs-6">{{ $mouvement->distance_formatee }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Destination:</strong></td>
                            <td>
                                <i class="fas fa-map-marker-alt text-success"></i> 
                                {{ $mouvement->destination ?? 'Non spécifiée' }}
                            </td>
                        </tr>
                        @if($mouvement->vehicule->position_actuelle)
                        <tr>
                            <td><strong>Position Actuelle:</strong></td>
                            <td>
                                <i class="fas fa-location-arrow text-info"></i> 
                                {{ $mouvement->vehicule->position_actuelle }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Enregistré par:</strong></td>
                            <td>{{ $mouvement->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date d'enregistrement:</strong></td>
                            <td>{{ $mouvement->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($mouvement->observations)
                        <tr>
                            <td><strong>Observations:</strong></td>
                            <td>{{ $mouvement->observations }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tire"></i> Impact sur les Pneus
                </h5>
            </div>
            <div class="card-body">
                @php
                    $pneus = \App\Models\Pneu::where('vehicule_id', $mouvement->vehicule_id)->get();
                @endphp
                
                @if($pneus->count() > 0)
                    <p class="text-muted">Pneus montés sur ce véhicule :</p>
                    @foreach($pneus as $pneu)
                        <div class="border rounded p-2 mb-2">
                            <strong>{{ $pneu->numero_serie }}</strong><br>
                            <small class="text-muted">{{ $pneu->marque }} - {{ $pneu->largeur }}/{{ $pneu->hauteur_flanc }}R{{ $pneu->diametre_interieur }}</small><br>
                            <small class="text-info">Kilométrage: {{ number_format($pneu->kilometrage, 0, ',', ' ') }} km</small><br>
                            <small class="text-warning">Usure: {{ number_format($pneu->taux_usure, 1) }}%</small>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Aucun pneu monté sur ce véhicule.
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs"></i> Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ? Le kilométrage des pneus sera ajusté.')">
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
