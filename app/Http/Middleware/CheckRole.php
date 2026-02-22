<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request by verifying the authenticated user's role.
     *
     * Usage in routes: ->middleware('role:administrador,supervisor')
     * Multiple roles can be supplied separated by commas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (! $user || ! $user->rol) {
            abort(403);
        }

        $current = strtolower($user->rol->nombre);

        // support passing multiple values in one argument separated by commas,
        // e.g. 'role:supervisor,administrador'. The routing system sometimes
        // keeps the entire list in a single string, so normalize.
        $allowed = [];
        foreach ($roles as $r) {
            foreach (explode(',', $r) as $part) {
                $allowed[] = strtolower(trim($part));
            }
        }

        if (! in_array($current, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
