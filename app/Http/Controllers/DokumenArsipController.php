<?php

namespace App\Http\Controllers;

use App\Models\DokumenArsip;
use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DokumenArsipController extends Controller
{
    /**
     * Tampilkan halaman daftar dokumen arsip.
     */
    public function index()
    {
        $dokumen = DokumenArsip::with('kategori')->latest()->get();
        $kategori = KategoriSurat::orderBy('nama')->get();
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        return view('dokumen_arsip.index', compact('dokumen', 'kategori', 'maxUploadMB'));
    }

    /**
     * Simpan data dokumen arsip baru ke database.
     */
    public function store(Request $request)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_dokumen' => 'required|string|max:255|unique:dokumen_arsips,no_dokumen',
            'nama_dokumen' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'penerbit' => 'required|string|max:255',
            'tgl_dokumen' => 'required|date',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_dokumen.required' => 'Nomor dokumen wajib diisi.',
            'no_dokumen.unique' => 'Nomor dokumen ini sudah terdaftar di sistem.',
            'nama_dokumen.required' => 'Nama/Judul dokumen wajib diisi.',
            'kategori_id.required' => 'Kategori dokumen wajib dipilih.',
            'penerbit.required' => 'Penerbit / Bagian / Instansi wajib diisi.',
            'tgl_dokumen.required' => 'Tanggal dokumen wajib diisi.',
            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.mimes' => 'Format file harus berupa PDF, Word, Excel, PowerPoint, ZIP, RAR, atau Gambar.',
            'file_dokumen.max' => 'Ukuran file tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNo = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_dokumen);
            $filename = time() . '_' . $safeNo . '.' . $extension;
            $file->move(public_path('dokumen/arsip_lain'), $filename);
            
            $validated['file_dokumen'] = $filename;
            $validated['tipe_file'] = strtoupper($extension);
            
            // Hitung ukuran file dalam KB / MB
            $sizeBytes = filesize(public_path('dokumen/arsip_lain/' . $filename));
            if ($sizeBytes >= 1048576) {
                $validated['ukuran_file'] = number_format($sizeBytes / 1048576, 2) . ' MB';
            } else {
                $validated['ukuran_file'] = number_format($sizeBytes / 1024, 2) . ' KB';
            }
        }

        $dokumen = DokumenArsip::create($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'dokumen',
            'data' => [
                'title' => 'Unggahan Dokumen Baru',
                'message' => 'Dokumen "' . $dokumen->nama_dokumen . '" (No: ' . $dokumen->no_dokumen . ') telah diunggah ke arsip.',
                'url' => route('dokumen-arsip.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Unggah Dokumen Arsip',
            'pesan' => 'Dokumen "' . $dokumen->nama_dokumen . '" (No: ' . $dokumen->no_dokumen . ') berhasil diunggah dan diarsipkan ke dalam sistem.',
            'tipe' => 'success',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dokumen-arsip.index')->with('success', 'Dokumen berhasil diunggah dan diarsipkan.');
    }

    /**
     * Perbarui data dokumen arsip di database.
     */
    public function update(Request $request, DokumenArsip $dokumen_arsip)
    {
        $maxUploadMB = (int) Setting::get('max_upload_size', 5);
        $maxUploadKB = $maxUploadMB * 1024;

        $validated = $request->validate([
            'no_dokumen' => ['required', 'string', 'max:255', Rule::unique('dokumen_arsips')->ignore($dokumen_arsip->id)],
            'nama_dokumen' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'penerbit' => 'required|string|max:255',
            'tgl_dokumen' => 'required|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:' . $maxUploadKB,
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'no_dokumen.required' => 'Nomor dokumen wajib diisi.',
            'no_dokumen.unique' => 'Nomor dokumen ini sudah terdaftar di sistem.',
            'nama_dokumen.required' => 'Nama/Judul dokumen wajib diisi.',
            'kategori_id.required' => 'Kategori dokumen wajib dipilih.',
            'penerbit.required' => 'Penerbit / Bagian / Instansi wajib diisi.',
            'tgl_dokumen.required' => 'Tanggal dokumen wajib diisi.',
            'file_dokumen.mimes' => 'Format file harus berupa PDF, Word, Excel, PowerPoint, ZIP, RAR, atau Gambar.',
            'file_dokumen.max' => 'Ukuran file tidak boleh melebihi ' . $maxUploadMB . ' MB.',
        ]);

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($dokumen_arsip->file_dokumen && file_exists(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen))) {
                @unlink(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen));
            }

            $file = $request->file('file_dokumen');
            $extension = $file->getClientOriginalExtension();
            $safeNo = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $request->no_dokumen);
            $filename = time() . '_' . $safeNo . '.' . $extension;
            $file->move(public_path('dokumen/arsip_lain'), $filename);
            
            $validated['file_dokumen'] = $filename;
            $validated['tipe_file'] = strtoupper($extension);
            
            // Hitung ukuran file
            $sizeBytes = filesize(public_path('dokumen/arsip_lain/' . $filename));
            if ($sizeBytes >= 1048576) {
                $validated['ukuran_file'] = number_format($sizeBytes / 1048576, 2) . ' MB';
            } else {
                $validated['ukuran_file'] = number_format($sizeBytes / 1024, 2) . ' KB';
            }
        }

        $dokumen_arsip->update($validated);

        // Tambahkan Notifikasi Sistem
        Notification::create([
            'type' => 'dokumen',
            'data' => [
                'title' => 'Pembaruan Dokumen Arsip',
                'message' => 'Data Dokumen "' . $dokumen_arsip->nama_dokumen . '" telah diperbarui.',
                'url' => route('dokumen-arsip.index'),
            ],
        ]);

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Pembaruan Dokumen Arsip',
            'pesan' => 'Data Dokumen "' . $dokumen_arsip->nama_dokumen . '" (No: ' . $dokumen_arsip->no_dokumen . ') berhasil diperbarui.',
            'tipe' => 'info',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dokumen-arsip.index')->with('success', 'Data Dokumen berhasil diperbarui.');
    }

    /**
     * Hapus dokumen arsip beserta filenya dari database.
     */
    public function destroy(DokumenArsip $dokumen_arsip)
    {
        $nama = $dokumen_arsip->nama_dokumen;
        $no = $dokumen_arsip->no_dokumen;

        if ($dokumen_arsip->file_dokumen && file_exists(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen))) {
            @unlink(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen));
        }

        $dokumen_arsip->delete();

        // Tambahkan Log Aktivitas
        LogAktivitas::create([
            'judul' => 'Penghapusan Dokumen Arsip',
            'pesan' => 'Dokumen "' . $nama . '" (No: ' . $no . ') beserta file lampirannya telah dihapus dari sistem.',
            'tipe' => 'danger',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dokumen-arsip.index')->with('success', 'Dokumen berhasil dihapus dari sistem.');
    }

    /**
     * Unduh file dokumen arsip.
     */
    public function download(DokumenArsip $dokumen_arsip)
    {
        if (!$dokumen_arsip->file_dokumen || !file_exists(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen))) {
            return redirect()->route('dokumen-arsip.index')->with('error', 'File dokumen tidak ditemukan di server.');
        }

        $extension = pathinfo($dokumen_arsip->file_dokumen, PATHINFO_EXTENSION);
        $safeNo = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '_', $dokumen_arsip->no_dokumen);
        $filename = $safeNo . '_' . Str::slug($dokumen_arsip->nama_dokumen) . '.' . $extension;

        return response()->download(public_path('dokumen/arsip_lain/' . $dokumen_arsip->file_dokumen), $filename);
    }
}
