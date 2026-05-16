<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTua = OrangTua::with([
            'akun',
            'siswa'
        ])
        ->get();

        return response()->json([
            'success' => true,
            'data' => $orangTua
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' =>
                'required|string|max:100',

            'email' =>
                'required|email|unique:akun,email',

            'password' =>
                'required|string|min:8',

            'hubungan' =>
                'required|in:ayah,ibu,wali',

            'id_siswa' =>
                'required|exists:siswa,id_siswa'
        ]);

        $akun = Akun::create([
            'nama' =>
                $validated['nama'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),

            'role' => 'orang_tua'
        ]);

        $orangTua = OrangTua::create([
            'hubungan' =>
                $validated['hubungan'],

            'id_siswa' =>
                $validated['id_siswa'],

            'id_akun' =>
                $akun->id_akun
        ]);

        return response()->json([
            'success' => true,
            'message' =>
                'Data orang tua berhasil ditambahkan',
            'data' =>
                $orangTua->load([
                    'akun',
                    'siswa'
                ])
        ], 201);
    }

    public function show(
        OrangTua $orangTua
    ) {
        return response()->json([
            'success' => true,
            'data' =>
                $orangTua->load([
                    'akun',
                    'siswa'
                ])
        ]);
    }

    public function update(
        Request $request,
        OrangTua $orangTua
    ) {
        $validated = $request->validate([
            'hubungan' =>
                'sometimes|required|in:ayah,ibu,wali'
        ]);

        $orangTua->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Data orang tua berhasil diupdate',
            'data' =>
                $orangTua
                    ->fresh()
                    ->load([
                        'akun',
                        'siswa'
                    ])
        ]);
    }

    public function destroy(
        OrangTua $orangTua
    ) {
        if ($orangTua->akun) {
            $orangTua->akun->delete();
        }

        $orangTua->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Data orang tua berhasil dihapus'
        ]);
    }
}