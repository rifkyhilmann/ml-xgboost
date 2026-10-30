@extends('layouts.layout')

@section('content')
    <div class="flex flex-col gap-5">
        {{-- Breadcrumb --}}
        <x-breadcrumbs :items="[['label' => 'Prediksi', 'url' => route('prediksi')], ['label' => 'Form Prediksi']]" />

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Form Prediksi Berdasarkan Kolom API</h2>
            <p class="text-sm text-gray-600 mb-6">Isi data usulan mutasi berdasarkan fitur model untuk melakukan prediksi</p>

            <form action="{{ route('prediksi.prosesForm', $usulan->id) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="hidden" name="id_pegawai" value="{{ $usulan->id_pegawai }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" value="{{ $usulan->pegawai->nip ?? '-' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pegawai</label>
                        <input type="text" value="{{ $usulan->pegawai->nama ?? '-' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Mutasi</label>
                        <input type="text" name="jenis_mutasi" value="{{ old('jenis_mutasi', $usulan->jenis_mutasi) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi Tujuan</label>
                        <input type="text" name="instansi_tujuan" value="{{ old('instansi_tujuan', $usulan->instansi_tujuan) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $usulan->tanggal_pengajuan) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Kerja (Tahun)</label>
                        <input type="number" step="0.01" name="masa_kerja" value="{{ old('masa_kerja', $usulan->masa_kerja) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai SKP</label>
                        <input type="number" step="0.01" name="nilai_skp" value="{{ old('nilai_skp', $usulan->nilai_skp) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Kerja</label>
                        <select name="hasil_kerja" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Sesuai Ekspektasi" {{ old('hasil_kerja', $usulan->hasil_kerja) == 'Sesuai Ekspektasi' ? 'selected' : '' }}>Sesuai Ekspektasi</option>
                            <option value="Di Bawah Ekspektasi" {{ old('hasil_kerja', $usulan->hasil_kerja) == 'Di Bawah Ekspektasi' ? 'selected' : '' }}>Di Bawah Ekspektasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Perilaku Kerja</label>
                        <select name="perilaku_kerja" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Sesuai Ekspektasi" {{ old('perilaku_kerja', $usulan->perilaku_kerja) == 'Sesuai Ekspektasi' ? 'selected' : '' }}>Sesuai Ekspektasi</option>
                            <option value="Di Bawah Ekspektasi" {{ old('perilaku_kerja', $usulan->perilaku_kerja) == 'Di Bawah Ekspektasi' ? 'selected' : '' }}>Di Bawah Ekspektasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelengkapan Berkas</label>
                        <select name="kelengkapan_berkas" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Lengkap" {{ old('kelengkapan_berkas', $usulan->kelengkapan_berkas) == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                            <option value="Tidak Lengkap" {{ old('kelengkapan_berkas', $usulan->kelengkapan_berkas) == 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sedang Hukuman Disiplin</label>
                        <select name="hukuman_disiplin" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Tidak" {{ old('hukuman_disiplin', $usulan->hukuman_disiplin) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            <option value="Ya" {{ old('hukuman_disiplin', $usulan->hukuman_disiplin) == 'Ya' ? 'selected' : '' }}>Ya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bebas Temuan Inspektorat</label>
                        <select name="bebas_temuan_inspektorat" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('bebas_temuan_inspektorat', $usulan->bebas_temuan_inspektorat) == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('bebas_temuan_inspektorat', $usulan->bebas_temuan_inspektorat) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sedang Tugas Belajar</label>
                        <select name="tugas_belajar" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Tidak" {{ old('tugas_belajar', $usulan->tugas_belajar) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            <option value="Ya" {{ old('tugas_belajar', $usulan->tugas_belajar) == 'Ya' ? 'selected' : '' }}>Ya</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kesesuaian Formasi / ABK</label>
                        <select name="kesesuaian_formasi" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Sesuai" {{ old('kesesuaian_formasi', $usulan->kesesuaian_formasi) == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                            <option value="Tidak Sesuai" {{ old('kesesuaian_formasi', $usulan->kesesuaian_formasi) == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Simpan & Prediksi
                    </button>
                    <a href="{{ route('prediksi') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
