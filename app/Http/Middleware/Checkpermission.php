<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserRole;
use App\Models\RolePermission;



class Checkpermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current user's roles
        $userRoles = UserRole::where('UserID', $request->user()->id)->pluck('RoleID');

        // Check if the user has the required role for the requested route
        $hasPermission = RolePermission::whereIn('RoleID', $userRoles)
            ->where('Description', $request->route()->getName())
            ->exists();

        if (!$hasPermission) {
            // If the user doesn't have permission, return a 403 response
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
