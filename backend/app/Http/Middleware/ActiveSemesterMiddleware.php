<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Semester;
use Symfony\Component\HttpFoundation\Response;

class ActiveSemesterMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $semester = Semester::where(
            'status',
            'aktif'
        )->first();

        if (!$semester) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada semester aktif'
            ], 400);
        }

        return $next($request);
    }
}