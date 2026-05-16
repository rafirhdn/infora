<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        return Siswa::with([
            'akun',
            'kelas.jurusan'
        ])
        ->orderBy('nis')
        ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:akun,email',
            'password' => 'required|string|min:8',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'nomor' => 'nullable|string|max:15',
            'id_kelas' => 'required|exists:kelas,id_kelas'
        ]);

        $akun = Akun::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa'
        ]);

        $siswa = Siswa::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'nomor' => $validated['nomor'] ?? null,
            'id_kelas' => $validated['id_kelas'],
            'id_akun' => $akun->id_akun
        ]);

        return $siswa->load([
            'akun',
            'kelas.jurusan'
        ]);
    }

    public function show(Siswa $siswa)
    {
        return $siswa->load([
            'akun',
            'kelas.jurusan'
        ]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:100',

            'nis' => 'sometimes|required|string|max:20|unique:siswa,nis,' .
                $siswa->id_siswa .
                ',id_siswa',

            'nomor' => 'nullable|string|max:15',

            'id_kelas' => 'sometimes|required|exists:kelas,id_kelas'
        ]);

        $siswa->update([
            'nama' => $validated['nama'] ?? $siswa->nama,
            'nis' => $validated['nis'] ?? $siswa->nis,
            'nomor' => $validated['nomor'] ?? $siswa->nomor,
            'id_kelas' => $validated['id_kelas'] ?? $siswa->id_kelas
        ]);

        if ($siswa->akun) {
            $siswa->akun->update([
                'nama' => $validated['nama'] ?? $siswa->akun->nama
            ]);
        }

        return $siswa->load([
            'akun',
            'kelas.jurusan'
        ]);
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->akun) {
            $siswa->akun->delete();
        }

        $siswa->delete();

        return response()->json([
            'message' => 'Siswa dihapus'
        ]);
    }
}