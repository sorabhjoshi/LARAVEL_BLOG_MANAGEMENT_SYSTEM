<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $roles = explode('|', $role);
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('login');
            return response()->view('Blogbackend.error', [], 403);  
        }

        return $next($request);
    }
}

