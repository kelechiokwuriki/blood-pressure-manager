<?php

namespace App\Http\Middleware;

use Closure;

class ExportStaffs
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
        if (auth()->user()->role !== 'admin') {
            return back()->with('status', 'Only admins can export.');
        }

        return $next($request);
    }
}
