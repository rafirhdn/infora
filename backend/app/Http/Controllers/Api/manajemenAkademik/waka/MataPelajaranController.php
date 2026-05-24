<?php

namespace App\Http\Controllers\Api\manajemenAkademik\waka;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with('jurusan');

        if ($request->filled('kategori')) {
            $query->where(
                'kategori',
                $request->kategori
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $mataPelajaran = $query
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $mataPelajaran
        ]);
    }

    /**
     * AMBIL DATA JURUSAN AKTIF
     */
    public function jurusan()
    {
        $jurusan = Jurusan::where(
            'status',
            'aktif'
        )
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jurusan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' =>
            'required|string|max:100',

            'kategori' =>
            'required|in:umum,kejuruan',

            'status' =>
            'required|in:aktif,nonaktif',

            'id_jurusan' =>
            'nullable|exists:jurusan,id_jurusan'
        ]);

        /**
         * VALIDASI KHUSUS
         */
        if (
            $validated['kategori'] === 'kejuruan'
            && empty($validated['id_jurusan'])
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan wajib dipilih untuk mapel kejuruan'
            ], 422);
        }

        /**
         * MAPEL UMUM = NULL
         */
        if ($validated['kategori'] === 'umum') {
            $validated['id_jurusan'] = null;
        }

        $mataPelajaran = MataPelajaran::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil ditambahkan',
            'data' => $mataPelajaran->load('jurusan')
        ]);
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        return response()->json([
            'success' => true,
            'data' => $mataPelajaran->load('jurusan')
        ]);
    }

    public function update(
        Request $request,
        MataPelajaran $mataPelajaran
    ) {
        $validated = $request->validate([
            'nama' =>
            'sometimes|required|string|max:100',

            'kategori' =>
            'sometimes|required|in:umum,kejuruan',

            'status' =>
            'sometimes|required|in:aktif,nonaktif',

            'id_jurusan' =>
            'nullable|exists:jurusan,id_jurusan'
        ]);

        /**
         * AMBIL KATEGORI FINAL
         */
        $kategori =
            $validated['kategori']
            ?? $mataPelajaran->kategori;

        /**
         * VALIDASI KEJURUAN
         */
        if (
            $kategori === 'kejuruan'
            && empty($validated['id_jurusan'])
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan wajib dipilih untuk mapel kejuruan'
            ], 422);
        }

        /**
         * UMUM = NULL
         */
        if ($kategori === 'umum') {
            $validated['id_jurusan'] = null;
        }

        $mataPelajaran->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diupdate',
            'data' => $mataPelajaran
                ->fresh()
                ->load('jurusan')
        ]);
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->status === 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran aktif tidak bisa dihapus'
            ], 422);
        }

        $mataPelajaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus'
        ]);
    }
}
