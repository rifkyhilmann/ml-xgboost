@extends('layouts.layout')

@section('content')
<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Laporan Hasil Prediksi
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat hasil prediksi kelayakan pegawai.
            </p>
        </div>

        <a href="{{ route('laporan.cetak', request()->query()) }}"
            target="_blank"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5
            bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium
            rounded-lg transition">
            <i data-lucide="printer" class="w-4 h-4"></i>
            Cetak Laporan
        </a>
    </div>

    {{-- Filter --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <form action="{{ route('laporan.index') }}" method="GET">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Tanggal Mulai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                        name="tanggal_mulai"
                        value="{{ request('tanggal_mulai') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                        text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none">
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="date"
                        name="tanggal_selesai"
                        value="{{ request('tanggal_selesai') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                        text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none">
                </div>

                {{-- Pegawai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pegawai
                    </label>
                    <select name="id_pegawai"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                        text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none">

                        <option value="">Semua Pegawai</option>

                        @foreach ($pegawai as $item)
                            <option value="{{ $item->id }}"
                                @selected(request('id_pegawai') == $item->id)>
                                {{ $item->nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Tombol --}}
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2
                        bg-primary-700 hover:bg-primary-800 text-white text-sm
                        font-medium px-4 py-2.5 rounded-lg transition">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Filter
                    </button>

                    <a href="{{ route('laporan.index') }}"
                        class="inline-flex items-center justify-center gap-2
                        border border-gray-300 hover:bg-gray-50 text-gray-600
                        px-3 py-2.5 rounded-lg transition"
                        title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- Tabel Laporan --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        <div class="p-5 border-b border-gray-200">
            <h2 class="font-semibold text-gray-800">
                Data Hasil Prediksi
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Berikut merupakan riwayat hasil prediksi berdasarkan filter yang dipilih.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Nama Pegawai</th>
                        <th class="px-5 py-3 font-medium">Probabilitas</th>
                        <th class="px-5 py-3 font-medium">Status Prediksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($laporan as $item)
                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-3.5 text-gray-600">
                                {{ $laporan->firstItem() + $loop->index }}
                            </td>

                            <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">
                                {{ $item->tanggal->format('d-m-Y H:i') }}
                            </td>

                            <td class="px-5 py-3.5 font-medium text-gray-800">
                                {{ $item->pegawai->nama ?? '-' }}
                            </td>

                            <td class="px-5 py-3.5 text-gray-700">
                                {{ number_format((float) $item->probabilitas * 100, 2) }}%
                            </td>

                            <td class="px-5 py-3.5">
                                @if (strtolower($item->status) === 'layak')
                                    <span class="px-2.5 py-1 rounded-full text-xs
                                        font-medium bg-green-100 text-green-700">
                                        Layak
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs
                                        font-medium bg-red-100 text-red-700">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i data-lucide="file-search"
                                        class="w-10 h-10 text-gray-300"></i>
                                    <p class="font-medium text-gray-600">
                                        Data laporan tidak ditemukan
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Silakan ubah filter pencarian.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($laporan->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $laporan->links() }}
            </div>
        @endif

    </div>

</div>
@endsection