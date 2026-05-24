<?php

namespace App\Http\Controllers\Api\manajemenAkademik\tataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return Guru::with([
            'akun',
            'jurusan',
            'jadwal.mataPelajaran',
            'jadwal.kelas',
            'jadwal.semester'
        ])
            ->orderBy('nama')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama' =>
            'required|string|max:100|unique:guru,nama',

            'nik' =>
            'required|string|max:20|unique:guru,nik',

            'email' =>
            'required|email|unique:akun,email',

            'password' =>
            'required|string|min:8',

            'nomor' =>
            'nullable|string|max:15',

            'id_jurusan' =>
            'nullable|exists:jurusan,id_jurusan',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE AKUN
        |--------------------------------------------------------------------------
        */

        $akun = Akun::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kata_sandi' => Hash::make($validated['password']),
            'peran' => 'guru_produktif',
            'nomor' => $validated['nomor'] ?? null
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE GURU
        |--------------------------------------------------------------------------
        */

        $guru = Guru::create([
            'id_akun' => $akun->id_akun,
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'nomor' => $validated['nomor'] ?? null,
            'id_jurusan' => $validated['id_jurusan'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil ditambahkan',

            'data' => $guru->load([
                'akun',
                'jurusan',
                'jadwal.mataPelajaran',
                'jadwal.kelas',
                'jadwal.semester'
            ])
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Guru $guru)
    {
        return response()->json([
            'success' => true,

            'data' => $guru->load([
                'akun',
                'jurusan',
                'jadwal.mataPelajaran',
                'jadwal.kelas',
                'jadwal.semester'
            ])
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Guru $guru
    ) {

        $validated = $request->validate([

            'nama' =>
            'sometimes|required|string|max:100|unique:guru,nama,' .
                $guru->id_guru .
                ',id_guru',

            'nik' =>
            'sometimes|required|string|max:20|unique:guru,nik,' .
                $guru->id_guru .
                ',id_guru',

            'email' =>
            'sometimes|required|email|unique:akun,email,' .
                $guru->id_akun .
                ',id_akun',

            'nomor' =>
            'nullable|string|max:15',

            'id_jurusan' =>
            'nullable|exists:jurusan,id_jurusan',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE GURU
        |--------------------------------------------------------------------------
        */

        $guru->update([

            'nama' =>
            $validated['nama'] ?? $guru->nama,

            'nik' =>
            $validated['nik'] ?? $guru->nik,

            'nomor' =>
            $validated['nomor'] ?? $guru->nomor,

            'id_jurusan' =>
            array_key_exists(
                'id_jurusan',
                $validated
            )
                ? $validated['id_jurusan']
                : $guru->id_jurusan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE AKUN
        |--------------------------------------------------------------------------
        */

        if ($guru->akun) {

            $guru->akun->update([

                'nama' =>
                $validated['nama']
                    ?? $guru->akun->nama,

                'email' =>
                $validated['email']
                    ?? $guru->akun->email
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil diupdate',

            'data' => $guru
                ->fresh()
                ->load([
                    'akun',
                    'jurusan',
                    'jadwal.mataPelajaran',
                    'jadwal.kelas',
                    'jadwal.semester'
                ])
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Guru $guru)
    {
        /*
        |--------------------------------------------------------------------------
        | DELETE AKUN
        |--------------------------------------------------------------------------
        */

        if ($guru->akun) {
            $guru->akun->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE GURU
        |--------------------------------------------------------------------------
        */

        $guru->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil dihapus'
        ]);
    }
}
