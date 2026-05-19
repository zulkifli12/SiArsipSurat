<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming forgot password request (Custom Implementation).
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Alamat email yang Anda masukkan tidak terdaftar di sistem kami.',
        ]);

        $token = Str::random(64);

        // Menghapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Menyimpan token baru ke database
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::to($request->email)->send(new ResetPasswordMail($resetUrl, $request->email));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email reset sandi: ' . $e->getMessage());
            Log::info('Tautan Reset Sandi (Manual untuk Mode Pengembangan): ' . $resetUrl);
        }

        return back()->with('status', 'Tautan pengaturan ulang kata sandi telah dikirim ke alamat email Anda.');
    }

    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request, $token)
    {
        $record = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $request->query('email'))
            ->first();

        if (!$record) {
            return redirect()->route('login')->withErrors(['email' => 'Token Tidak Valid']);
        }

        // Hitung waktu kedaluwarsa (5 menit dari created_at)
        $expiresAt = Carbon::parse($record->created_at)->addMinutes(5)->toIso8601String();

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
            'expiresAt' => $expiresAt,
        ]);
    }

    /**
     * Handle an incoming new password reset request (Custom Implementation).
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.exists' => 'Alamat email tidak ditemukan di sistem kami.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
        ]);

        // Verifikasi token di tabel password_reset_tokens
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return redirect()->route('login')->withErrors(['email' => 'Token Tidak Valid']);
        }

        // Periksa kedaluwarsa token (5 menit)
        if (Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('login')->withErrors(['email' => 'Token Tidak Valid']);
        }

        // Perbarui kata sandi pengguna
        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now()
            ]);

        // Hapus token yang sudah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diatur ulang. Silakan masuk dengan kata sandi baru.');
    }
}
