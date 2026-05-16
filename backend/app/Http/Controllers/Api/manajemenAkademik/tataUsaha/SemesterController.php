<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        return Semester::orderBy('tahun_ajaran_awal')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:20',
            'tahun_ajaran_awal' => 'required|integer|min:2000|max:2100',
            'tahun_ajaran_akhir' => 'required|integer|min:2000|max:2100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        return Semester::create($validated);
    }

    public function show(Semester $semester)
    {
        return $semester;
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:20',
            'tahun_ajaran_awal' => 'sometimes|required|integer|min:2000|max:2100',
            'tahun_ajaran_akhir' => 'sometimes|required|integer|min:2000|max:2100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'sometimes|required|in:aktif,nonaktif'
        ]);

        if (
            isset($validated['status']) &&
            $validated['status'] === 'aktif'
        ) {
            Semester::where('status', 'aktif')
                ->update([
                    'status' => 'nonaktif'
                ]);
        }

        $semester->update($validated);

        return $semester->fresh();
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return response()->json([
            'message' => 'Semester dihapus'
        ]);
    }
}