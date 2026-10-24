
@extends('layouts.layout')

@section('content')
    <x-generic-form
        :breadcrumbs="[
            [
                'label' => 'Kelola Pegawai',
                'url' => route('kelola-pegawai.index'),
            ],
            [
                'label' => 'Tambah Pegawai',
            ],
        ]"
        title="Tambah Pegawai"
        icon="user-plus"
        action="{{ route('kelola-pegawai.store') }}"
        method="POST"
        :field="[
            [
                'label' => 'NIP',
                'type' => 'text',
                'name' => 'nip',
                'placeholder' => 'Masukkan NIP pegawai',
                'required' => true,
                'colspan' => 3,
            ],
            [
                'label' => 'Nama Pegawai',
                'type' => 'text',
                'name' => 'nama',
                'placeholder' => 'Masukkan nama lengkap pegawai',
                'required' => true,
                'colspan' => 3,
            ],
            [
                'label' => 'Golongan',
                'type' => 'text',
                'name' => 'golongan',
                'placeholder' => 'Contoh: III/a',
                'required' => false,
                'colspan' => 3,
            ],
            [
                'label' => 'Jabatan',
                'type' => 'text',
                'name' => 'jabatan',
                'placeholder' => 'Masukkan jabatan pegawai',
                'required' => false,
                'colspan' => 3,
            ],
            [
                'label' => 'Pendidikan Terakhir',
                'type' => 'select',
                'name' => 'pendidikan_terakhir',
                'placeholder' => 'Pilih pendidikan terakhir',
                'required' => false,
                'options' => [
                    ['value' => 'SMA/SMK', 'label' => 'SMA/SMK'],
                    ['value' => 'D1', 'label' => 'D1'],
                    ['value' => 'D2', 'label' => 'D2'],
                    ['value' => 'D3', 'label' => 'D3'],
                    ['value' => 'D4', 'label' => 'D4'],
                    ['value' => 'S1', 'label' => 'S1'],
                    ['value' => 'S2', 'label' => 'S2'],
                    ['value' => 'S3', 'label' => 'S3'],
                ],
                'colspan' => 3,
            ],
            [
                'label' => 'Tanggal Lahir',
                'type' => 'date',
                'name' => 'tanggal_lahir',
                'required' => false,
                'colspan' => 3,
            ],
            [
                'label' => 'Tanggal Mulai Kerja',
                'type' => 'date',
                'name' => 'tanggal_mulai_kerja',
                'required' => false,
                'colspan' => 3,
            ],
            [
                'label' => 'Instansi Asal',
                'type' => 'text',
                'name' => 'instansi_asal',
                'placeholder' => 'Masukkan nama instansi asal',
                'required' => false,
                'colspan' => 3,
            ],
        ]"
    />
@endsection
