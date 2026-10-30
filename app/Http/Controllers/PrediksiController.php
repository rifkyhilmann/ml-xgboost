<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\UsulanMutasi;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // 1. Validasi input form
        $validated = $request->validate([
            'masa_kerja' => 'required|integer|min:0',
            'pegawai_id' => 'required|exists:pegawai,id',
            'hasil_kerja' => 'required|in:Di Bawah Ekspektasi,Sesuai Ekspektasi,Di Atas Ekspektasi',
            'perilaku_kerja' => 'required|in:Di Bawah Ekspektasi,Sesuai Ekspektasi,Di Atas Ekspektasi',
            'kelengkapan_berkas' => 'required|in:Lengkap,Tidak Lengkap',
            'sedang_hukuman_disiplin' => 'required|in:Ya,Tidak',
            'bebas_temuan_inspektorat' => 'required|in:Ya,Tidak',
            'sedang_tugas_belajar' => 'required|in:Ya,Tidak',
            'kesesuaian_formasi_abk' => 'required|in:Sesuai,Tidak Sesuai',
        ]);

        // 2. Ambil data pegawai
        $pegawai = Pegawai::findOrFail($validated['pegawai_id']);

        // 3. Hitung masa kerja berdasarkan tanggal mulai kerja
        $masaKerja = $validated['masa_kerja'] ?? 0;

        // 4. Bentuk data sesuai fitur model XGBoost
        $data = [
            'Masa_Kerja' => $masaKerja,

            'Hasil_Kerja_Di Bawah Ekspektasi' =>
            $validated['hasil_kerja'] === 'Di Bawah Ekspektasi' ? 1 : 0,

            'Hasil_Kerja_Sesuai Ekspektasi' =>
            $validated['hasil_kerja'] === 'Sesuai Ekspektasi' ? 1 : 0,

            'Perilaku_Kerja_Di Bawah Ekspektasi' =>
            $validated['perilaku_kerja'] === 'Di Bawah Ekspektasi' ? 1 : 0,

            'Perilaku_Kerja_Sesuai Ekspektasi' =>
            $validated['perilaku_kerja'] === 'Sesuai Ekspektasi' ? 1 : 0,

            'Kelengkapan_Berkas_Tidak Lengkap' =>
            $validated['kelengkapan_berkas'] === 'Tidak Lengkap' ? 1 : 0,

            'Sedang_Hukuman_Disiplin_Ya' =>
            $validated['sedang_hukuman_disiplin'] === 'Ya' ? 1 : 0,

            'Bebas_Temuan_Inspektorat_Ya' =>
            $validated['bebas_temuan_inspektorat'] === 'Ya' ? 1 : 0,

            'Sedang_Tugas_Belajar_Ya' =>
            $validated['sedang_tugas_belajar'] === 'Ya' ? 1 : 0,

            'Kesesuaian_Formasi_ABK_Tidak Sesuai' =>
            $validated['kesesuaian_formasi_abk'] === 'Tidak Sesuai' ? 1 : 0,
        ];

        try {
            // 5. Kirim data ke FastAPI
            $response = Http::timeout(30)
                ->acceptJson()
                ->post('http://127.0.0.1:8001/prediksi', [
                    'data' => $data,
                ]);

            // 6. Periksa respons FastAPI
            if (!$response->successful()) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal melakukan prediksi. API mengembalikan HTTP ' . $response->status());
            }

            $hasil = $response->json();

            if (($hasil['status'] ?? null) !== 'success') {
                return back()
                    ->withInput()
                    ->with('error', 'API tidak berhasil memproses prediksi.');
            }

            // 7. Ambil hasil prediksi
            $status = $hasil['hasil_prediksi'] ?? null;

            // Ambil probabilitas sesuai kelas hasil prediksi
            $probabilitas = $status === 'Layak'
                ? ($hasil['probabilitas']['layak'] ?? null)
                : ($hasil['probabilitas']['tidak_layak'] ?? null);

            // Validasi hasil API
            if (
                !in_array($status, ['Layak', 'Tidak Layak'], true) ||
                !is_numeric($probabilitas) ||
                $probabilitas < 0 ||
                $probabilitas > 1
            ) {
                return back()
                    ->withInput()
                    ->with('error', 'Format hasil prediksi dari API tidak valid.');
            }

            // 8. Simpan hasil prediksi
            DB::transaction(function () use (
                $validated,
                $status,
                $probabilitas
            ) {
                HasilPrediksi::create([
                    'id_pegawai' => $validated['pegawai_id'],
                    'tanggal' => now(),
                    'probabilitas' => $probabilitas,
                    'status' => $status,
                ]);
            });

            return redirect()
                ->route('prediksi')
                ->withInput($validated)
                ->with('success', 'Prediksi berhasil dilakukan dan hasilnya berhasil disimpan.')
                ->with('prediksi_result', [
                    'status' => $status,
                    'probabilitas' => round((float) $probabilitas * 100, 2),
                    'pegawai' => $pegawai->nama,
                    'data' => $data,
                ]);
        } catch (ConnectionException $e) {
            return back()
                ->withInput()
                ->with('error', 'Tidak dapat terhubung ke FastAPI. Pastikan server FastAPI sedang berjalan.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat melakukan prediksi: ' . $e->getMessage());
        }
    }
}
