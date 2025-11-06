@extends('layouts.app')

@section('title', 'Historique des Mutations du Pneu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-history text-info"></i> Historique des Mutations</h1>
    <div>
        <a href="{{ route('pneus.show', $pneu) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Voir le Pneu
        </a>
        <a href="{{ route('pneus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- Informations du pneu -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Informations du Pneu</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <i class="fas fa-tire fa-3x text-primary mb-3"></i>
                <h4>{{ $pneu->numero_serie }}</h4>
                <p class="text-muted">Numéro de série</p>
            </div>
            <div class="col-md-3 text-center">
                <h4>{{ $pneu->marque }}</h4>
                <p class="text-muted">Marque</p>
            </div>
            <div class="col-md-3 text-center">
                <span class="badge bg-secondary fs-5">{{ $pneu->dimension }}</span>
                <p class="text-muted">Dimension</p>
            </div>
            <div class="col-md-3 text-center">
                <h4>{{ $pneu->vehicule->immatriculation ?? 'Non monté' }}</h4>
                <p class="text-muted">Véhicule actuel</p>
            </div>
        </div>
    </div>
</div>

<!-- Historique des mutations -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Historique des Mutations ({{ $mutations->count() }} mutations)</h5>
    </div>
    <div class="card-body">
        @if($mutations->count() > 0)
            <div class="timeline">
                @foreach($mutations as $index => $mutation)
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            @if($mutation->type_mutation == 'Montage initial')
                                <i class="fas fa-plus-circle text-success"></i>
                            @else
                                <i class="fas fa-exchange-alt text-warning"></i>
                            @endif
                        </div>
                        <div class="timeline-content">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">
                                                @if($mutation->type_mutation == 'Montage initial')
                                                    <span class="badge bg-success">{{ $mutation->type_mutation }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $mutation->type_mutation }}</span>
                                                @endif
                                            </h6>
                                            <p class="card-text">{{ $mutation->description }}</p>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> {{ $mutation->date_mutation->format('d/m/Y') }}
                                                        <br><i class="fas fa-clock"></i> {{ $mutation->age_mutation }} jours
                                                    </small>
                                                </div>
                                                <div class="col-md-6">
                                                    @if($mutation->operateur)
                                                        <small class="text-muted">
                                                            <i class="fas fa-user"></i> {{ $mutation->operateur }}
                                                        </small>
                                                    @endif
                                                    @if($mutation->motif)
                                                        <br><small class="text-muted">
                                                            <i class="fas fa-clipboard-list"></i> {{ $mutation->motif }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($mutation->observations)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-comment"></i> {{ $mutation->observations }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="btn-group-vertical">
                                            <a href="{{ route('mutations.show', $mutation) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('mutations.edit', $mutation) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucune mutation enregistrée</h4>
                <p class="text-muted">Ce pneu n'a pas encore d'historique de mutations.</p>
            </div>
        @endif
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 10px;
    width: 40px;
    height: 40px;
    background: white;
    border: 3px solid #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.timeline-content {
    margin-left: 20px;
}
</style>
@endsection
