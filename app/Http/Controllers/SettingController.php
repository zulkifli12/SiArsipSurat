<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan sistem.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.index', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan sistem.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:1000',
            'company_address' => 'nullable|string|max:500',
            'contact_email' => 'required|string|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'max_upload_size' => 'required|integer|min:1|max:50',
            'letter_number_format' => 'required|string|max:255',
        ], [
            'app_name.required' => 'Nama aplikasi/instansi wajib diisi.',
            'contact_email.required' => 'Email kontak wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'max_upload_size.required' => 'Batas ukuran file wajib diisi.',
            'max_upload_size.integer' => 'Batas ukuran file harus berupa angka (MB).',
            'max_upload_size.min' => 'Ukuran file minimal 1 MB.',
            'max_upload_size.max' => 'Ukuran file maksimal 50 MB.',
            'letter_number_format.required' => 'Format penomoran surat wajib diisi.',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Pengaturan Sistem',
            'pesan' => 'Konfigurasi aplikasi dan parameter sistem berhasil diperbarui.',
            'tipe' => 'warning',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
