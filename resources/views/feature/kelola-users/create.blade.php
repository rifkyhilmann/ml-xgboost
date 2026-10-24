@extends('layouts.layout')

@section('content')
    <x-generic-form :breadcrumbs="[
        [
            'label' => 'Kelola Pengguna',
            'url' => route('kelola-pengguna.index'),
        ],
        [
            'label' => 'Create',
        ],
    ]" title="Tambah Pengguna" icon="user-plus" action="{{ route('kelola-pengguna.store') }}"
        method="POST" :field="[
            [
                'label' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Masukan nama pengguna',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Email',
                'type' => 'email',
                'name' => 'email',
                'placeholder' => 'Masukan email pengguna',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Password',
                'type' => 'password',
                'name' => 'password',
                'placeholder' => 'Masukan password',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Konfirmasi Password',
                'type' => 'password',
                'name' => 'password_confirmation',
                'placeholder' => 'Masukan ulang password',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Role',
                'type' => 'select',
                'name' => 'role',
                'placeholder' => 'Pilih role',
                'required' => true,
                'options' => [
                    [
                        'value' => 'admin',
                        'label' => 'Admin',
                    ],
                    [
                        'value' => 'superadmin',
                        'label' => 'Superadmin',
                    ],
                ],
                'colspan' => 3,
            ],
        ]" />
@endsection
