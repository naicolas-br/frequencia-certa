<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DisciplinaApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Grupo de rotas protegidas (Só acessa se tiver logado no App)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/disciplinas', [DisciplinaApiController::class, 'index']);
});