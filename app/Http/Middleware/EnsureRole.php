<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['auth' => 'Please login first.']);
        }

        $user = Auth::user();

        // gunakan pengecekan berdasarkan role_id jika parameter numeric,
        // jika bukan numeric fallback ke pencocokan nama role
        if (is_numeric($role)) {
            if ((int) $user->role_id !== (int) $role) {
                abort(403, 'You are not authorized to access this page.');
            }
        } else {
            if (optional($user->role)->name !== $role) {
                abort(403, 'You are not authorized to access this page.');
            }
        }

        return $next($request);
    }
}
