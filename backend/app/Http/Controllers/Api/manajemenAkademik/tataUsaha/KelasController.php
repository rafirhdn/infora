<?php

namespace App\Http\Controllers\Api\manajemenAkademik\tataUsaha;

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
            ->withCount([
                'siswa',
                'jadwal',
                'anggotaKelas'
            ])
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

        $exists = Kelas::where('nama', $validated['nama'])
            ->where('tingkat', $validated['tingkat'])
            ->where('id_jurusan', $validated['id_jurusan'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Kelas sudah ada'
            ], 400);
        }

        $kelas = Kelas::create($validated);

        return response()->json([
            'message' => 'Kelas berhasil dibuat',
            'data' => $kelas
        ], 201);
    }

    public function show(Kelas $kelas)
    {
        return $kelas->load([
            'jurusan',
            'siswa',
            'jadwal',
            'anggotaKelas'
        ]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:30',
            'tingkat' => 'sometimes|required|integer|in:10,11,12',
            'id_jurusan' => 'sometimes|required|exists:jurusan,id_jurusan'
        ]);

        $nama = $validated['nama'] ?? $kelas->nama;
        $tingkat = $validated['tingkat'] ?? $kelas->tingkat;
        $idJurusan = $validated['id_jurusan'] ?? $kelas->id_jurusan;

        $exists = Kelas::where('nama', $nama)
            ->where('tingkat', $tingkat)
            ->where('id_jurusan', $idJurusan)
            ->where('id_kelas', '!=', $kelas->id_kelas)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Kelas sudah ada'
            ], 400);
        }

        $kelas->update($validated);

        return response()->json([
            'message' => 'Kelas berhasil diupdate',
            'data' => $kelas->fresh()
        ]);
    }

    /**
     * @param int $id
     */
    public function destroy($id)
    {
        // 🔥 FIX UTAMA: jangan pakai Model Binding (biar gak NULL error)
        $kelas = Kelas::where('id_kelas', $id)->first();

        if (!$kelas) {
            return response()->json([
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $kelas->loadCount([
            'siswa',
            'jadwal',
            'anggotaKelas'
        ]);

        // RULE 1
        if ($kelas->siswa_count > 0) {
            return response()->json([
                'message' => 'Kelas tidak bisa dihapus karena masih memiliki siswa'
            ], 400);
        }

        // RULE 2
        if ($kelas->jadwal_count > 0) {
            return response()->json([
                'message' => 'Kelas tidak bisa dihapus karena masih memiliki jadwal'
            ], 400);
        }

        // RULE 3
        if ($kelas->anggota_kelas_count > 0) {
            return response()->json([
                'message' => 'Kelas tidak bisa dihapus karena masih memiliki anggota kelas'
            ], 400);
        }

        $kelas->delete();

        return response()->json([
            'message' => 'Kelas berhasil dihapus'
        ]);
    }
}
