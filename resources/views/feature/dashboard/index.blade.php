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

        {{-- Diagram --}}
        {{-- Diagram Prediksi Bulanan --}}
        <div class="bg-white border border-zinc-200 rounded-xl p-5">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                <div>
                    <h3 class="text-base font-semibold text-zinc-800">
                        Statistik Hasil Prediksi
                    </h3>
                    <p class="text-sm text-zinc-500 mt-1">
                        Jumlah hasil prediksi berdasarkan bulan selama 12 bulan terakhir.
                    </p>
                </div>

                <span class="text-xs text-zinc-500 bg-zinc-100 px-3 py-1.5 rounded-lg">
                    12 Bulan Terakhir
                </span>
            </div>

            <div class="relative w-full" style="height: 320px;">
                <canvas id="prediksiChart"></canvas>
            </div>

        </div>

        {{-- 5 Prediksi Terakhir --}}
        <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">

            <div class="p-5 border-b border-zinc-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-zinc-800">
                        5 Prediksi Terakhir
                    </h3>
                    <p class="text-sm text-zinc-500 mt-1">
                        Riwayat prediksi terbaru yang telah dilakukan.
                    </p>
                </div>

                <a href="{{ route('laporan.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-zinc-50 text-zinc-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">No</th>
                            <th class="px-5 py-3 font-medium">Tanggal</th>
                            <th class="px-5 py-3 font-medium">Nama Pegawai</th>
                            <th class="px-5 py-3 font-medium">Probabilitas</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100">

                        @forelse ($prediksiTerakhir as $item)
                            <tr class="hover:bg-zinc-50 transition">

                                <td class="px-5 py-4 text-zinc-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 text-zinc-600 whitespace-nowrap">
                                    {{ $item->tanggal->format('d M Y, H:i') }}
                                </td>

                                <td class="px-5 py-4 font-medium text-zinc-800">
                                    {{ $item->pegawai->nama ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-zinc-700">
                                    {{ number_format((float) $item->probabilitas * 100, 2) }}%
                                </td>

                                <td class="px-5 py-4">
                                    @if (strtolower($item->status) === 'layak')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full
                                    text-xs font-medium bg-emerald-50 text-emerald-700">
                                            Layak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full
                                    text-xs font-medium bg-red-50 text-red-700">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i data-lucide="file-search" class="w-10 h-10 text-zinc-300"></i>
                                        <span class="text-sm font-medium text-zinc-600">
                                            Belum ada hasil prediksi
                                        </span>
                                        <span class="text-xs text-zinc-400">
                                            Data prediksi akan ditampilkan di sini.
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const canvas = document.getElementById('prediksiChart');

            if (!canvas) return;

            new Chart(canvas, {
                type: 'bar',

                data: {
                    labels: @json($labels),

                    datasets: [{
                            label: 'Layak',
                            data: @json($dataLayak),
                            backgroundColor: '#10b981',
                            borderRadius: 5,
                            barThickness: 18,
                        },
                        {
                            label: 'Tidak Layak',
                            data: @json($dataTidakLayak),
                            backgroundColor: '#ef4444',
                            borderRadius: 5,
                            barThickness: 18,
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },

                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },

                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' +
                                        context.parsed.y + ' prediksi';
                                }
                            }
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f4f4f5'
                            }
                        }
                    }
                }
            });

        });
    </script>
@endsection
