@extends('layouts.app')

@section('title', 'Test Utilisateurs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Test de la Page Utilisateurs</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        <strong>Succès !</strong> La page des utilisateurs fonctionne correctement.
                    </div>
                    
                    <h6>Informations de test :</h6>
                    <ul>
                        <li>✅ Contrôleur UserController accessible</li>
                        <li>✅ Vue users/test.blade.php chargée</li>
                        <li>✅ Layout app.blade.php fonctionnel</li>
                        <li>✅ Navigation sans authentification</li>
                    </ul>
                    
                    <div class="mt-4">
                        <h6>Prochaines étapes :</h6>
                        <ol>
                            <li>Corriger le système d'authentification</li>
                            <li>Activer les middlewares de sécurité</li>
                            <li>Implémenter la gestion des rôles</li>
                            <li>Ajouter le timeout de 5 minutes</li>
                        </ol>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('pneus.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour aux Pneus
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-warning">
                            <i class="fas fa-sign-in-alt"></i> Page de Connexion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
