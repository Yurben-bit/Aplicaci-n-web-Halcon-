<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(empty($roles)) {
            return $next($request);
        }

        if(!$request->user()){
            return redirect('/login');
        }

        foreach($roles as $role){
            if($request->user()->roles->contains('nombreRol', $role)){
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'Acceso Denegado: No tienes permiso para acceder a esta página.');
    }
}
