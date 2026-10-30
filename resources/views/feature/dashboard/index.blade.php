
@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-5">

        {{-- Breadcrumb --}}
        <x-breadcrumbs :items="[['label' => 'Dashboard']]" />

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Total Users --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-5 flex items-center justify-between">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-zinc-500">Total Users</span>
                    <h2 class="text-2xl font-semibold text-zinc-800">
                        {{ number_format($totalUsers) }}
                    </h2>
                    <span class="text-xs text-zinc-400">Pengguna sistem</span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>

            {{-- Total Pegawai --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-5 flex items-center justify-between">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-zinc-500">Total Pegawai</span>
                    <h2 class="text-2xl font-semibold text-zinc-800">
                        {{ number_format($totalPegawai) }}
                    </h2>
                    <span class="text-xs text-zinc-400">Data pegawai terdaftar</span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="contact-round" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>

            {{-- Total Hasil Prediksi --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-5 flex items-center justify-between">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-zinc-500">Total Hasil Prediksi</span>
                    <h2 class="text-2xl font-semibold text-zinc-800">
                        {{ number_format($totalPrediksi) }}
                    </h2>
                    <span class="text-xs text-zinc-400">Prediksi yang telah dilakukan</span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center">
                    <i data-lucide="chart-no-axes-combined" class="w-6 h-6 text-violet-600"></i>
                </div>
            </div>

        </div>

    </div>
@endsection
