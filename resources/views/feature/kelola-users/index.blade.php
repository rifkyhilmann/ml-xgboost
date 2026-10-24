@extends('layouts.layout')

@section('content')

<x-index-table
    :breadcrumbs="[
        ['label' => 'Kelola Pengguna']
    ]"

    :datas="$data"

    :columns="[
        [
            'label' => 'Nama',
            'field' => 'name',
        ],
        [
            'label' => 'Email',
            'field' => 'email',
        ],
        [
            'label' => 'Role',
            'field' => 'role',
        ],
    ]"

    :actions="[
        'edit'   => 'kelola-pengguna.edit',
        'delete' => 'kelola-pengguna.destroy',
        'create' => 'kelola-pengguna.create',
    ]"

    :filters="[
        [
            'type'       => 'text',
            'name'       => 'search',
            'label'      => 'Search',
            'placeholder'=> 'Cari pengguna',
            'colspan'    => 3
        ],
    ]"
/>

@endsection