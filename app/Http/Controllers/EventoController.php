<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'titulo'    => 'required|string|max:255',
        'data'      => 'required|date',
        'tipo'      => 'required|in:sem_aula,feriado',
        'descricao' => 'nullable|string|max:500',
    ]);

    $jaExiste = Evento::where('user_id', Auth::id())
        ->whereDate('data', $validated['data'])
        ->exists();

    if ($jaExiste) {
        return redirect()->back()
            ->withErrors(['data' => 'Você já marcou um evento neste dia.']);
    }

    Evento::create([
        'user_id'   => Auth::id(),
        'titulo'    => $validated['titulo'],
        'data'      => $validated['data'],
        'tipo'      => $validated['tipo'],
        'descricao' => $validated['descricao'] ?? null,
    ]);

    return redirect()->back()->with('success', 'Dia livre marcado com sucesso!');
}

}