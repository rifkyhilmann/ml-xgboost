<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class HasilPrediksiController extends Controller
{

    public function index(Request $request)
    {
        $query = HasilPrediksi::with('pegawai');

        // Filter pencarian berdasarkan status
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('status', 'like', "%{$search}%");
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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

        $pegawai = Pegawai::orderBy('nama')->get();

        $data = $query
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('feature.hasil-prediksi.index', compact('data', 'pegawai'));
    }
}
