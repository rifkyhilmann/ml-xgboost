<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanMutasi extends Model
{
    protected $table = 'usulan_mutasi';

    protected $fillable = [
        'id_pegawai',
        'jenis_mutasi',
        'instansi_tujuan',
        'tanggal_pengajuan',
        'masa_kerja',
        'nilai_skp',
        'hukuman_disiplin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'date',
            'masa_kerja' => 'decimal:2',
            'nilai_skp' => 'decimal:2',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function hasilPrediksi()
    {
        return $this->hasMany(HasilPrediksi::class, 'id_usulan');
    }
}
