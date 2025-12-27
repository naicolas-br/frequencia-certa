<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Auth::user()->disciplinas()->with(['horarios', 'frequencias'])->get();
        return view('dashboard', compact('disciplinas'));
    }

    public function criar()
    {
        return view('disciplinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cor' => 'required|string|max:7',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $inicio = $request->data_inicio ?? Auth::user()->ano_letivo_inicio;
        $fim    = $request->data_fim    ?? Auth::user()->ano_letivo_fim;

        Auth::user()->disciplinas()->create([
            'nome' => $request->nome,
            'cor' => $request->cor,
            'data_inicio' => $inicio,
            'data_fim' => $fim,
            'carga_horaria_total' => 0, 
            'porcentagem_minima' => 75,
        ]);

        // ALTERAÇÃO: Suporte a AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Disciplina cadastrada com sucesso!'], 201);
        }

        return redirect()->route('dashboard')->with('toast',[
            'type' => 'success',
            'message' => 'Disciplina cadastrada com sucesso!'
        ]);
    }

    public function edit($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        if ($disciplina->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }
        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update(Request $request, $id)
    {
        $disciplina = Disciplina::findOrFail($id);

        if ($disciplina->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'cor' => 'required|string|max:7',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $disciplina->update([
            'nome' => $request->nome,
            'cor' => $request->cor,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim
        ]);

        // ALTERAÇÃO: Suporte a AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Disciplina atualizada com sucesso!'], 200);
        }

        return redirect()->route('dashboard')->with('toast',[
            'type' => 'success',
            'message' => 'Disciplina atualizada com sucesso!'
        ]);
    }

    public function destroy(Request $request, $id) // Injetei o Request aqui
    {
        $disciplina = Disciplina::findOrFail($id);

        if ($disciplina->user_id !== Auth::id()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }
            abort(403);
        }

        $disciplina->delete();

        /**
         * ALTERAÇÃO PRINCIPAL:
         * Se a requisição for AJAX (como no botão de excluir da dashboard),
         * retornamos JSON. Assim o fetch() no JavaScript recebe um 200 OK limpo,
         * sem redirecionamentos que causam erro de cache.
         */
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Disciplina removida com sucesso!'], 200);
        }

        return redirect()->route('dashboard')->with('toast',[
            'type' => 'success',
            'message' => 'Disciplina removida com sucesso!'
        ]);
    }
}