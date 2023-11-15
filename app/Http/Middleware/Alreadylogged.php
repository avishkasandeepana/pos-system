<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Alreadylogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     


        // Check if the user is already logged in and trying to access the login page
        if (Session::has('loginId') && (route('loginpage') == $request->url() || route('logout') == $request->url() || route('login') == $request->url()) ) {
            return redirect()->back();
        }
        $response = $next($request);
    $response->headers->add([
        'Cache-Control' => 'no-cache, no-store, must-revalidate', 
        'Pragma' => 'no-cache', 
        'Expires' => '0'
    ]);
    return $response;
    }
}
