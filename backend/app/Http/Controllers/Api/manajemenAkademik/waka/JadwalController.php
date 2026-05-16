<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Waka;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with([
            'kelas.jurusan',
            'mataPelajaran',
            'guru',
            'semester'
        ]);

        if ($request->filled('id_kelas')) {
            $query->where(
                'id_kelas',
                $request->id_kelas
            );
        }

        if ($request->filled('id_guru')) {
            $query->where(
                'id_guru',
                $request->id_guru
            );
        }

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
            );
        }

        if ($request->filled('hari')) {
            $query->where(
                'hari',
                $request->hari
            );
        }

        $jadwal = $query
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' =>
                'required|in:senin,selasa,rabu,kamis,jumat',

            'jam_mulai' =>
                'required',

            'jam_selesai' =>
                'required|after:jam_mulai',

            'ruang' =>
                'nullable|string|max:30',

            'id_kelas' =>
                'required|exists:kelas,id_kelas',

            'id_mata_pelajaran' =>
                'required|exists:mata_pelajaran,id_mata_pelajaran',

            'id_guru' =>
                'required|exists:guru,id_guru',

            'id_semester' =>
                'required|exists:semester,id_semester'
        ]);

        $jadwal = Jadwal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $jadwal->load([
                'kelas',
                'mataPelajaran',
                'guru',
                'semester'
            ])
        ]);
    }

    public function show(Jadwal $jadwal)
    {
        return response()->json([
            'success' => true,
            'data' => $jadwal->load([
                'kelas.jurusan',
                'mataPelajaran',
                'guru',
                'semester'
            ])
        ]);
    }

    public function update(
        Request $request,
        Jadwal $jadwal
    ) {
        $validated = $request->validate([
            'hari' =>
                'sometimes|required|in:senin,selasa,rabu,kamis,jumat',

            'jam_mulai' =>
                'sometimes|required',

            'jam_selesai' =>
                'sometimes|required',

            'ruang' =>
                'nullable|string|max:30',

            'id_kelas' =>
                'sometimes|required|exists:kelas,id_kelas',

            'id_mata_pelajaran' =>
                'sometimes|required|exists:mata_pelajaran,id_mata_pelajaran',

            'id_guru' =>
                'sometimes|required|exists:guru,id_guru',

            'id_semester' =>
                'sometimes|required|exists:semester,id_semester'
        ]);

        $jadwal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diupdate',
            'data' => $jadwal->fresh()->load([
                'kelas',
                'mataPelajaran',
                'guru',
                'semester'
            ])
        ]);
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}