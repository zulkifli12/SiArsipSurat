<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna (termasuk modal tambah & edit).
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Simpan pengguna baru ke database dari modal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'user',
            'data' => [
                'title' => 'Pengguna Baru Terdaftar',
                'message' => 'Akun pengguna ' . $newUser->name . ' telah ditambahkan.',
                'url' => route('users.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Registrasi Pengguna Baru',
            'pesan' => 'Akun pengguna baru "' . $newUser->name . '" (' . $newUser->email . ') berhasil didaftarkan.',
            'tipe' => 'success',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan ke sistem.');
    }

    /**
     * Perbarui data pengguna di database dari modal edit.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Data Pengguna',
            'pesan' => 'Data profil pengguna "' . $user->name . '" berhasil diperbarui.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        if ($request->has('is_profile')) {
            return redirect()->back()->with('success', 'Profil pribadi Anda berhasil diperbarui.');
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        $namaUser = $user->name;
        $user->delete();

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penghapusan Akun Pengguna',
            'pesan' => 'Akun pengguna "' . $namaUser . '" telah dihapus dari sistem.',
            'tipe' => 'danger',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }
}
