<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rota de Teste Temporária (sem segurança)
Route::get('/teste-disciplinas', function () {
    // Pega o usuário ID 1 (Nicolas) e retorna as disciplinas dele
    return User::find(1)->disciplinas;
});