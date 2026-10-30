@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-6">
        {{-- Breadcrumb --}}
        <x-breadcrumbs :items="[['label' => 'Prediksi']]" />

        {{-- Card Keterangan --}}
        {{-- Hasil Prediksi --}}
        {{-- @if (session('prediksi_result'))
            @php
                $hasilPrediksi = session('prediksi_result');
            @endphp

            <div class="bg-white border border-zinc-200 shadow-sm rounded-md overflow-hidden">
                <div class="h-12 border-b border-zinc-200 flex items-center px-4 gap-2">
                    <i data-lucide="clipboard-check" class="w-5 h-5 text-zinc-500"></i>
                    <h2 class="text-sm font-medium text-zinc-800">
                        Hasil Prediksi
                    </h2>
                </div>

                <div class="p-5 grid grid-cols-2 gap-4">
                    <div class="rounded-lg border border-zinc-200 p-4">
                        <span class="text-xs text-zinc-500">Status Prediksi</span>

                        <div class="mt-2">
                            @if ($hasilPrediksi['status'] === 'Layak')
                                <span
                                    class="inline-flex items-center rounded-full bg-green-50 text-green-700 px-3 py-1 text-sm font-medium">
                                    <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                    Layak
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red-50 text-red-700 px-3 py-1 text-sm font-medium">
                                    <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                                    Tidak Layak
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-lg border border-zinc-200 p-4">
                        <span class="text-xs text-zinc-500">Probabilitas Prediksi</span>

                        <div class="mt-2 text-2xl font-semibold text-zinc-800">
                            {{ number_format($hasilPrediksi['probabilitas'], 2, ',', '.') }}%
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}

        @if (session('prediksi_result'))
            @php
                $hasilPrediksi = session('prediksi_result');
                $isLayak = $hasilPrediksi['status'] === 'Layak';
                $probabilitas = $hasilPrediksi['probabilitas'];

                // Menentukan warna tema berdasarkan status
                $themeColor = $isLayak ? 'green' : 'red';
            @endphp

            <div class="bg-white border border-zinc-200 shadow-sm rounded-xl overflow-hidden mt-6 animate-fade-in">
                <!-- Header dengan Nama Pegawai -->
                <div class="bg-zinc-50 border-b border-zinc-200 px-5 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-{{ $themeColor }}-100 text-{{ $themeColor }}-600 p-2 rounded-lg">
                            <i data-lucide="user-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-zinc-800 uppercase tracking-wide">Hasil Analisis
                                Klasifikasi</h2>
                            <p class="text-xs text-zinc-500 mt-0.5">Pegawai: <span
                                    class="font-medium text-zinc-700">{{ $hasilPrediksi['pegawai'] }}</span></p>
                        </div>
                    </div>

                    <!-- Badge Status Utama -->
                    <span
                        class="inline-flex items-center rounded-full bg-{{ $themeColor }}-50 text-{{ $themeColor }}-700 border border-{{ $themeColor }}-200 px-3 py-1 text-sm font-medium">
                        <i data-lucide="{{ $isLayak ? 'check-circle' : 'x-circle' }}" class="w-4 h-4 mr-1.5"></i>
                        {{ $hasilPrediksi['status'] }}
                    </span>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Sisi Kiri: Probabilitas & Progress Bar -->
                        <div class="rounded-lg border border-zinc-100 bg-zinc-50/50 p-5">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-zinc-600">Tingkat Keyakinan Model</span>
                                <span
                                    class="text-2xl font-bold text-zinc-800">{{ number_format($probabilitas, 1, ',', '.') }}%</span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="w-full bg-zinc-200 rounded-full h-2.5 mb-4">
                                <div class="bg-primary-500 h-2.5 rounded-full transition-all duration-1000 ease-out"
                                    style="width: {{ $probabilitas }}%"></div>
                            </div>

                            <!-- Actionable Insight / Pesan -->
                            <div
                                class="mt-4 p-3 rounded bg-{{ $themeColor }}-50/50 border-l-4 border-{{ $themeColor }}-500">
                                <p class="text-xs text-zinc-600">
                                    @if ($isLayak)
                                        <strong>Rekomendasi:</strong> Pegawai ini memenuhi kriteria kelayakan. Disarankan
                                        untuk memproses tahap administrasi selanjutnya.
                                    @else
                                        <strong>Rekomendasi:</strong> Pegawai belum memenuhi standar kelayakan. Perlu
                                        dilakukan evaluasi kinerja atau pembinaan lebih lanjut.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Sisi Kanan: Rangkuman Data Input -->
                        <div class="rounded-lg border border-zinc-100 p-5">
                            <span class="text-sm font-medium text-zinc-600 mb-3 block">Berdasarkan Parameter Input:</span>
                            <div class="flex flex-wrap gap-2">
                                <!-- Menampilkan Masa Kerja -->
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded bg-zinc-100 text-zinc-700 text-xs font-medium border border-zinc-200">
                                    Masa Kerja: {{ $hasilPrediksi['data']['Masa_Kerja'] ?? 0 }} Tahun
                                </span>

                                <!-- Logika sederhana untuk menampilkan parameter lain yang bernilai 1 (True) -->
                                @foreach ($hasilPrediksi['data'] as $key => $value)
                                    @if ($value === 1 && $key !== 'Masa_Kerja')
                                        @php
                                            // Merapikan nama key (misal: 'Hasil_Kerja_Di Bawah Ekspektasi' menjadi 'Hasil Kerja: Di Bawah Ekspektasi')
                                            $cleanLabel = str_replace('_', ' ', $key);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded bg-zinc-100 text-zinc-700 text-xs font-medium border border-zinc-200">
                                            {{ $cleanLabel }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                            <p class="text-[10px] text-zinc-400 mt-3">*Parameter di atas adalah fitur yang diolah oleh model
                                XGBoost.</p>
                        </div>

                    </div>
                </div>
            </div>
        @endif

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

        {{-- Pesan Error dari Controller --}}
        @if (session('error'))
            <div x-data="{ open: true }" x-show="open"
                class="mb-4 relative flex items-center justify-between rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>{{ session('error') }}</span>
                </div>

                <button type="button" @click="open = false" class="text-red-500 hover:text-red-700">
                    ✕
                </button>
            </div>
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

            <form action="{{ route('prediksi.create') }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-5 p-6">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Pegawai</span>
                        <select name="pegawai_id"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Pegawai</option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pegawai_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Masa Kerja</span>
                        <input type="number" name="masa_kerja"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            placeholder="Masukkan Masa Kerja (Tahun)" value="{{ old('masa_kerja') }}" required>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Hasil Kerja</span>
                        <select name="hasil_kerja"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Hasil Kerja</option>
                            <option value="Di Bawah Ekspektasi"
                                {{ old('hasil_kerja') == 'Di Bawah Ekspektasi' ? 'selected' : '' }}>Di Bawah Ekspektasi
                            </option>
                            <option value="Sesuai Ekspektasi"
                                {{ old('hasil_kerja') == 'Sesuai Ekspektasi' ? 'selected' : '' }}>Sesuai Ekspektasi
                            </option>
                            <option value="Di Atas Ekspektasi"
                                {{ old('hasil_kerja') == 'Di Atas Ekspektasi' ? 'selected' : '' }}>Di Atas Ekspektasi
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Perilaku Kerja</span>
                        <select name="perilaku_kerja"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Perilaku Kerja</option>
                            <option value="Di Bawah Ekspektasi"
                                {{ old('perilaku_kerja') == 'Di Bawah Ekspektasi' ? 'selected' : '' }}>Di Bawah Ekspektasi
                            </option>
                            <option value="Sesuai Ekspektasi"
                                {{ old('perilaku_kerja') == 'Sesuai Ekspektasi' ? 'selected' : '' }}>Sesuai Ekspektasi
                            </option>
                            <option value="Di Atas Ekspektasi"
                                {{ old('perilaku_kerja') == 'Di Atas Ekspektasi' ? 'selected' : '' }}>Di Atas Ekspektasi
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Kelengkapan Berkas</span>
                        <select name="kelengkapan_berkas"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="Tidak Lengkap"
                                {{ old('kelengkapan_berkas') == 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                            <option value="Lengkap" {{ old('kelengkapan_berkas') == 'Lengkap' ? 'selected' : '' }}>Lengkap
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Sedang Hukuman Disiplin</span>
                        <select name="sedang_hukuman_disiplin"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="Tidak" {{ old('sedang_hukuman_disiplin') == 'Tidak' ? 'selected' : '' }}>Tidak
                            </option>
                            <option value="Ya" {{ old('sedang_hukuman_disiplin') == 'Ya' ? 'selected' : '' }}>Ya
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Bebas Temuan Inspektorat</span>
                        <select name="bebas_temuan_inspektorat"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="Ya" {{ old('bebas_temuan_inspektorat') == 'Ya' ? 'selected' : '' }}>Ya
                            </option>
                            <option value="Tidak" {{ old('bebas_temuan_inspektorat') == 'Tidak' ? 'selected' : '' }}>Tidak
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Sedang Tugas Belajar</span>
                        <select name="sedang_tugas_belajar"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="Tidak" {{ old('sedang_tugas_belajar') == 'Tidak' ? 'selected' : '' }}>Tidak
                            </option>
                            <option value="Ya" {{ old('sedang_tugas_belajar') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-xs">Kesesuaian Formasi / ABK</span>
                        <select name="kesesuaian_formasi_abk"
                            class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                            required>
                            <option value="">Pilih Kesesuaian</option>
                            <option value="Sesuai" {{ old('kesesuaian_formasi_abk') == 'Sesuai' ? 'selected' : '' }}>
                                Sesuai
                            </option>
                            <option value="Tidak Sesuai"
                                {{ old('kesesuaian_formasi_abk') == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai
                            </option>
                        </select>
                    </div>
                </div>


                <div class="w-full flex items-center justify-end gap-2">
                    <button type="button" onclick="window.location.href='{{ route('prediksi') }}'"
                        class="px-4 py-2 text-sm font-medium text-zinc-600 border border-zinc-200 rounded-lg hover:bg-zinc-50 transition">
                        Reset
                    </button>
                    <x-button title="Prediksi" type="submit" size="md" variant="primary" icon="save" />
                </div>
            </form>
        </div>
    </div>
@endsection
