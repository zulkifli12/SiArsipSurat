<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumen_arsips', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->foreignId('kategori_id')->constrained('kategori_surats')->onDelete('cascade');
            $table->string('penerbit')->nullable();
            $table->date('tgl_dokumen');
            $table->string('file_dokumen');
            $table->string('tipe_file')->nullable();
            $table->string('ukuran_file')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_arsips');
    }
};
