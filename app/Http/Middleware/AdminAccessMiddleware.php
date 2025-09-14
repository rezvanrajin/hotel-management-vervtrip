<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role == 2 || !Helper::hasRight('role.view')) {
            session()->flash('error', 'You cannot access! Login first.');
            return redirect()->route('admin');
        }

        return $next($request);
    }
}