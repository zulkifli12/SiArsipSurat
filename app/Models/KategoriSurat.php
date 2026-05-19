<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    protected $fillable = ['nama', 'keterangan'];

    /**
     * Relasi ke tabel surat_masuks.
     */
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    /**
     * Relasi ke tabel surat_keluars.
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_id');
    }
}
