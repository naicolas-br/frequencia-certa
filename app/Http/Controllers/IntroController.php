<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntroRequest;
use App\Services\CalendarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class IntroController extends Controller
{
    /**
     * Aplica o middleware de autenticação no construtor
     * reforçando a segurança além das rotas.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View|RedirectResponse
    {
        if (Auth::user()->has_seen_intro) {
            return redirect()->route('dashboard');
        }

        return view('intro.index');
    }

    public function store(StoreIntroRequest $request, CalendarioService $calendarioService): RedirectResponse
    {
        // 1. Persistência
        // Os dados já vêm validados e normalizados pelo StoreIntroRequest
        $user = $request->user();
        
        $user->update([
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'has_seen_intro' => true 
        ]);

        // 2. Integração Externa (Não Bloqueante / Fail-safe)
        try {
            // Tentamos gerar o calendário. Se a API externa cair,
            // isso NÃO deve impedir o usuário de acessar o dashboard.
            $calendarioService->gerarCalendario($request->estado, $request->cidade);

        } catch (\Exception $e) {
            // 3. Log de Erro Silencioso
            // Registramos o erro para o desenvolvedor ver, mas o usuário segue feliz.
            Log::error('Falha ao gerar calendário no onboarding', [
                'user_id' => $user->id,
                'estado' => $request->estado,
                'cidade' => $request->cidade,
                'erro' => $e->getMessage()
            ]);
        }

        return redirect()->route('dashboard');
    }
}