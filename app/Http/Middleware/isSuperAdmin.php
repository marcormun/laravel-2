<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class isSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Entrando al middleware isSuperAdmin');
        $userId = auth()->user()->id;

        $user = User::find($userId);

        if(!($user->roles->contains(3))){
            return response()->json([
                'success' => false,
                'message' => 'You can only do this as super admin'
            ],400);
        }
        return $next($request);

    }
}
