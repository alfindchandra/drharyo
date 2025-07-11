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
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabang');
            $table->enum('rencana_pembayaran', ['Umum', 'BPJS']);
            $table->date('tanggal');
            $table->enum('waktu', ['Pagi', 'Malam',]);
            $table->foreignId('dokter_id')->constrained('dokter');
            $table->string('nama_pasien');
            $table->string('nik', 16);
            $table->string('no_wa', 15);
            $table->integer('nomor_antrian');
            $table->enum('status', ['Antrian', 'Dipanggil', 'Selesai'])->default('Antrian');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('antrian');
    }
};
