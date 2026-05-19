<?php

namespace App\Http\Controllers;

use App\Models\DokumenArsip;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    /**
     * Tampilkan halaman daftar seluruh arsip surat gabungan (Masuk, Keluar & Dokumen Lain).
     */
    public function index()
    {
        $suratMasukList = SuratMasuk::with('kategori')->latest('updated_at')->get()->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'no_surat' => $item->no_surat,
                'perihal' => $item->perihal,
                'asal_tujuan' => $item->pengirim,
                'tgl' => $item->tgl_surat,
                'jenis' => 'Surat Masuk',
                'badge' => 'status-success',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'kategori_nama' => $item->kategori ? $item->kategori->nama : 'Tanpa Kategori',
                'route' => route('surat-masuk.index'),
            ];
        });

        $suratKeluarList = SuratKeluar::with('kategori')->latest('updated_at')->get()->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'no_surat' => $item->no_surat,
                'perihal' => $item->perihal,
                'asal_tujuan' => $item->penerima,
                'tgl' => $item->tgl_surat,
                'jenis' => 'Surat Keluar',
                'badge' => 'status-info',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'kategori_nama' => $item->kategori ? $item->kategori->nama : 'Tanpa Kategori',
                'route' => route('surat-keluar.index'),
            ];
        });

        $dokumenList = DokumenArsip::with('kategori')->latest('updated_at')->get()->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'no_surat' => $item->no_dokumen,
                'perihal' => $item->nama_dokumen,
                'asal_tujuan' => $item->penerbit ?: 'Internal',
                'tgl' => $item->tgl_dokumen,
                'jenis' => 'Dokumen Arsip',
                'badge' => 'status-warning',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'kategori_nama' => $item->kategori ? $item->kategori->nama : 'Tanpa Kategori',
                'route' => route('dokumen-arsip.index'),
            ];
        });

        $arsip = $suratMasukList->concat($suratKeluarList)->concat($dokumenList)->sortByDesc('updated_at');

        return view('arsip.index', compact('arsip'));
    }
}
