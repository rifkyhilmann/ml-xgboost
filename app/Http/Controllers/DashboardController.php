<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPegawai = Pegawai::count();
        $totalPrediksi = HasilPrediksi::count();

        return view('feature.dashboard.index', compact(
            'totalUsers',
            'totalPegawai',
            'totalPrediksi'
        ));
    }
}
