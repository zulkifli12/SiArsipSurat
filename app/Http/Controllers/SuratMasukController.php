<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuratMasukController extends Controller
{
    /**
     * Tampilkan halaman daftar surat masuk.
     */
    public function index()
    {
        $suratMasuk = SuratMasuk::with('kategori')->latest()->get();
        $kategori = KategoriSurat::orderBy('nama')->get();
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        return view('surat_masuk.index', compact('suratMasuk', 'kategori', 'maxUploadMB'));
    }

    /**
     * Simpan data surat masuk baru ke database.
     */
    public function store(Request $request)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_surat' => 'required|string|max:255|unique:surat_masuks,no_surat',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'tgl_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_surat.required' => 'Nomor surat wajib diisi.',
            'no_surat.unique' => 'Nomor surat ini sudah terdaftar di sistem.',
            'pengirim.required' => 'Pengirim surat wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'tgl_surat.required' => 'Tanggal surat wajib diisi.',
            'tgl_diterima.required' => 'Tanggal diterima wajib diisi.',
            'kategori_id.required' => 'Kategori surat wajib dipilih.',
            'dokumen.mimes' => 'Format file dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file dokumen tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_surat);
            $filename = time() . '_' . $safeNoSurat . '.' . $extension;
            $file->move(public_path('dokumen/surat_masuk'), $filename);
            $validated['dokumen'] = $filename;
        }

        $suratMasuk = SuratMasuk::create($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'surat_masuk',
            'data' => [
                'title' => 'Surat Masuk Baru',
                'message' => 'Surat nomor ' . $suratMasuk->no_surat . ' dari ' . $suratMasuk->pengirim . ' telah diregistrasikan.',
                'url' => route('surat-masuk.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Registrasi Surat Masuk',
            'pesan' => 'Surat Masuk nomor ' . $suratMasuk->no_surat . ' dari ' . $suratMasuk->pengirim . ' berhasil diregistrasikan ke dalam sistem.',
            'tipe' => 'success',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil diregistrasikan.');
    }

    /**
     * Perbarui data surat masuk di database.
     */
    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_surat' => ['required', 'string', 'max:255', Rule::unique('surat_masuks')->ignore($surat_masuk->id)],
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'tgl_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_surat.required' => 'Nomor surat wajib diisi.',
            'no_surat.unique' => 'Nomor surat ini sudah terdaftar di sistem.',
            'pengirim.required' => 'Pengirim surat wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'tgl_surat.required' => 'Tanggal surat wajib diisi.',
            'tgl_diterima.required' => 'Tanggal diterima wajib diisi.',
            'kategori_id.required' => 'Kategori surat wajib dipilih.',
            'dokumen.mimes' => 'Format file dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file dokumen tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('dokumen')) {
            // Hapus dokumen lama jika ada
            if ($surat_masuk->dokumen && file_exists(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen))) {
                @unlink(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen));
            }
            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_surat);
            $filename = time() . '_' . $safeNoSurat . '.' . $extension;
            $file->move(public_path('dokumen/surat_masuk'), $filename);
            $validated['dokumen'] = $filename;
        }

        $surat_masuk->update($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'surat_masuk',
            'data' => [
                'title' => 'Pembaruan Surat Masuk',
                'message' => 'Surat nomor ' . $surat_masuk->no_surat . ' dari ' . $surat_masuk->pengirim . ' telah diperbarui.',
                'url' => route('surat-masuk.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Surat Masuk',
            'pesan' => 'Data Surat Masuk nomor ' . $surat_masuk->no_surat . ' dari ' . $surat_masuk->pengirim . ' berhasil diperbarui.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Data Surat Masuk berhasil diperbarui.');
    }

    /**
     * Hapus surat masuk beserta dokumennya dari database.
     */
    public function destroy(SuratMasuk $surat_masuk)
    {
        $noSurat = $surat_masuk->no_surat;
        $pengirim = $surat_masuk->pengirim;

        if ($surat_masuk->dokumen && file_exists(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen))) {
            @unlink(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen));
        }

        $surat_masuk->delete();

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penghapusan Surat Masuk',
            'pesan' => 'Surat Masuk nomor ' . $noSurat . ' dari ' . $pengirim . ' beserta lampirannya telah dihapus dari sistem.',
            'tipe' => 'danger',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil dihapus dari sistem.');
    }

    /**
     * Unduh file dokumen surat masuk.
     */
    public function download(SuratMasuk $surat_masuk)
    {
        if (!$surat_masuk->dokumen || !file_exists(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen))) {
            return redirect()->route('surat-masuk.index')->with('error', 'File dokumen tidak ditemukan di server.');
        }

        $extension = pathinfo($surat_masuk->dokumen, PATHINFO_EXTENSION);
        $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $surat_masuk->no_surat);
        $filename = $safeNoSurat . '.' . $extension;

        return response()->download(public_path('dokumen/surat_masuk/' . $surat_masuk->dokumen), $filename);
    }
}
