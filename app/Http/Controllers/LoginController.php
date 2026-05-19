<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            \App\Models\LogAktivitas::create([
                'judul' => 'Sesi Login',
                'pesan' => auth()->user()->name . ' berhasil masuk ke sistem.',
                'tipe' => 'success',
                'user_id' => auth()->id(),
            ]);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Username atau password yang Anda masukkan tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {
            \App\Models\LogAktivitas::create([
                'judul' => 'Sesi Logout',
                'pesan' => auth()->user()->name . ' keluar dari sistem.',
                'tipe' => 'info',
                'user_id' => auth()->id(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
