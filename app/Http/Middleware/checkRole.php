<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {    echo "In Middleware";
        if (auth()->check()) {
            if (auth()->user()->role_id == 1) {
                return redirect()->route('user-Dashboard'); // Make sure to define this route
            } else {
                return redirect()->route('users-home-page'); // Assuming 'home' route exists
            }
        }
        return redirect()->route('login-page')->with('alert','Login To Access The Dashboard Page');
    
    }
}
