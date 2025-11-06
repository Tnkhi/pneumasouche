<?php

use App\Http\Controllers\AlerteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PieceDetacheeController;
use App\Http\Controllers\PneuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculeController;
use Illuminate\Support\Facades\Route;

// Routes d'authentification (publiques)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes protégées par authentification simple
    Route::middleware(['auth', 'check.activity'])->group(function () {
        // Page d'accueil - Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        

    
    // Routes pour les alertes intelligentes
    Route::prefix('alertes')->name('alertes.')->group(function () {
        Route::get('/', [AlerteController::class, 'index'])->name('index');
        Route::get('/generer', [AlerteController::class, 'genererAlertes'])->name('generer');
        Route::get('/{alerte}', [AlerteController::class, 'show'])->name('show');
        Route::post('/{alerte}/resoudre', [AlerteController::class, 'resoudre'])->name('resoudre');
        Route::post('/{alerte}/ignorer', [AlerteController::class, 'ignorer'])->name('ignorer');
        Route::post('/{alerte}/reactiver', [AlerteController::class, 'reactiver'])->name('reactiver');
        Route::get('/api/critiques', [AlerteController::class, 'apiCritiques'])->name('api-critiques');
        Route::get('/api/statistiques', [AlerteController::class, 'apiStatistiques'])->name('api-statistiques');
    });

    // Routes principales
    Route::resource('pneus', PneuController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('mutations', MutationController::class);
    Route::get('mutations/{mutation}/delete', [MutationController::class, 'delete'])->name('mutations.delete');
    Route::get('pneus/{pneu}/mutations', [MutationController::class, 'historiquePneu'])->name('pneus.mutations');
    Route::get('vehicules/{vehicule}/mutations', [MutationController::class, 'historiqueVehicule'])->name('vehicules.mutations');
    
    // Routes pour les mouvements
    Route::resource('mouvements', MouvementController::class);
    
    // Routes pour les notifications
    Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'destroy']);
    Route::post('notifications/{notification}/marquer-comme-lu', [NotificationController::class, 'marquerCommeLu'])->name('notifications.marquer-comme-lu');
    Route::post('notifications/{notification}/marquer-comme-non-lu', [NotificationController::class, 'marquerCommeNonLu'])->name('notifications.marquer-comme-non-lu');
    Route::post('notifications/marquer-toutes-comme-lues', [NotificationController::class, 'marquerToutesCommeLues'])->name('notifications.marquer-toutes-comme-lues');
    Route::get('notifications/supprimer-lues', [NotificationController::class, 'supprimerLues'])->name('notifications.supprimer-lues');
    Route::get('notifications/get-non-lues', [NotificationController::class, 'getNonLues'])->name('notifications.get-non-lues');
    
    // Route de test pour les notifications
    Route::get('test-notifications', function() {
        return response()->json([
            'success' => true,
            'message' => 'Test des notifications fonctionne',
            'count' => \App\Models\Notification::count()
        ]);
    })->name('test.notifications');
    
    
    
    
    
    // Routes pour les maintenances (routes spécifiques AVANT la route resource)
    Route::get('maintenances/declarateur', [MaintenanceController::class, 'declarateur'])->name('maintenances.declarateur');
    Route::get('maintenances/direction', [MaintenanceController::class, 'direction'])->name('maintenances.direction');
    Route::get('maintenances/{maintenance}/direction-details', [MaintenanceController::class, 'directionDetails'])->name('maintenances.direction-details');
    Route::post('maintenances/{maintenance}/valider-direction', [MaintenanceController::class, 'validerDirection'])->name('maintenances.valider-direction');
    Route::post('maintenances/{maintenance}/rejeter-direction', [MaintenanceController::class, 'rejeterDirection'])->name('maintenances.rejeter-direction');
    
    // Route resource pour les maintenances (après les routes spécifiques)
    Route::resource('maintenances', MaintenanceController::class);
    
    // Routes pour les pièces détachées
    Route::get('pieces-detachees/create/{maintenance}', [PieceDetacheeController::class, 'create'])->name('pieces-detachees.create');
    Route::post('pieces-detachees', [PieceDetacheeController::class, 'store'])->name('pieces-detachees.store');
    Route::delete('pieces-detachees/{pieces_detachee}', [PieceDetacheeController::class, 'destroy'])->name('pieces-detachees.destroy');
    Route::post('pieces-detachees/{maintenance}/finaliser', [PieceDetacheeController::class, 'finaliser'])->name('pieces-detachees.finaliser');
    
    // Routes pour les utilisateurs (admin seulement)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
        Route::get('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});