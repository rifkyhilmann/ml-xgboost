<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'golongan',
        'jabatan',
        'pendidikan_terakhir',
        'tanggal_lahir',
        'tanggal_mulai_kerja',
        'instansi_asal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_mulai_kerja' => 'date',
        ];
    }

    public function hasilPrediksi()
    {
        return $this->hasMany(HasilPrediksi::class, 'id_pegawai');
    }
}
