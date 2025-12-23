<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Lista todos os dias livres (eventos) do usuário
     */
    public function index()
    {
        $eventos = Evento::where('user_id', Auth::id())
            ->orderBy('data')
            ->get();

        return view('eventos.index', compact('eventos'));
    }

    /**
     * Salva um novo dia livre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'    => 'required|string|max:255',
            'data'      => 'required|date',
            'tipo'      => 'required|in:sem_aula,feriado',
            'descricao' => 'nullable|string|max:500',
        ]);

        // Regra de negócio:
        // Um usuário não pode cadastrar dois eventos no mesmo dia
        $jaExiste = Evento::where('user_id', Auth::id())
            ->whereDate('data', $validated['data'])
            ->exists();

        if ($jaExiste) {
            return redirect()->back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Erro!',
                'text'  => 'Já existe um dia livre cadastrado para essa data.',
            ]);
        }

        Evento::create([
            'user_id'   => Auth::id(),
            'titulo'    => $validated['titulo'],
            'data'      => $validated['data'],
            'tipo'      => $validated['tipo'],
            'descricao' => $validated['descricao'] ?? null,
        ]);

        return redirect()->back()->with('toast', [
            'type'    => 'success',
            'message' => 'Dia livre cadastrado com sucesso!',
        ]);
    }

    /**
     * Mostra a tela de edição de um dia livre
     */
    public function edit($id)
    {
        $evento = Evento::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('eventos.edit', compact('evento'));
    }

    /**
     * Atualiza um dia livre existente
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::where('user_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'titulo'    => 'required|string|max:255',
            'data'      => 'required|date',
            'tipo'      => 'required|in:sem_aula,feriado',
            'descricao' => 'nullable|string|max:500',
        ]);

        // Regra de negócio:
        // Não permitir dois eventos no mesmo dia,
        // ignorando o próprio evento que está sendo editado
        $jaExiste = Evento::where('user_id', Auth::id())
            ->whereDate('data', $validated['data'])
            ->where('id', '!=', $evento->id)
            ->exists();

        if ($jaExiste) {
            return redirect()->back()->with('swal', [
                'icon'  => 'warning',
                'title' => 'Data já utilizada',
                'text'  => 'Já existe um dia livre cadastrado para esta data.',
            ]);
        }

        $evento->update([
            'titulo'    => $validated['titulo'],
            'data'      => $validated['data'],
            'tipo'      => $validated['tipo'],
            'descricao' => $validated['descricao'] ?? null,
        ]);

        return redirect()->route('eventos.index')->with('toast', [
            'type'    => 'success',
            'message' => 'Dia livre atualizado com sucesso!',
        ]);
    }

    /**
     * Remove um dia livre
     */
    public function destroy($id)
    {
        $evento = Evento::where('user_id', Auth::id())
            ->findOrFail($id);

        $evento->delete();

        return redirect()->back()->with('toast', [
            'type'    => 'success',
            'message' => 'Dia livre removido com sucesso!',
        ]);
    }
}
