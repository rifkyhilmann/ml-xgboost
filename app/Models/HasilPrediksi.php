<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{
    protected $table = 'hasil_prediksi';

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'probabilitas',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'probabilitas' => 'decimal:6',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
