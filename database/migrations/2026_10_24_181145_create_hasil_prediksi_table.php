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
        Schema::create('hasil_prediksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')
                ->constrained('pegawai')
                ->cascadeOnDelete();
            $table->dateTime('tanggal');
            $table->decimal('probabilitas', 7, 6)
                ->comment('Probabilitas dalam rentang 0 sampai 1');
            $table->string('status', 30)
                ->comment('Contoh: Layak atau Tidak Layak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_prediksi');
    }
};
