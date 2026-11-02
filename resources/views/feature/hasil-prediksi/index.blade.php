
@extends('layouts.layout')

@section('content')
    <x-index-table
        :breadcrumbs="[
            [
                'label' => 'Hasil Prediksi',
            ],
        ]"

        :datas="$data"
        cetak="{{ route('laporan.cetak', request()->query()) }}"
        :columns="[
            [
                'label' => 'Pegawai',
                'field' => 'pegawai.nama',
            ],
            [
                'label' => 'Tanggal Prediksi',
                'field' => 'tanggal',
                'type'  => 'date'
            ],
            [
                'label' => 'Probabilitas',
                'field' => 'probabilitas',
            ],
            [
                'label' => 'Status Prediksi',
                'field' => 'status',
                'type'  => 'status',
            ],
        ]"

        :filters="[
            [
                'type' => 'text',
                'name' => 'search',
                'label' => 'Pencarian',
                'placeholder' => 'Cari NIP, nama, atau instansi',
                'colspan' => 3,
            ],
            [
                'type' => 'date',
                'name' => 'tanggal_mulai',
                'label' => 'Tangal Mulai',
                'placeholder' => 'Tanggal Mulai',
                'colspan' => 3,
            ],
            [
                'type' => 'date',
                'name' => 'tanggal_selesai',
                'label' => 'Tangal Akhir',
                'placeholder' => 'Tanggal Akhir',
                'colspan' => 3,
            ],
            [
                'type' => 'select',
                'name' => 'id_pegawai',
                'label' => 'Pegawai',
                'placeholder' => 'Semua Pegawai',
                'options' => $pegawai->map(function ($item) {
                    return [
                        'value' => $item->id,
                        'label' => $item->nama,
                    ];
                })->toArray(),
                'colspan' => 3,
            ],
        ]"
    />
@endsection
