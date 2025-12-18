<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\GradeHoraria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeHorariaController extends Controller
{
    // Mostra a tela de configuração de horários de UMA disciplina
    public function index($disciplinaId)
    {
        // Busca a disciplina e garante que ela pertence ao usuário logado (segurança)
        $disciplina = Auth::user()->disciplinas()->findOrFail($disciplinaId);
        
        // Carrega os horários já cadastrados
        $horarios = $disciplina->horarios()->orderBy('dia_semana')->orderBy('horario_inicio')->get();

        return view('grade.index', compact('disciplina', 'horarios'));
    }

    // Salva um novo horário
    public function store(Request $request, $disciplinaId)
    {
        $disciplina = Auth::user()->disciplinas()->findOrFail($disciplinaId);

        $request->validate([
            'dia_semana' => 'required|integer|between:1,7',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        GradeHoraria::create([
            'user_id' => Auth::id(),
            'disciplina_id' => $disciplina->id,
            'dia_semana' => $request->dia_semana,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim' => $request->horario_fim,
        ]);

        return back()->with('success', 'Horário adicionado com sucesso!');
    }

    // Deletar um horário (caso erre)
    public function destroy($id)
    {
        $horario = GradeHoraria::where('user_id', Auth::id())->findOrFail($id);
        $horario->delete();
        
        return back()->with('success', 'Horário removido.');
    }
}