<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Redirecionamento de segurança (Onboarding)
        if (!$user->has_seen_intro) {
            return redirect()->route('intro');
        }

        // 2. Prepara a Query (com relacionamentos)
        $query = $user->disciplinas()->with(['frequencias', 'horarios']);

        // --- FILTRO 1: AULAS DE HOJE ---
        if ($request->filtro === 'hoje') {
            $diaHoje = now()->dayOfWeek;
            $query->whereHas('horarios', function ($q) use ($diaHoje) {
                $q->where('dia_semana', $diaHoje);
            });
        }

        // 3. Busca os dados (Ordenado A-Z)
        $disciplinas = $query->orderBy('nome', 'asc')->get();

        // 4. Cálculos de Estatísticas (Global)
        $todasFrequencias = $disciplinas->pluck('frequencias')->collapse();
        $totalAulasGeral = $todasFrequencias->count();
        $totalFaltasGeral = $todasFrequencias->where('presente', false)->count();
        $totalPresencasGeral = $todasFrequencias->where('presente', true)->count();

        // Cálculo da Porcentagem Global
        $porcentagemGlobal = 100;
        if ($totalAulasGeral > 0) {
            $porcentagemGlobal = round((($totalAulasGeral - $totalFaltasGeral) / $totalAulasGeral) * 100);
        }

        // Definindo a Cor Global
        $corGlobal = 'text-emerald-600 dark:text-emerald-400';
        if ($porcentagemGlobal < 75) {
            $corGlobal = 'text-red-600 dark:text-red-400';
        } elseif ($porcentagemGlobal < 85) {
            $corGlobal = 'text-yellow-600 dark:text-yellow-400';
        }

        // Contagem de Matérias em Risco
        $materiasEmRisco = $disciplinas->filter(function ($d) {
            return $d->taxa_presenca < 75;
        })->count();

        // --- FILTRO 2: EM RISCO (Aplicado na coleção para exibição) ---
        if ($request->filtro === 'risco') {
            $disciplinas = $disciplinas->filter(function ($disciplina) {
                return $disciplina->taxa_presenca < 75;
            });
        }

        // Dados para Gráficos
        $graficoLabels = $disciplinas->pluck('nome');
        $graficoDados = $disciplinas->map(fn($d) => $d->taxa_presenca);
        $graficoCores = $graficoDados->map(function ($val) {
            return $val >= 75 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)';
        });

        return view('dashboard', compact(
            'disciplinas',
            'porcentagemGlobal',
            'corGlobal',
            'materiasEmRisco',
            'totalPresencasGeral',
            'totalFaltasGeral',
            'graficoLabels',
            'graficoDados',
            'graficoCores'
        ));
    }
}
