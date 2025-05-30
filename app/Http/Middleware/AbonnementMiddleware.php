<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbonnementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null $tarif Le nom du tarif requis pour accéder à la ressource
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $tarif = null): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Vous devez être connecté pour accéder à cette ressource.']);
        }
        $abonnement = $user->Abonnements()
            ->where('etat', true)
            ->first();

        if (!$abonnement) {
            return back()->withErrors(['error' => 'Aucun abonnement trouvé. Veuillez souscrire pour accéder à cette ressource.']);
        }

        if (!$abonnement->isActive()) {
            return back()->withErrors(['error' => 'Votre abonnement n\'est pas actif.']);
        }

        if ($tarif && $abonnement->Tarif->nom !== $tarif) {
            return back()->withErrors(['error' => 'Votre abonnement actuel ne permet pas d\'accéder à cette ressource.']);
        }

        return $next($request);
    }
}
