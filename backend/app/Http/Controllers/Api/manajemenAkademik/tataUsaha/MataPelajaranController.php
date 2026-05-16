<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with([
            'jurusan'
        ]);

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

        if ($request->filled('id_jurusan')) {
            $query->where(
                'id_jurusan',
                $request->id_jurusan
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

        if (
            $validated['kategori'] === 'umum'
        ) {
            $validated['id_jurusan'] = null;
        }

        $mataPelajaran = MataPelajaran::create(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Mata pelajaran berhasil ditambahkan',
            'data' =>
                $mataPelajaran->load('jurusan')
        ], 201);
    }

    public function show(
        MataPelajaran $mataPelajaran
    ) {
        return response()->json([
            'success' => true,
            'data' => $mataPelajaran->load([
                'jurusan',
                'kompetensi',
                'jadwal',
                'tugas'
            ])
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

        if (
            isset($validated['kategori']) &&
            $validated['kategori'] === 'umum'
        ) {
            $validated['id_jurusan'] = null;
        }

        $mataPelajaran->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Mata pelajaran berhasil diupdate',
            'data' =>
                $mataPelajaran
                    ->fresh()
                    ->load('jurusan')
        ]);
    }

    public function destroy(
        MataPelajaran $mataPelajaran
    ) {
        $mataPelajaran->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Mata pelajaran berhasil dihapus'
        ]);
    }
}