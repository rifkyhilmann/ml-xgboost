<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Hasil Prediksi</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            color: #111827;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto my-8 bg-white p-8 shadow-sm print:shadow-none print:my-0">

        {{-- Tombol Cetak --}}
        <div class="flex justify-end gap-2 mb-8 no-print">

            <button onclick="window.print()"
                class="bg-primary-700 hover:bg-primary-800 text-white
                px-4 py-2 rounded-lg text-sm">
                Cetak Laporan
            </button>

            <button onclick="window.close()"
                class="border border-gray-300 hover:bg-gray-100
                px-4 py-2 rounded-lg text-sm">
                Tutup
            </button>

        </div>

        {{-- Kop Laporan --}}
        <div class="text-center border-b-2 border-black pb-5 mb-6">

            <h1 class="text-xl font-bold uppercase">
                Laporan Hasil Prediksi Kelayakan Pegawai
            </h1>

            <p class="text-sm mt-2">
                Sistem Informasi Prediksi Kelayakan Pegawai
            </p>

        </div>

        {{-- Informasi Filter --}}
        <div class="mb-6 text-sm">

            <table class="w-full">
                <tr>
                    <td class="py-1 w-40">Tanggal Mulai</td>
                    <td class="py-1 w-5">:</td>
                    <td>
                        {{ request('tanggal_mulai')
                            ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d-m-Y')
                            : 'Semua Tanggal' }}
                    </td>
                </tr>

                <tr>
                    <td class="py-1">Tanggal Selesai</td>
                    <td class="py-1">:</td>
                    <td>
                        {{ request('tanggal_selesai')
                            ? \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d-m-Y')
                            : 'Semua Tanggal' }}
                    </td>
                </tr>

                <tr>
                    <td class="py-1">Pegawai</td>
                    <td class="py-1">:</td>
                    <td>
                        {{ request('id_pegawai') ? $laporan->first()?->pegawai?->nama ?? 'Tidak ada data' : 'Semua Pegawai' }}
                    </td>
                </tr>

                <tr>
                    <td class="py-1">Jumlah Data</td>
                    <td class="py-1">:</td>
                    <td>{{ $laporan->count() }} Data Prediksi</td>
                </tr>
            </table>

        </div>

        {{-- Tabel --}}
        <table class="w-full border-collapse text-sm">

            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-black px-3 py-2 w-12">No</th>
                    <th class="border border-black px-3 py-2">Tanggal</th>
                    <th class="border border-black px-3 py-2">Nama Pegawai</th>
                    <th class="border border-black px-3 py-2">Probabilitas</th>
                    <th class="border border-black px-3 py-2">Status Prediksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($laporan as $index => $item)
                    <tr>
                        <td class="border border-black px-3 py-2 text-center">
                            {{ $index + 1 }}
                        </td>

                        <td class="border border-black px-3 py-2 text-center whitespace-nowrap">
                            {{ $item->tanggal->format('d-m-Y H:i') }}
                        </td>

                        <td class="border border-black px-3 py-2">
                            {{ $item->pegawai->nama ?? '-' }}
                        </td>

                        <td class="border border-black px-3 py-2 text-center">
                            {{ number_format((float) $item->probabilitas * 100, 2) }}%
                        </td>

                        <td class="border border-black px-3 py-2 text-center">
                            {{ $item->status }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-black px-3 py-6 text-center">
                            Tidak ada data laporan.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        {{-- Tanda Tangan --}}
        <div class="flex justify-end mt-12">
            <div class="text-center text-sm w-64">

                <p class="mt-2">
                    Mengetahui,
                </p>

                <div class="h-20"></div>

                <p class="font-semibold underline">
                    ....................................
                </p>

                <p>
                    Penanggung Jawab
                </p>

            </div>
        </div>

    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>

</body>

</html>
