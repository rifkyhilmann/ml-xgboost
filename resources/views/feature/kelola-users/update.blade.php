@extends('layouts.layout')

@section('content')
    <x-generic-form :breadcrumbs="[
        [
            'label' => 'Kelola Pengguna',
            'url' => route('kelola-pengguna.index'),
        ],
        [
            'label' => 'Update',
        ],
    ]" title="Edit Pengguna" icon="pen"
        action="{{ route('kelola-pengguna.update', $user->id) }}" method="PUT" :field="[
            [
                'label' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'value' => $user->name,
                'placeholder' => 'Masukan nama pengguna',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Email',
                'type' => 'email',
                'name' => 'email',
                'value' => $user->email,
                'placeholder' => 'Masukan email pengguna',
                'required' => true,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Password',
                'type' => 'password',
                'name' => 'password',
                'placeholder' => 'Kosongkan jika tidak ingin mengubah password',
                'required' => false,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Konfirmasi Password',
                'type' => 'password',
                'name' => 'password_confirmation',
                'placeholder' => 'Masukan ulang password baru',
                'required' => false,
                'colspan' => 3,
            ],
        
            [
                'label' => 'Role',
                'type' => 'select',
                'name' => 'role',
                'required' => true,
                'value' => $user->role,
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
