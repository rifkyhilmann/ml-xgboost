@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-5">

        {{-- Breadcrumb --}}
        <x-breadcrumbs :items="[['label' => 'Dashboard']]" />


    </div>
@endsection
