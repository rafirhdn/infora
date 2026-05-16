<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        return Jurusan::orderBy('nama')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        return Jurusan::create($validated);
    }

    public function show(Jurusan $jurusan)
    {
        return $jurusan->load('kelas');
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'sometimes|required|in:aktif,nonaktif'
        ]);

        $jurusan->update($validated);

        return $jurusan->fresh();
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->update([
            'status' => 'nonaktif'
        ]);

        return response()->json([
            'message' => 'Jurusan dinonaktifkan'
        ]);
    }
}