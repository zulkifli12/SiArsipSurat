<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriSuratController extends Controller
{
    /**
     * Tampilkan halaman daftar kategori surat.
     */
    public function index()
    {
        $kategori = KategoriSurat::withCount(['suratMasuk', 'suratKeluar'])->latest()->get();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Simpan kategori surat baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_surats,nama',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori ini sudah terdaftar di sistem.',
        ]);

        $kategori = KategoriSurat::create($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'kategori',
            'data' => [
                'title' => 'Kategori Surat Baru',
                'message' => 'Kategori ' . $kategori->nama . ' telah ditambahkan ke sistem.',
                'url' => route('kategori.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penambahan Kategori Surat',
            'pesan' => 'Kategori Surat baru "' . $kategori->nama . '" berhasil ditambahkan.',
            'tipe' => 'success',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    /**
     * Perbarui data kategori surat di database.
     */
    public function update(Request $request, KategoriSurat $kategori)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('kategori_surats')->ignore($kategori->id)],
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori ini sudah terdaftar di sistem.',
        ]);

        $kategori->update($validated);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Kategori Surat',
            'pesan' => 'Data Kategori Surat "' . $kategori->nama . '" berhasil diperbarui.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori surat dari database.
     */
    public function destroy(KategoriSurat $kategori)
    {
        // Cek apakah kategori masih digunakan oleh surat masuk atau surat keluar
        $totalPenggunaan = $kategori->suratMasuk()->count() + $kategori->suratKeluar()->count();

        if ($totalPenggunaan > 0) {
            return redirect()->route('kategori.index')->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih digunakan oleh {$totalPenggunaan} arsip surat.");
        }

        $namaKategori = $kategori->nama;
        $kategori->delete();

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penghapusan Kategori Surat',
            'pesan' => 'Kategori Surat "' . $namaKategori . '" telah dihapus dari sistem.',
            'tipe' => 'warning',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori surat berhasil dihapus dari sistem.');
    }
}
