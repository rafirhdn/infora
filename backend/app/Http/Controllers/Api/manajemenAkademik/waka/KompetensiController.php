<?php

namespace App\Http\Controllers\manajemenAkademik\Waka;

use App\Http\Controllers\Controller;
use App\Models\Kompetensi;
use Illuminate\Http\Request;

class KompetensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Kompetensi::with('mataPelajaran');

        if ($request->filled('id_mata_pelajaran')) {
            $query->where(
                'id_mata_pelajaran',
                $request->id_mata_pelajaran
            );
        }

        $kompetensi = $query
            ->orderBy('kode')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kompetensi
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mata_pelajaran' =>
                'required|exists:mata_pelajaran,id_mata_pelajaran',

            'kode' =>
                'required|string|max:20|unique:kompetensi,kode',

            'judul' =>
                'required|string|max:150',

            'deskripsi' =>
                'nullable|string',

            'bobot' =>
                'required|integer|between:1,5'
        ]);

        $kompetensi = Kompetensi::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil ditambahkan',
            'data' => $kompetensi->load('mataPelajaran')
        ]);
    }

    public function show(Kompetensi $kompetensi)
    {
        return response()->json([
            'success' => true,
            'data' => $kompetensi->load('mataPelajaran')
        ]);
    }

    public function update(
        Request $request,
        Kompetensi $kompetensi
    ) {
        $validated = $request->validate([
            'id_mata_pelajaran' =>
                'sometimes|required|exists:mata_pelajaran,id_mata_pelajaran',

            'kode' =>
                'sometimes|required|string|max:20|unique:kompetensi,kode,' .
                $kompetensi->id_kompetensi .
                ',id_kompetensi',

            'judul' =>
                'sometimes|required|string|max:150',

            'deskripsi' =>
                'nullable|string',

            'bobot' =>
                'sometimes|required|integer|between:1,5'
        ]);

        $kompetensi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil diupdate',
            'data' => $kompetensi->fresh()->load('mataPelajaran')
        ]);
    }

    public function destroy(Kompetensi $kompetensi)
    {
        $kompetensi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil dihapus'
        ]);
    }
}