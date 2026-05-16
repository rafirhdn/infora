<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Waka;

use App\Http\Controllers\Controller;
use App\Models\Rapor;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $query = Rapor::with([
            'siswa.kelas.jurusan',
            'semester'
        ]);

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $rapor = $query->get();

        return response()->json([
            'success' => true,
            'data' => $rapor
        ]);
    }

    public function show(Rapor $rapor)
    {
        return response()->json([
            'success' => true,
            'data' => $rapor->load([
                'siswa.kelas.jurusan',
                'semester'
            ])
        ]);
    }

    public function update(
        Request $request,
        Rapor $rapor
    ) {
        $validated = $request->validate([
            'status' =>
                'sometimes|required|in:lengkap,belum_lengkap',

            'berkas' =>
                'nullable|string|max:255'
        ]);

        $rapor->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rapor berhasil diupdate',
            'data' => $rapor->fresh()
        ]);
    }
}