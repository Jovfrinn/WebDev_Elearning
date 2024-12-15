<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {   
        if (!$request->user() || !in_array($request->user()->id_role, $roles)) {
        // abort(403, 'Unauthorized .');
            return redirect()->back()->with(403, 'Unauthorized');
    }

    return $next($request);
    }

    }

