<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminHas2FA
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $this->isAdmin($user)) {
            // Wajib ada secret & sudah terkonfirmasi
            $enabled   = ! is_null($user->two_factor_secret);
            $confirmed = ! is_null($user->two_factor_confirmed_at);

            if (! $enabled || ! $confirmed) {
                // Izinkan akses ke halaman setup 2FA & endpoint Fortify 2FA saja
                if ($request->routeIs('security.2fa') || $this->isFortifyTwoFactorEndpoint($request)) {
                    return $next($request);
                }

                return redirect()
                    ->route('security.2fa')
                    ->with('status', 'Admin wajib mengaktifkan & mengonfirmasi 2FA sebelum mengakses area admin.');
            }
        }

        return $next($request);
    }

    protected function isAdmin($user): bool
    {
        // Pakai konstanta jika ada, fallback string 'admin'
        return ($user->role ?? null) === 'admin'
            || (defined(get_class($user).'::ROLE_ADMIN') && $user->role === $user::ROLE_ADMIN);
    }

    protected function isFortifyTwoFactorEndpoint(Request $request): bool
    {
        // Endpoint bawaan Fortify untuk enable/confirm/recovery codes/disable
        $path = ltrim($request->path(), '/');
        return str_starts_with($path, 'user/two-factor');
    }
}
