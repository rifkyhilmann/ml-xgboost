
@extends('layouts.layout')

@section('content')
    <x-index-table
        :breadcrumbs="[
            [
                'label' => 'Kelola Pegawai',
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
                'label' => 'Pendidikan Terakhir',
                'field' => 'pendidikan_terakhir',
            ],
            [
                'label' => 'Tanggal Lahir',
                'field' => 'tanggal_lahir',
                'type' => 'date',
            ],
            [
                'label' => 'Tanggal Mulai Kerja',
                'field' => 'tanggal_mulai_kerja',
                'type' => 'date',
            ],
            [
                'label' => 'Instansi Asal',
                'field' => 'instansi_asal',
            ],
        ]"

        :actions="[
            'edit'   => 'kelola-pegawai.edit',
            'delete' => 'kelola-pegawai.destroy',
            'create' => 'kelola-pegawai.create',
        ]"

        :filters="[
            [
                'type' => 'text',
                'name' => 'search',
                'label' => 'Pencarian',
                'placeholder' => 'Cari NIP, nama, jabatan, atau instansi',
                'colspan' => 3,
            ],
        ]"
    />
@endsection
