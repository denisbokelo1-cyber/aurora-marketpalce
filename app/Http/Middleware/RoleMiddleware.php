<?php

namespace App\Http\Middleware;


use Closure;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        
        if (!Auth::check()) {
            if ($request->routeIs('admin.*')) {
                return redirect('admin/login'); // Redirect to the admin login route
            } else if ($request->routeIs('seller.*')) {
                return redirect('seller/login'); // Redirect to the seller login route
            } else {
                return redirect('admin/login');
            }
        }
        $user = Auth::user();
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        $roleName = $user->role?->name;
        
        // Fallback: try to resolve role from role_id directly
        if (!$roleName && $user->role_id) {
            $roleModel = \App\Models\Role::find($user->role_id);
            $roleName = $roleModel?->name;
        }
        
        // Fallback: try Spatie role permission system
        if (!$roleName && method_exists($user, 'getRoleNames')) {
            $roleName = $user->getRoleNames()->first();
        }

        $allowedRoles = is_array($roles) ? $roles : [$roles];
        if ($roleName && in_array($roleName, $allowedRoles)) {
            return $next($request);
        }

        throw UnauthorizedException::forRoles($roles);
    }
}
