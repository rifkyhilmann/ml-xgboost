
@extends('layouts.layout')

@section('content')
    <x-index-table
        :breadcrumbs="[
            [
                'label' => 'Hasil Prediksi',
            ],
        ]"

        :datas="$data"

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
        ]"
    />
@endsection
