<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se l'utente è autenticato e ha il ruolo di "admin"
        if (Auth::check() && Auth::user()->role->name === 'admin') {
            return $next($request);
        }

        // Se l'utente non ha il ruolo di "admin", reindirizzalo a una pagina di errore o alla home
        return redirect('/')->with('error');
    }
}
