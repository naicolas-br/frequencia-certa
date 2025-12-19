<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                Painel do Aluno
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">Ano Letivo 2025</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4 sm:px-0">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border-l-4 border-emerald-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Frequência Global</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">--%</h3>
                            <p class="text-xs text-gray-500 mt-2">Aguardando dados...</p>
                        </div>
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900 rounded-full text-emerald-600 dark:text-emerald-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div 
                    x-data="{ 
                        modalOpen: false, 
                        aulas: [], 
                        loading: false,
                        enviando: false,
                        sucesso: false,
                        
                        async abrirModal() {
                            this.loading = true;
                            this.modalOpen = true;
                            this.sucesso = false;
                            
                            try {
                                // Busca aulas do dia
                                let res = await fetch('/api/aulas-hoje');
                                let data = await res.json();
                                
                                // Mapeia para o formato do modal (Padrão: Presente)
                                this.aulas = data.map(aula => ({
                                    disciplina_id: aula.disciplina.id,
                                    nome: aula.disciplina.nome,
                                    cor: aula.disciplina.cor,
                                    horario: aula.horario_inicio,
                                    presente: true 
                                }));
                            } catch(e) {
                                console.error('Erro ao buscar aulas', e);
                            }
                            this.loading = false;
                        },

                        async confirmarChamada() {
                            this.enviando = true;
                            
                            // Monta payload
                            let payload = {
                                chamada: this.aulas.map(a => ({
                                    disciplina_id: a.disciplina_id,
                                    presente: a.presente
                                }))
                            };

                            // Envia para o Backend
                            try {
                                let response = await fetch('/api/registrar-chamada', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(payload)
                                });

                                if (response.ok) {
                                    this.sucesso = true;
                                    // Recarrega a página após 1s para atualizar os contadores
                                    setTimeout(() => { window.location.reload(); }, 1000);
                                }
                            } catch (e) {
                                alert('Erro de conexão');
                            }
                            this.enviando = false;
                        }
                    }"
                    class="bg-[#1E3A8A] overflow-hidden shadow-sm rounded-xl p-6 text-white relative"
                >
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 rounded-full bg-blue-700 opacity-50"></div>
                    <p class="text-blue-100 text-sm font-medium z-10 relative">Hoje é {{ \Carbon\Carbon::now()->locale('pt_BR')->dayName }}</p>
                    <h3 class="text-2xl font-bold mt-1 z-10 relative">Chamada Diária</h3>
                    
                    <button @click="abrirModal()" class="mt-4 w-full bg-white text-blue-900 font-bold py-2 px-4 rounded shadow hover:bg-gray-100 transition z-10 relative text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Registrar Presença
                    </button>

                    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            
                            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="modalOpen = false"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="modalOpen" x-transition.scale class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Aulas de Hoje</h3>
                                    
                                    <div x-show="loading" class="text-center py-6">
                                        <svg class="animate-spin h-8 w-8 mx-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <p class="mt-2 text-sm text-gray-500">Buscando grade...</p>
                                    </div>

                                    <div x-show="sucesso" class="text-center py-6 text-green-600">
                                        <svg class="h-12 w-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <p class="font-bold text-lg">Chamada Confirmada!</p>
                                        <p class="text-xs">Atualizando dados...</p>
                                    </div>

                                    <div x-show="!loading && !sucesso">
                                        <div x-show="aulas.length === 0" class="text-center py-4 text-gray-500">
                                            Nenhuma aula agendada para hoje. 😴
                                        </div>

                                        <ul class="space-y-3 mt-4">
                                            <template x-for="(aula, index) in aulas" :key="index">
                                                <li class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4" :style="'border-left-color: ' + aula.cor">
                                                    <div class="flex-1">
                                                        <p class="font-bold text-gray-800 dark:text-gray-100" x-text="aula.nome"></p>
                                                        <p class="text-xs text-gray-500" x-text="'Início: ' + aula.horario.substring(0,5)"></p>
                                                    </div>
                                                    
                                                    <button @click="aula.presente = !aula.presente" class="relative inline-flex h-8 w-16 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none" :class="aula.presente ? 'bg-green-500' : 'bg-red-500'">
                                                        <span class="sr-only">Toggle</span>
                                                        <span aria-hidden="true" class="pointer-events-none inline-block h-7 w-7 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 flex items-center justify-center text-xs font-bold" :class="aula.presente ? 'translate-x-8 text-green-600' : 'translate-x-0 text-red-600'">
                                                            <span x-text="aula.presente ? 'P' : 'F'"></span>
                                                        </span>
                                                    </button>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>

                                <div x-show="!loading && !sucesso && aulas.length > 0" class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button @click="confirmarChamada()" :disabled="enviando" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none disabled:opacity-50 sm:ml-3 sm:w-auto sm:text-sm">
                                        <span x-show="!enviando">Confirmar Chamada</span>
                                        <span x-show="enviando">Salvando...</span>
                                    </button>
                                    <button @click="modalOpen = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancelar
                                    </button>
                                </div>
                                <div x-show="!loading && !sucesso && aulas.length === 0" class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6">
                                    <button @click="modalOpen = false" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border-l-4 border-red-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Em Risco</p>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">Análise</h3>
                            <p class="text-xs text-red-500 font-semibold mt-2">Dados insuficientes</p>
                        </div>
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full text-red-600 dark:text-red-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-0 mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Minhas Disciplinas</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($disciplinas as $disciplina)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition duration-200 overflow-hidden border border-gray-100 dark:border-gray-700">
                            
                            <div class="h-2 w-full" style="background-color: {{ $disciplina->cor ?? '#1E3A8A' }}"></div>
                            
                            <div class="p-5">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $disciplina->nome }}
                                        </h4>
                                        <div class="flex flex-col sm:flex-row gap-2 mt-1">
                                            <a href="{{ route('grade.index', $disciplina->id) }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Configurar Horários
                                            </a>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $disciplina->horarios->count() }} aulas semanais
                                        </p>
                                    </div>
                                    
                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                        {{ $disciplina->frequencias->filter(function($f){ return $f->presente == false; })->count() }} Faltas
                                    </span>
                                </div>
                                
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="h-2.5 rounded-full" style="width: 100%; background-color: {{ $disciplina->cor ?? '#10B981' }}"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2">Sincronizado.</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300">
                            <p class="mt-2 text-sm text-gray-500">Nenhuma disciplina cadastrada.</p>
                        </div>
                    @endforelse

                    <a href="{{ route('disciplinas.criar') }}" class="hidden md:flex bg-gray-50 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center p-6 hover:bg-gray-100 dark:hover:bg-gray-600 transition cursor-pointer group">
                        <div class="text-center">
                            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-600 group-hover:bg-blue-100 dark:group-hover:bg-blue-900 transition">
                                <svg class="h-6 w-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">Nova Disciplina</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('disciplinas.criar') }}" class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg z-50 md:hidden transition-transform transform hover:scale-110 active:scale-95 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        <span class="sr-only">Nova Disciplina</span>
    </a>

</x-app-layout>