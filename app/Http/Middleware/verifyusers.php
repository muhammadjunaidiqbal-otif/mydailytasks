<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class verifyusers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "In Middleware";
        if(Auth::check()){
            return $next($request);
        }else{
            echo "Login to Accesss";
            return redirect()->route('login-page')->with('alert','Login To Access The Dashboard Page');
        }
        
    }
}
