<?php

namespace App\Http\Middleware;

use Closure;

class ExportObservation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role !== 'admin' || auth()->user()->role !== 'doctor') {
            return back()->with('status', 'Only admins and doctors can export.');
        }
        return $next($request);
    }
}
