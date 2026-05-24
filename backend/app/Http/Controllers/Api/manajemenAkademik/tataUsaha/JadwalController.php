<?php

namespace App\Http\Controllers\Api\manajemenAkademik\tataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with([
            'kelas.jurusan',
            'guru',
            'mataPelajaran',
            'semester'
        ]);

        $query->when(
            $request->filled('id_kelas'),
            fn($q) =>
            $q->where('id_kelas', $request->id_kelas)
        );

        $query->when(
            $request->filled('id_guru'),
            fn($q) =>
            $q->where('id_guru', $request->id_guru)
        );

        $query->when(
            $request->filled('id_mata_pelajaran'),
            fn($q) =>
            $q->where('id_mata_pelajaran', $request->id_mata_pelajaran)
        );

        $query->when(
            $request->filled('id_semester'),
            fn($q) =>
            $q->where('id_semester', $request->id_semester)
        );

        $query->when(
            $request->filled('hari'),
            fn($q) =>
            $q->where('hari', $request->hari)
        );

        $jadwal = $query
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat')")
            ->orderBy('jam_mulai')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }

    private function validationRules($isUpdate = false)
    {
        $req = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'hari' => $req . '|in:senin,selasa,rabu,kamis,jumat',
            'jam_mulai' => $req . '|date_format:H:i',
            'jam_selesai' => $req . '|date_format:H:i|after:jam_mulai',
            'ruang' => 'nullable|string|max:30',

            'id_kelas' => $req . '|exists:kelas,id_kelas',
            'id_guru' => $req . '|exists:guru,id_guru',
            'id_mata_pelajaran' => $req . '|exists:mata_pelajaran,id_mata_pelajaran',
            'id_semester' => $req . '|exists:semester,id_semester',
        ];
    }

    /*
    |-----------------------------------------
    | BENTROK UMUM (kelas / mapel / semester)
    |-----------------------------------------
    */
    private function checkBentrok(array $data, $excludeId = null)
    {
        return Jadwal::where('hari', $data['hari'])
            ->where('id_semester', $data['id_semester'])
            ->where(function ($q) use ($data) {
                $q->where('jam_mulai', '<', $data['jam_selesai'])
                    ->where('jam_selesai', '>', $data['jam_mulai']);
            })
            ->when(
                $excludeId,
                fn($q) =>
                $q->where('id_jadwal', '!=', $excludeId)
            );
    }

    /*
    |-----------------------------------------
    | BENTROK KHUSUS GURU (IMPORTANT RULE)
    |-----------------------------------------
    */
    private function checkBentrokGuru(array $data, $excludeId = null)
    {
        return Jadwal::where('id_guru', $data['id_guru'])
            ->where('hari', $data['hari'])
            ->where(function ($q) use ($data) {
                $q->where('jam_mulai', '<', $data['jam_selesai'])
                    ->where('jam_selesai', '>', $data['jam_mulai']);
            })
            ->when(
                $excludeId,
                fn($q) =>
                $q->where('id_jadwal', '!=', $excludeId)
            );
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // CEK BENTROK KELAS
        if ((clone $this->checkBentrok($validated))
            ->where('id_kelas', $validated['id_kelas'])
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal kelas bentrok'
            ], 422);
        }

        // CEK BENTROK GURU (RULE UTAMA)
        if ($this->checkBentrokGuru($validated)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Guru sudah memiliki jadwal di waktu tersebut'
            ], 422);
        }

        $jadwal = Jadwal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $jadwal->load([
                'kelas.jurusan',
                'guru',
                'mataPelajaran',
                'semester'
            ])
        ], 201);
    }

    public function show(Jadwal $jadwal)
    {
        return response()->json([
            'success' => true,
            'data' => $jadwal->load([
                'kelas.jurusan',
                'guru',
                'mataPelajaran',
                'semester'
            ])
        ]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate($this->validationRules(true));

        $data = array_merge($jadwal->toArray(), $validated);

        // CEK BENTROK KELAS
        if ((clone $this->checkBentrok($data, $jadwal->id_jadwal))
            ->where('id_kelas', $data['id_kelas'])
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal kelas bentrok'
            ], 422);
        }

        // CEK BENTROK GURU
        if ($this->checkBentrokGuru($data, $jadwal->id_jadwal)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Guru sudah memiliki jadwal di waktu tersebut'
            ], 422);
        }

        $jadwal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diupdate',
            'data' => $jadwal->fresh()->load([
                'kelas.jurusan',
                'guru',
                'mataPelajaran',
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
