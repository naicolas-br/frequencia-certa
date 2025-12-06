<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaApiController extends Controller
{
    public function index(Request $request)
    {
        // O Laravel Sanctum (autenticação de API) já nos dá o usuário
        $user = $request->user();

        // Retorna JSON com status 200 (OK)
        return response()->json([
            'status' => 'success',
            'data' => $user->disciplinas
        ], 200);
    }
}