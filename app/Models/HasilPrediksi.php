<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{
    protected $table = 'hasil_prediksi';

    protected $fillable = [
        'id_usulan',
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

    public function usulanMutasi()
    {
        return $this->belongsTo(UsulanMutasi::class, 'id_usulan');
    }
}
