<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $requiredRole)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $roleHierarchy = [
            'user' => 1,
            'editor' => 2,
            'admin' => 3,
        ];

        // Check if user's role exists in hierarchy
        if (!isset($roleHierarchy[$user->role]) || $roleHierarchy[$user->role] < $roleHierarchy[$requiredRole]) {
            abort(403, 'Unauthorized'); // ⛔ User does not have permission
        }

        return $next($request); // ✅ User has required role or higher
    }
}