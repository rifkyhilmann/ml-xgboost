<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\UsulanMutasi;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PrediksiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('feature.prediksi.index', compact('pegawai'));
    }

    public function create(Request $request)
    {
        
    }
}
