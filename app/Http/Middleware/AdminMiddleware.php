<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $role = UserRole::where('UserID', Auth::id())->first();
        if ($role && $role->RoleID == 1) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
