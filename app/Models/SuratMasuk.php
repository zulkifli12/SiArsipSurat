<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $fillable = [
        'no_surat',
        'pengirim',
        'perihal',
        'tgl_surat',
        'tgl_diterima',
        'kategori_id',
        'dokumen',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
}
