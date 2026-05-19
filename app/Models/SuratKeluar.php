<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $fillable = [
        'no_surat',
        'penerima',
        'perihal',
        'tgl_surat',
        'kategori_id',
        'dokumen',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
}
