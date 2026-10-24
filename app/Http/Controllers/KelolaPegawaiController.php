<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelolaPegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('golongan', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('instansi_asal', 'like', '%' . $search . '%');
            });
        }

        $data = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('feature.kelola-pegawai.index', compact('data'));
    }

    /**
     * Menampilkan form tambah pegawai.
     */
    public function create()
    {
        return view('feature.kelola-pegawai.create');
    }

    /**
     * Menyimpan data pegawai baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:30',
                'unique:pegawai,nip',
            ],
            'nama' => [
                'required',
                'string',
                'max:150',
            ],
            'golongan' => [
                'nullable',
                'string',
                'max:20',
            ],
            'jabatan' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pendidikan_terakhir' => [
                'nullable',
                'string',
                'max:100',
            ],
            'tanggal_lahir' => [
                'nullable',
                'date',
                'before:today',
            ],
            'tanggal_mulai_kerja' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'instansi_asal' => [
                'nullable',
                'string',
                'max:200',
            ],
        ]);

        Pegawai::create($validated);

        return redirect()
            ->route('kelola-pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pegawai.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('feature.kelola-pegawai.update', compact('pegawai'));
    }

    /**
     * Memperbarui data pegawai.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:30',
                Rule::unique('pegawai', 'nip')->ignore($pegawai->id),
            ],
            'nama' => [
                'required',
                'string',
                'max:150',
            ],
            'golongan' => [
                'nullable',
                'string',
                'max:20',
            ],
            'jabatan' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pendidikan_terakhir' => [
                'nullable',
                'string',
                'max:100',
            ],
            'tanggal_lahir' => [
                'nullable',
                'date',
                'before:today',
            ],
            'tanggal_mulai_kerja' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'instansi_asal' => [
                'nullable',
                'string',
                'max:200',
            ],
        ]);

        $pegawai->update($validated);

        return redirect()
            ->route('kelola-pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Cegah penghapusan jika pegawai sudah memiliki usulan mutasi.
        if ($pegawai->usulanMutasi()->exists()) {
            return redirect()
                ->route('kelola-pegawai.index')
                ->with(
                    'error',
                    'Data pegawai tidak dapat dihapus karena sudah memiliki riwayat usulan mutasi.'
                );
        }

        $pegawai->delete();

        return redirect()
            ->route('kelola-pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
