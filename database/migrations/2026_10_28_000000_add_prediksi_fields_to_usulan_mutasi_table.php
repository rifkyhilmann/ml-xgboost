<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usulan_mutasi', function (Blueprint $table) {
            $table->string('hasil_kerja')->nullable()->after('nilai_skp');
            $table->string('perilaku_kerja')->nullable()->after('hasil_kerja');
            $table->string('kelengkapan_berkas')->nullable()->after('perilaku_kerja');
            $table->string('bebas_temuan_inspektorat')->nullable()->after('hukuman_disiplin');
            $table->string('tugas_belajar')->nullable()->after('bebas_temuan_inspektorat');
            $table->string('kesesuaian_formasi')->nullable()->after('tugas_belajar');
        });
    }

    public function down(): void
    {
        Schema::table('usulan_mutasi', function (Blueprint $table) {
            $table->dropColumn(['hasil_kerja', 'perilaku_kerja', 'kelengkapan_berkas', 'bebas_temuan_inspektorat', 'tugas_belajar', 'kesesuaian_formasi']);
        });
    }
};
