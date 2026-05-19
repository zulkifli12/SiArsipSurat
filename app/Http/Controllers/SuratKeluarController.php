<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuratKeluarController extends Controller
{
    /**
     * Tampilkan halaman daftar surat keluar.
     */
    public function index()
    {
        $suratKeluar = SuratKeluar::with('kategori')->latest()->get();
        $kategori = KategoriSurat::orderBy('nama')->get();
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);

        $format = Setting::get('letter_number_format', 'PTPN-IV/SM/{tahun}/{bulan}/{nomor}');
        $formatSK = str_replace('/SM/', '/SK/', $format);
        $nextNomor = str_pad(SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT);
        $defaultNoSurat = str_replace(['{tahun}', '{bulan}', '{nomor}'], [date('Y'), date('m'), $nextNomor], $formatSK);

        return view('surat_keluar.index', compact('suratKeluar', 'kategori', 'maxUploadMB', 'defaultNoSurat'));
    }

    /**
     * Simpan data surat keluar baru ke database.
     */
    public function store(Request $request)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_surat' => 'required|string|max:255|unique:surat_keluars,no_surat',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_surat.required' => 'Nomor surat wajib diisi.',
            'no_surat.unique' => 'Nomor surat ini sudah terdaftar di sistem.',
            'penerima.required' => 'Penerima / Instansi tujuan wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'tgl_surat.required' => 'Tanggal surat wajib diisi.',
            'kategori_id.required' => 'Kategori surat wajib dipilih.',
            'dokumen.mimes' => 'Format file dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file dokumen tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_surat);
            $filename = time() . '_' . $safeNoSurat . '.' . $extension;
            $file->move(public_path('dokumen/surat_keluar'), $filename);
            $validated['dokumen'] = $filename;
        }

        $suratKeluar = SuratKeluar::create($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'surat_keluar',
            'data' => [
                'title' => 'Surat Keluar Baru',
                'message' => 'Surat nomor ' . $suratKeluar->no_surat . ' tujuan ' . $suratKeluar->penerima . ' telah diregistrasikan.',
                'url' => route('surat-keluar.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Registrasi Surat Keluar',
            'pesan' => 'Surat Keluar nomor ' . $suratKeluar->no_surat . ' tujuan ' . $suratKeluar->penerima . ' berhasil diregistrasikan ke dalam sistem.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil diregistrasikan.');
    }

    /**
     * Perbarui data surat keluar di database.
     */
    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_surat' => ['required', 'string', 'max:255', Rule::unique('surat_keluars')->ignore($surat_keluar->id)],
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_surat.required' => 'Nomor surat wajib diisi.',
            'no_surat.unique' => 'Nomor surat ini sudah terdaftar di sistem.',
            'penerima.required' => 'Penerima / Instansi tujuan wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'tgl_surat.required' => 'Tanggal surat wajib diisi.',
            'kategori_id.required' => 'Kategori surat wajib dipilih.',
            'dokumen.mimes' => 'Format file dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file dokumen tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('dokumen')) {
            // Hapus dokumen lama jika ada
            if ($surat_keluar->dokumen && file_exists(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen))) {
                @unlink(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen));
            }
            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_surat);
            $filename = time() . '_' . $safeNoSurat . '.' . $extension;
            $file->move(public_path('dokumen/surat_keluar'), $filename);
            $validated['dokumen'] = $filename;
        }

        $surat_keluar->update($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'surat_keluar',
            'data' => [
                'title' => 'Pembaruan Surat Keluar',
                'message' => 'Surat nomor ' . $surat_keluar->no_surat . ' tujuan ' . $surat_keluar->penerima . ' telah diperbarui.',
                'url' => route('surat-keluar.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Surat Keluar',
            'pesan' => 'Data Surat Keluar nomor ' . $surat_keluar->no_surat . ' tujuan ' . $surat_keluar->penerima . ' berhasil diperbarui.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Data Surat Keluar berhasil diperbarui.');
    }

    /**
     * Hapus surat keluar beserta dokumennya dari database.
     */
    public function destroy(SuratKeluar $surat_keluar)
    {
        $noSurat = $surat_keluar->no_surat;
        $penerima = $surat_keluar->penerima;

        if ($surat_keluar->dokumen && file_exists(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen))) {
            @unlink(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen));
        }

        $surat_keluar->delete();

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penghapusan Surat Keluar',
            'pesan' => 'Surat Keluar nomor ' . $noSurat . ' tujuan ' . $penerima . ' beserta lampirannya telah dihapus dari sistem.',
            'tipe' => 'danger',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil dihapus dari sistem.');
    }

    /**
     * Unduh file dokumen surat keluar.
     */
    public function download(SuratKeluar $surat_keluar)
    {
        if (!$surat_keluar->dokumen || !file_exists(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen))) {
            return redirect()->route('surat-keluar.index')->with('error', 'File dokumen tidak ditemukan di server.');
        }

        $extension = pathinfo($surat_keluar->dokumen, PATHINFO_EXTENSION);
        $safeNoSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $surat_keluar->no_surat);
        $filename = $safeNoSurat . '.' . $extension;

        return response()->download(public_path('dokumen/surat_keluar/' . $surat_keluar->dokumen), $filename);
    }
}
