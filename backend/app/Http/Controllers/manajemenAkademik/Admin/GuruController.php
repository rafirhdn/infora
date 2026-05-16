<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        return Guru::with([
            'akun',
            'jurusan'
        ])
        ->orderBy('nama')
        ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:20|unique:guru,nik',
            'email' => 'required|email|unique:akun,email',
            'password' => 'required|string|min:8',
            'nomor' => 'nullable|string|max:15',
            'id_jurusan' => 'nullable|exists:jurusan,id_jurusan'
        ]);

        $akun = Akun::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru'
        ]);

        $guru = Guru::create([
            'id_akun' => $akun->id_akun,
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'nomor' => $validated['nomor'] ?? null,
            'id_jurusan' => $validated['id_jurusan'] ?? null
        ]);

        return $guru->load([
            'akun',
            'jurusan'
        ]);
    }

    public function show(Guru $guru)
    {
        return $guru->load([
            'akun',
            'jurusan'
        ]);
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:100',

            'nik' => 'sometimes|required|string|max:20|unique:guru,nik,' .
                $guru->id_guru .
                ',id_guru',

            'email' => 'sometimes|required|email|unique:akun,email,' .
                $guru->id_akun .
                ',id_akun',

            'nomor' => 'nullable|string|max:15',

            'id_jurusan' => 'nullable|exists:jurusan,id_jurusan'
        ]);

        $guru->update([
            'nama' => $validated['nama'] ?? $guru->nama,
            'nik' => $validated['nik'] ?? $guru->nik,
            'nomor' => $validated['nomor'] ?? $guru->nomor,
            'id_jurusan' => $validated['id_jurusan'] ?? $guru->id_jurusan
        ]);

        if ($guru->akun) {
            $guru->akun->update([
                'nama' => $validated['nama'] ?? $guru->akun->nama,
                'email' => $validated['email'] ?? $guru->akun->email
            ]);
        }

        return $guru->load([
            'akun',
            'jurusan'
        ]);
    }

    public function destroy(Guru $guru)
    {
        if ($guru->akun) {
            $guru->akun->delete();
        }

        $guru->delete();

        return response()->json([
            'message' => 'Guru dihapus'
        ]);
    }
}