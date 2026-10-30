@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-6">
        {{-- Breadcrumb --}}
        <x-breadcrumbs :items="[['label' => 'Prediksi']]" />

        @if (session('success'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'text-sm',
                        title: 'text-sm font-medium',
                    }
                });
            </script>
        @endif

        @if ($errors->any())
            <div x-data="{ open: true }" x-show="open"
                class="mb-4 relative flex items-center justify-between  rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" @click="open = false" class=" text-red-500 hover:text-red-700">
                    ✕
                </button>

            </div>
        @endif

        <div class="bg-white shadow rounded-md">
            <div class="h-12 border-b border-zinc-200 flex items-center px-4 gap-2">
                <i data-lucide="sparkles" class="w-5 h-5 text-zinc-500"></i>
                <h2 class="text-sm font-medium text-zinc-800">Prediksi</h2>
            </div>
            
            <form
                action="{{ route('prediksi.create') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex flex-col gap-5 p-6"
            >
                @csrf

                <div class="flex flex-col gap-1">
                    <span class="text-xs">Pegawai</span>
                    <select
                        name="pegawai_id"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option>Pilih Pegawai</option>
                        @foreach($pegawai as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="text-xs">Hasil Kerja</span>
                    <select
                        name="hasil_kerja"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Hasil Kerja</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                        <option value="Di Atas Ekspektasi">Di Atas Ekspektasi</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="text-xs">Perilaku Kerja</span>
                    <select
                        name="perilaku_kerja"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Perilaku Kerja</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                    </select>
                </div>

                <!-- Sedang Hukuman Disiplin Ya/Tidak -->
                <div class="flex flex-col gap-1">
                    <span class="text-xs">Sedang Hukuman Disiplin</span>
                    <select
                        name="sedang_hukuman_disiplin"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>

                <!-- Bebas Temuan Inspektorat Ya/Tidak -->
                <div class="flex flex-col gap-1">
                    <span class="text-xs">Bebas Temuan Inspektorat</span>
                    <select
                        name="bebas_temuan_inspektorat"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <!-- Sedang Tugas Belajar Ya/Tidak -->
                <div class="flex flex-col gap-1">
                    <span class="text-xs">Sedang Tugas Belajar</span>
                    <select
                        name="sedang_tugas_belajar"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>

                <!-- Kesesuaian Formasi / ABK Sesuai/Tidak Sesuai -->
                <div class="flex flex-col gap-1">
                    <span class="text-xs">Kesesuaian Formasi / ABK</span>
                    <select
                        name="kesesuaian_formasi_abk"
                        class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                        required
                    >
                        <option value="">Pilih Kesesuaian</option>
                        <option value="Sesuai">Sesuai</option>
                        <option value="Tidak Sesuai">Tidak Sesuai</option>
                    </select>
                </div>

                <div class="w-full flex items-center justify-end gap-2">
                    <x-button
                        title="Save"
                        type="submit"
                        size="md"
                        variant="primary"
                        icon="save"
                    />
                </div>
            </form>
        </div>
    </div>
@endsection
