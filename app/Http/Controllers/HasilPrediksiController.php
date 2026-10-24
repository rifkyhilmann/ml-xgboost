<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use Illuminate\Http\Request;

class HasilPrediksiController extends Controller
{
    public function index(Request $request)
    {
        $query = HasilPrediksi::with([
            'usulanMutasi.pegawai',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('usulanMutasi', function ($q) use ($search) {
                $q->where('jenis_mutasi', 'like', "%{$search}%")
                    ->orWhere('instansi_tujuan', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($pegawai) use ($search) {
                        $pegawai->where('nip', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%")
                            ->orWhere('jabatan', 'like', "%{$search}%")
                            ->orWhere('instansi_asal', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString()
            ->through(function ($hasil) {
                $usulan = $hasil->usulanMutasi;
                $pegawai = $usulan?->pegawai;

                return (object) [
                    'id' => $hasil->id,
                    'nip' => $pegawai?->nip ?? '-',
                    'nama' => $pegawai?->nama ?? '-',
                    'golongan' => $pegawai?->golongan ?? '-',
                    'jabatan' => $pegawai?->jabatan ?? '-',
                    'jenis_mutasi' => $usulan?->jenis_mutasi ?? '-',
                    'instansi_asal' => $pegawai?->instansi_asal ?? '-',
                    'instansi_tujuan' => $usulan?->instansi_tujuan ?? '-',
                    'tanggal' => $hasil->tanggal?->format('d-m-Y H:i'),
                    'probabilitas' => number_format(
                        (float) $hasil->probabilitas * 100,
                        2,
                        ',',
                        '.'
                    ) . '%',
                    'status' => $hasil->status,
                ];
            });

        return view('feature.hasil-prediksi.index', compact('data'));
    }
}
