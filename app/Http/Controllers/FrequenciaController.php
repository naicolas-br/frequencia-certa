<?php

namespace App\Http\Controllers;

use App\Models\GradeHoraria;
use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrequenciaController extends Controller
{
    // 1. Busca as aulas de HOJE para mostrar no Modal
    public function aulasDeHoje()
    {
        // 1 (Segunda) a 7 (Domingo)
        $diaHoje = date('N'); 

        // Busca na grade horária
        $aulas = GradeHoraria::where('dia_semana', $diaHoje)
            ->where('user_id', Auth::id())
            ->with('disciplina')
            ->get()
            ->unique('disciplina_id') // Evita duplicar se tiver 2 horários seguidos
            ->values();

        return response()->json($aulas);
    }

    // 2. Salva a lista inteira (Lógica que você gosta, aplicada em lote)
    public function registrarLote(Request $request)
    {
        // Recebe a lista do Front-end
        $listaChamada = $request->input('chamada');

        $dataHoje = now()->format('Y-m-d');

        foreach ($listaChamada as $item) {
            // AQUI ESTÁ A LÓGICA QUE FUNCIONA:
            // Usamos updateOrCreate para garantir:
            // 1. Se não existe, CRIA (igual ao seu create)
            // 2. Se já existe, ATUALIZA (para você poder corrigir se errou)
            
            Frequencia::updateOrCreate(
                [
                    // Condições de busca (WHERE)
                    'user_id' => Auth::id(),
                    'disciplina_id' => $item['disciplina_id'],
                    'data' => $dataHoje,
                ],
                [
                    // Valores a salvar (INSERT/UPDATE)
                    'presente' => $item['presente'], // true ou false
                    'observacao' => $item['presente'] ? 'Presença' : 'Falta (Check-in Diário)',
                ]
            );
        }

        return response()->json(['sucesso' => true]);
    }
}