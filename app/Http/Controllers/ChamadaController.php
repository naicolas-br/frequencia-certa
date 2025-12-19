<?php

namespace App\Http\Controllers;

use App\Models\GradeHoraria;
use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChamadaController extends Controller
{
    // API: Retorna as aulas que o aluno tem HOJE
    public function aulasDeHoje()
    {
        // 1 = Segunda, ..., 5 = Sexta (Carbon usa ISO-8601 ou padrão PHP 'N')
        $diaSemanaHoje = date('N'); 

        // Busca na grade horária as matérias de hoje
        // Agrupa por disciplina_id para não repetir se tiver 2 aulas seguidas da mesma matéria
        $aulas = GradeHoraria::where('dia_semana', $diaSemanaHoje)
            ->where('user_id', Auth::id())
            ->with('disciplina')
            ->get()
            ->unique('disciplina_id')
            ->values(); // Reseta as chaves do array para o JSON ficar bonito

        return response()->json($aulas);
    }

    // API: Salva a chamada em lote
    public function registrar(Request $request)
    {
        $dados = $request->validate([
            'chamada' => 'required|array',
            'chamada.*.disciplina_id' => 'required|exists:disciplinas,id',
            'chamada.*.presente' => 'required|boolean',
        ]);

        $dataHoje = now()->format('Y-m-d');

        foreach ($dados['chamada'] as $item) {
            // CORREÇÃO: updateOrCreate permite alterar a chamada do mesmo dia
            Frequencia::updateOrCreate(
                [
                    // Condições para encontrar o registro (Quem, Qual Matéria, Qual Dia)
                    'user_id' => Auth::id(),
                    'disciplina_id' => $item['disciplina_id'],
                    'data' => $dataHoje,
                ],
                [
                    // O que deve ser salvo/atualizado
                    'presente' => $item['presente'],
                    'observacao' => $item['presente'] ? 'Presença confirmada' : 'Falta registrada via Check-in',
                ]
            );
        }

        return response()->json(['sucesso' => true, 'mensagem' => 'Chamada atualizada com sucesso!']);
    }
}