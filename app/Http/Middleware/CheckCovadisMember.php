<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCovadisMember
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om deze pagina te bekijken.');
        }

        // Check if the logged-in user is a Covadis member
        if (!Auth::user()->is_covadis_member) {
            return redirect()->route('activity_cards')->with('error', 'Je moet een Covadis-lid zijn om alle Covadis-Activiteiten te bekijken. Je bent nu op Home pagina!');
        }

        return $next($request);
    }
}
