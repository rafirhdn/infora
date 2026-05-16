<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return Kelas::with([
            'jurusan',
            'siswa'
        ])
        ->withCount('siswa')
        ->orderBy('tingkat')
        ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:30',
            'tingkat' => 'required|integer|in:10,11,12',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan'
        ]);

        return Kelas::create($validated);
    }

    public function show(Kelas $kelas)
    {
        return $kelas->load([
            'jurusan',
            'siswa',
            'jadwal'
        ]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:30',
            'tingkat' => 'sometimes|required|integer|in:10,11,12',
            'id_jurusan' => 'sometimes|required|exists:jurusan,id_jurusan'
        ]);

        $kelas->update($validated);

        return $kelas->fresh();
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return response()->json([
            'message' => 'Kelas dihapus'
        ]);
    }
}