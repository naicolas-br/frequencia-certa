<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CalendarioService
{
    public function gerarCalendario(string $estado, string $cidade): void
    {
        // Simulação de chamada externa
        // Em produção, isso pode ser movido para um JOB (Fila) para ser 100% assíncrono.
        
        // Log informativo (apenas para debug)
        Log::info("Iniciando busca de feriados para {$cidade}-{$estado}...");

        // TODO: Implementar chamada real para feriados.dev
        // Exemplo de como a falha seria tratada pelo Controller:
        // throw new \Exception("API feriados.dev indisponível (Timeout)");
    }
}