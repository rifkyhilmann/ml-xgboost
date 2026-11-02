<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPegawai = Pegawai::count();
        $totalPrediksi = HasilPrediksi::count();

        // Diagram 12 bulan terakhir
        $startDate = Carbon::now()
            ->subMonths(11)
            ->startOfMonth();

        $dataBulanan = HasilPrediksi::selectRaw("
                YEAR(tanggal) as tahun,
                MONTH(tanggal) as bulan,
                SUM(CASE WHEN LOWER(status) = 'layak' THEN 1 ELSE 0 END) as layak,
                SUM(CASE WHEN LOWER(status) = 'tidak layak' THEN 1 ELSE 0 END) as tidak_layak
            ")
            ->where('tanggal', '>=', $startDate)
            ->groupBy(
                DB::raw('YEAR(tanggal)'),
                DB::raw('MONTH(tanggal)')
            )
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get()
            ->keyBy(function ($item) {
                return $item->tahun . '-' . $item->bulan;
            });

        $labels = [];
        $dataLayak = [];
        $dataTidakLayak = [];

        for ($i = 0; $i < 12; $i++) {
            $tanggal = Carbon::now()
                ->subMonths(11 - $i);

            $key = $tanggal->year . '-' . $tanggal->month;

            $labels[] = $tanggal->translatedFormat('M Y');

            $dataLayak[] = (int) ($dataBulanan[$key]->layak ?? 0);

            $dataTidakLayak[] = (int) ($dataBulanan[$key]->tidak_layak ?? 0);
        }

        // 5 prediksi terakhir
        $prediksiTerakhir = HasilPrediksi::with('pegawai')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('feature.dashboard.index', compact(
            'totalUsers',
            'totalPegawai',
            'totalPrediksi',
            'labels',
            'dataLayak',
            'dataTidakLayak',
            'prediksiTerakhir'
        ));
    }
}
