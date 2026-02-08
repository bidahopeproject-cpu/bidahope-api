<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $plainToken = $request->bearerToken();

        if (!$plainToken) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Hash the incoming token to match what is in the DB
        $hashedToken = hash('sha256', $plainToken);

        $tokenRecord = DB::table('personal_access_tokens')
            ->where('token', $hashedToken)
            ->first();

        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Optional: Log the user in for the duration of this request
        $user = User::find($tokenRecord->tokenable_id);
        Auth::login($user);

        // Update last_used_at
        DB::table('personal_access_tokens')
            ->where('id', $tokenRecord->id)
            ->update(['last_used_at' => now()]);

        return $next($request);
    }
}
