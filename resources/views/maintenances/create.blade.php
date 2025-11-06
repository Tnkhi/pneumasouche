@extends('layouts.app')

@section('title', 'Déclarer une Maintenance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus text-warning"></i> Déclarer une Maintenance</h1>
    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<!-- Étape 1: Choix du type de maintenance -->
<div class="row" id="etape-type">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs"></i> Étape 1: Type de Maintenance
                </h5>
            </div>
            <div class="card-body text-center">
                <p class="lead mb-4">Choisissez le type de maintenance à déclarer :</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border-primary" style="cursor: pointer;" onclick="choisirType('preventive')">
                            <div class="card-body text-center">
                                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Maintenance Préventive</h5>
                                <p class="card-text text-muted">Maintenance préventive des pneus et équipements</p>
                                <div class="alert alert-info">
                                    <small><i class="fas fa-info-circle"></i> Bientôt disponible</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border-warning" style="cursor: pointer;" onclick="choisirType('curative')">
                            <div class="card-body text-center">
                                <i class="fas fa-tools fa-3x text-warning mb-3"></i>
                                <h5 class="card-title">Maintenance Curative</h5>
                                <p class="card-text text-muted">Intervention corrective sur les véhicules</p>
                                <div class="alert alert-success">
                                    <small><i class="fas fa-check-circle"></i> Disponible</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Étape 2: Choix du type d'intervention curative -->
<div class="row d-none" id="etape-intervention">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-wrench"></i> Étape 2: Type d'Intervention Curative
                </h5>
            </div>
            <div class="card-body">
                <p class="lead mb-4">Sélectionnez le type d'intervention corrective :</p>
                
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_moteur')">
                            <div class="card-body text-center">
                                <i class="fas fa-cog fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Moteur</h6>
                                <small class="text-muted">Intervention corrective dans le moteur</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_boite_vitesse')">
                            <div class="card-body text-center">
                                <i class="fas fa-cogs fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Boîte de Vitesse</h6>
                                <small class="text-muted">Intervention corrective dans la boite de vitesse</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_volant_embrayage')">
                            <div class="card-body text-center">
                                <i class="fas fa-steering-wheel fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Volant & Embrayage</h6>
                                <small class="text-muted">Intervention corrective dans le volant moteur et embrayage</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_suspension_freinage')">
                            <div class="card-body text-center">
                                <i class="fas fa-car-crash fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Suspension & Freinage</h6>
                                <small class="text-muted">Intervention corrective dans le système de suspension et freinage</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_pont_transmission')">
                            <div class="card-body text-center">
                                <i class="fas fa-link fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Pont & Transmission</h6>
                                <small class="text-muted">Intervention corrective dans le pont et système de transmission</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_refroidissement')">
                            <div class="card-body text-center">
                                <i class="fas fa-thermometer-half fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Refroidissement</h6>
                                <small class="text-muted">Intervention corrective dans le système de refroidissement</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_tableau_bord')">
                            <div class="card-body text-center">
                                <i class="fas fa-tachometer-alt fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Tableau de Bord</h6>
                                <small class="text-muted">Intervention corrective dans le tableau de bord</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-danger" style="cursor: pointer;" onclick="choisirIntervention('intervention_carrosserie')">
                            <div class="card-body text-center">
                                <i class="fas fa-car fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">Carrosserie</h6>
                                <small class="text-muted">Intervention corrective sur la carrosserie générale</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Étape 3: Formulaire de déclaration -->
<div class="row d-none" id="etape-formulaire">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clipboard-list"></i> Étape 3: Détails de la Maintenance
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">
                    @csrf
                    
                    <!-- Champs cachés -->
                    <input type="hidden" name="type_maintenance" id="type_maintenance" value="">
                    <input type="hidden" name="sous_type_curative" id="sous_type_curative" value="">
                    
                    <div class="mb-3">
                        <label for="vehicule_id" class="form-label">Véhicule concerné <span class="text-danger">*</span></label>
                        <select class="form-select @error('vehicule_id') is-invalid @enderror" id="vehicule_id" name="vehicule_id" required>
                            <option value="">Sélectionnez un véhicule</option>
                            @foreach($vehicules as $vehicule)
                                <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                    {{ $vehicule->immatriculation }} - {{ $vehicule->marque }} {{ $vehicule->modele }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicule_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prerequis" class="form-label">Prérequis (besoin de base minimale) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('prerequis') is-invalid @enderror" 
                                  id="prerequis" name="prerequis" rows="3" required
                                  placeholder="Décrivez les besoins de base minimale...">{{ old('prerequis') }}</textarea>
                        @error('prerequis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="requis" class="form-label">Requis (Ce qu'il faut vraiment pour la maintenance) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('requis') is-invalid @enderror" 
                                  id="requis" name="requis" rows="3" required
                                  placeholder="Décrivez ce qu'il faut vraiment pour la maintenance...">{{ old('requis') }}</textarea>
                        @error('requis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="resultat_attendu" class="form-label">Résultat attendu <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('resultat_attendu') is-invalid @enderror" 
                                  id="resultat_attendu" name="resultat_attendu" rows="3" required
                                  placeholder="Décrivez le résultat attendu...">{{ old('resultat_attendu') }}</textarea>
                        @error('resultat_attendu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="explication_cause" class="form-label">Explication sur la cause <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('explication_cause') is-invalid @enderror" 
                                  id="explication_cause" name="explication_cause" rows="3" required
                                  placeholder="Expliquez la cause du problème...">{{ old('explication_cause') }}</textarea>
                        @error('explication_cause')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary me-md-2" onclick="retourEtapePrecedente()">
                            <i class="fas fa-arrow-left"></i> Retour
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Déclarer la Maintenance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar d'informations -->
<div class="col-lg-4">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h6 class="card-title mb-0">
                <i class="fas fa-info-circle"></i> Informations
            </h6>
        </div>
        <div class="card-body">
            <div id="info-content">
                <h6>Types de Maintenance</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-shield-alt text-primary"></i> <strong>Préventive:</strong> Maintenance préventive des pneus</li>
                    <li><i class="fas fa-tools text-warning"></i> <strong>Curative:</strong> Intervention corrective sur véhicules</li>
                </ul>
                
                <h6 class="mt-3">Workflow</h6>
                <ol>
                    <li>Déclaration par le mécanicien</li>
                    <li>Validation par le déclarateur</li>
                    <li>Approbation par la direction</li>
                    <li>Exécution par le mécanicien</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
let etapeActuelle = 1;
let typeMaintenance = '';
let sousTypeCurative = '';

function choisirType(type) {
    if (type === 'preventive') {
        alert('Les maintenances préventives seront bientôt disponibles.');
        return;
    }
    
    typeMaintenance = type;
    document.getElementById('type_maintenance').value = type;
    
    if (type === 'curative') {
        document.getElementById('etape-type').classList.add('d-none');
        document.getElementById('etape-intervention').classList.remove('d-none');
        etapeActuelle = 2;
    }
}

function choisirIntervention(intervention) {
    sousTypeCurative = intervention;
    document.getElementById('sous_type_curative').value = intervention;
    
    document.getElementById('etape-intervention').classList.add('d-none');
    document.getElementById('etape-formulaire').classList.remove('d-none');
    etapeActuelle = 3;
}

function retourEtapePrecedente() {
    if (etapeActuelle === 3) {
        document.getElementById('etape-formulaire').classList.add('d-none');
        document.getElementById('etape-intervention').classList.remove('d-none');
        etapeActuelle = 2;
    } else if (etapeActuelle === 2) {
        document.getElementById('etape-intervention').classList.add('d-none');
        document.getElementById('etape-type').classList.remove('d-none');
        etapeActuelle = 1;
    }
}
</script>
@endsection