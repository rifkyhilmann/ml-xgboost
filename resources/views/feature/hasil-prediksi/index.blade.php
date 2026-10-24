```blade
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
                'label' => 'NIP',
                'field' => 'nip',
            ],
            [
                'label' => 'Nama Pegawai',
                'field' => 'nama',
            ],
            [
                'label' => 'Golongan',
                'field' => 'golongan',
            ],
            [
                'label' => 'Jabatan',
                'field' => 'jabatan',
            ],
            [
                'label' => 'Jenis Mutasi',
                'field' => 'jenis_mutasi',
            ],
            [
                'label' => 'Instansi Asal',
                'field' => 'instansi_asal',
            ],
            [
                'label' => 'Instansi Tujuan',
                'field' => 'instansi_tujuan',
            ],
            [
                'label' => 'Tanggal Prediksi',
                'field' => 'tanggal',
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
```