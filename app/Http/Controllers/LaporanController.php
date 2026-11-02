<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function getLaporan(Request $request)
    {
        $query = HasilPrediksi::with('pegawai')
            ->latest('tanggal');

        // Filter tanggal mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );
        }

        // Filter tanggal selesai
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_selesai
            );
        }

        // Filter pegawai
        if ($request->filled('id_pegawai')) {
            $query->where(
                'id_pegawai',
                $request->id_pegawai
            );
        }

        return $query;
    }

    public function index(Request $request)
    {
        $laporan = $this->getLaporan($request)
            ->paginate(10)
            ->withQueryString();

        $pegawai = Pegawai::orderBy('nama')->get();

        return view('feature.laporan.index', compact(
            'laporan',
            'pegawai'
        ));
    }

    public function cetak(Request $request)
    {
        $laporan = $this->getLaporan($request)->get();

        return view('feature.laporan.cetak', compact(
            'laporan'
        ));
    }
}
