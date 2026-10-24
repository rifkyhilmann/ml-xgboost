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
        Schema::create('usulan_mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')
                ->constrained('pegawai')
                ->cascadeOnDelete();

            $table->string('jenis_mutasi', 100);
            $table->string('instansi_tujuan', 200);
            $table->date('tanggal_pengajuan');
            $table->decimal('masa_kerja', 5, 2)->nullable()->comment('Masa kerja dalam tahun');
            $table->decimal('nilai_skp', 5, 2)->nullable()->comment('Nilai SKP');
            $table->string('hukuman_disiplin', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_mutasi');
    }
};
