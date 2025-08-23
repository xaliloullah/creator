<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    { 
        //   'production', 'development'
        $mode = settings('mode') ?? 'production';
        if (!$request->user() || !$request->user()->isAdmin()) {
            if ($mode === 'maintenance') { 
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'L’application est en maintenance, réessayez plus tard.'
                    ], 503);
                }
                return response()->view('errors.maintenance', [], 503);
            }
        }


        if ($mode === 'demo' && in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            if (!$request->user() || !$request->user()->isAdmin()) {
                if ($request->expectsJson()) {
                    return response()->json([
                    'error' => 'Action désactivée en mode démo.'
                ], 403);
                }
                return back()->withErrors([
                    'error' => 'Action désactivée en mode démo.'
                ]);
            }
        } 
        return $next($request);
    }
}
