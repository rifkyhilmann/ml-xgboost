<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
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

        $data = $query
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('feature.hasil-prediksi.index', compact('data'));
    }
}
