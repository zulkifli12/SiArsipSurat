<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.demo_mode', true)) {
            // Izinkan jika ini adalah pembaruan profil mandiri pengguna yang sedang login (is_profile)
            if ($request->is('users/*') && $request->isMethod('PUT') && $request->has('is_profile')) {
                return $next($request);
            }

            // Daftar rute atau pola yang dibatasi di Edisi GitHub / Demo Mode
            $restricted = false;
            $featureName = 'Fitur Krusial';

            if ($request->is('users*')) {
                $restricted = true;
                $featureName = 'Manajemen Pengguna';
            } elseif ($request->is('settings*')) {
                $restricted = true;
                $featureName = 'Pengaturan Sistem';
            } elseif ($request->routeIs('*.download')) {
                $restricted = true;
                $featureName = 'Unduh Dokumen Lampiran';
            } elseif ($request->isMethod('DELETE')) {
                $restricted = true;
                $featureName = 'Penghapusan Data';
            } elseif ($request->isMethod('POST') && !$request->routeIs('logout') && !$request->routeIs('notifications.readAll')) {
                $restricted = true;
                $featureName = 'Penambahan Data Baru';
            } elseif ($request->isMethod('PUT') || $request->isMethod('PATCH')) {
                $restricted = true;
                $featureName = 'Pembaruan Data';
            }

            if ($restricted) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Fitur {$featureName} dikunci pada Edisi GitHub (Lite Version). Silakan hubungi pengembang untuk mendapatkan Full Version."
                    ], 403);
                }

                return redirect()->route('dashboard')->with('demo_restricted', $featureName);
            }
        }

        return $next($request);
    }
}
