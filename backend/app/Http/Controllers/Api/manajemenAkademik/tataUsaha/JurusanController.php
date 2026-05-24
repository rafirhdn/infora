<?php

namespace App\Http\Controllers\Api\manajemenAkademik\tataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * GET /jurusan
     * Ambil semua jurusan + jumlah kelas + jumlah siswa
     */
    public function index()
    {
        return Jurusan::withCount(['kelas', 'siswa'])
            ->orderBy('nama')
            ->get();
    }

    /**
     * POST /jurusan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:jurusan,nama',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $jurusan = Jurusan::create($validated);

        return response()->json([
            'message' => 'Jurusan berhasil ditambahkan',
            'data' => $jurusan
        ]);
    }

    /**
     * PATCH /jurusan/{jurusan}/aktifkan
     */
    public function aktifkan(Jurusan $jurusan)
    {
        $jurusan->update([
            'status' => 'aktif'
        ]);

        return response()->json([
            'message' => 'Jurusan berhasil diaktifkan'
        ]);
    }

    /**
     * PATCH /jurusan/{jurusan}/nonaktifkan
     */
    public function nonaktifkan(Jurusan $jurusan)
    {
        $jurusan->update([
            'status' => 'nonaktif'
        ]);

        return response()->json([
            'message' => 'Jurusan berhasil dinonaktifkan'
        ]);
    }

    /**
     * GET /jurusan/{jurusan}
     */
    public function show(Jurusan $jurusan)
    {
        return $jurusan->loadCount(['kelas', 'siswa']);
    }

    /**
     * PUT /jurusan/{jurusan}
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama' =>
            'sometimes|required|string|max:50|unique:jurusan,nama,' .
                $jurusan->id_jurusan . ',id_jurusan',

            'deskripsi' => 'nullable|string',

            'status' => 'sometimes|required|in:aktif,nonaktif'
        ]);

        $jurusan->update($validated);

        return response()->json([
            'message' => 'Jurusan berhasil diupdate',
            'data' => $jurusan->fresh()->loadCount(['kelas', 'siswa'])
        ]);
    }

    /**
     * DELETE /jurusan/{jurusan}
     */
    public function destroy(Jurusan $jurusan)
    {
        if ($jurusan->status === 'aktif') {
            return response()->json([
                'message' => 'Jurusan aktif tidak dapat dihapus'
            ], 400);
        }

        $jurusan->delete();

        return response()->json([
            'message' => 'Jurusan berhasil dihapus'
        ]);
    }
}
