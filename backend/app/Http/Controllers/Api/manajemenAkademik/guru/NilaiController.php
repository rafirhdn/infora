<?php

namespace App\Http\Controllers\manajemenAkademik\Guru;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with([
            'siswa',
            'mataPelajaran',
            'kompetensi',
            'semester'
        ]);

        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        if ($request->filled('id_semester')) {
            $query->where('id_semester', $request->id_semester);
        }

        $nilai = $query->get();

        return response()->json([
            'success' => true,
            'data' => $nilai
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'id_kompetensi' => 'required|exists:kompetensi,id_kompetensi',
            'id_semester' => 'required|exists:semester,id_semester',

            'nilai_sikap' => 'nullable|numeric|min:0|max:100',
            'nilai_pengetahuan' => 'nullable|numeric|min:0|max:100',
            'nilai_keterampilan' => 'nullable|numeric|min:0|max:100'
        ]);

        $nilaiAkhir = collect([
            $validated['nilai_sikap'] ?? 0,
            $validated['nilai_pengetahuan'] ?? 0,
            $validated['nilai_keterampilan'] ?? 0
        ])->avg();

        $predikat = match (true) {
            $nilaiAkhir >= 90 => 'A',
            $nilaiAkhir >= 80 => 'B',
            $nilaiAkhir >= 70 => 'C',
            default => 'D'
        };

        $nilai = Nilai::create([
            ...$validated,
            'nilai_akhir' => $nilaiAkhir,
            'predikat' => $predikat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil ditambahkan',
            'data' => $nilai
        ]);
    }

    public function show(Nilai $nilai)
    {
        return response()->json([
            'success' => true,
            'data' => $nilai->load([
                'siswa',
                'mataPelajaran',
                'kompetensi',
                'semester'
            ])
        ]);
    }

    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_sikap' => 'nullable|numeric|min:0|max:100',
            'nilai_pengetahuan' => 'nullable|numeric|min:0|max:100',
            'nilai_keterampilan' => 'nullable|numeric|min:0|max:100'
        ]);

        $nilaiAkhir = collect([
            $validated['nilai_sikap'] ?? $nilai->nilai_sikap ?? 0,
            $validated['nilai_pengetahuan'] ?? $nilai->nilai_pengetahuan ?? 0,
            $validated['nilai_keterampilan'] ?? $nilai->nilai_keterampilan ?? 0
        ])->avg();

        $predikat = match (true) {
            $nilaiAkhir >= 90 => 'A',
            $nilaiAkhir >= 80 => 'B',
            $nilaiAkhir >= 70 => 'C',
            default => 'D'
        };

        $nilai->update([
            ...$validated,
            'nilai_akhir' => $nilaiAkhir,
            'predikat' => $predikat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diupdate',
            'data' => $nilai->fresh()
        ]);
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil dihapus'
        ]);
    }
}