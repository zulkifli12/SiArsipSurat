<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenArsip extends Model
{
    protected $table = 'dokumen_arsips';

    protected $fillable = [
        'no_dokumen',
        'nama_dokumen',
        'kategori_id',
        'penerbit',
        'tgl_dokumen',
        'file_dokumen',
        'tipe_file',
        'ukuran_file',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
}
