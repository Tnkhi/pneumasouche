<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Vérifier si l'utilisateur est actif
            if (!$user->is_active) {
                auth()->logout();
                return redirect()->route('login')->with('error', 'Votre compte a été désactivé.');
            }
            
            // Mettre à jour la dernière activité (sans timeout)
            $user->updateLastActivity();
        }
        
        return $next($request);
    }
}