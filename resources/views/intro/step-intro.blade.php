<div class="mb-6">
    <div class="w-20 h-20 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30 rotate-3">
        <span class="text-3xl">👋</span>
    </div>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
        Olá, {{ explode(' ', Auth::user()->name)[0] }}!
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
        Vamos configurar seu calendário escolar para você não perder nenhum feriado.
    </p>
</div>

<button type="button" @click="nextStep()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-2xl shadow-xl shadow-blue-600/20 transition active:scale-95">
    Começar Configuração
</button>

<div class="mt-6 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
    <button type="button" 
            onclick="document.getElementById('logout-form').submit();"
            class="text-sm font-medium text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition-colors flex items-center justify-center gap-2 mx-auto group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        Entrou com a conta errada? <span class="underline decoration-transparent hover:decoration-red-500/50">Sair</span>
    </button>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>