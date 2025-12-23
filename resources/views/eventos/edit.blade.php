<x-app-layout>
    <div class="min-h-screen pb-12">

        {{-- HEADER STICKY (Mantendo consistência com a Listagem) --}}
        <div class="sticky top-0 z-20 backdrop-blur-xl bg-gray-100/80 dark:bg-gray-900/80 border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-xl mx-auto px-4 py-4">
                <div class="flex items-center gap-4">
                    {{-- Botão Voltar (Ícone) --}}
                    <a href="{{ route('eventos.index') }}" 
                       class="p-2 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        Editar Dia Livre
                    </h1>
                </div>
            </div>
        </div>

        {{-- FORMULÁRIO --}}
        <div class="max-w-xl mx-auto px-4 mt-6">
            
            <form method="POST" action="{{ route('eventos.update', $evento->id) }}"
                  class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-8 space-y-6">
                
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Título do Evento
                    </label>
                    <input type="text" 
                           name="titulo" 
                           value="{{ old('titulo', $evento->titulo) }}" 
                           required
                           placeholder="Ex: Emenda de Feriado"
                           class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-gray-900/50 
                                  border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-gray-900 focus:ring-2 focus:ring-blue-500/20 
                                  text-gray-900 dark:text-white placeholder-gray-400 transition-all outline-none
                                  @error('titulo') border-red-500 bg-red-50 text-red-900 @enderror">
                    @error('titulo')
                        <p class="text-xs text-red-500 ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Grid para Data e Tipo (Lado a lado em telas maiores, empilhado no mobile) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    {{-- Data --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                            Data
                        </label>
                        <div class="relative">
                            <input type="date" 
                                   name="data" 
                                   value="{{ old('data', $evento->data->format('Y-m-d')) }}" 
                                   required
                                   class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-gray-900/50 
                                          border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-gray-900 focus:ring-2 focus:ring-blue-500/20 
                                          text-gray-900 dark:text-white transition-all outline-none appearance-none">
                        </div>
                    </div>

                    {{-- Tipo --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                            Tipo de Folga
                        </label>
                        <div class="relative">
                            <select name="tipo" required
                                    class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-gray-900/50 
                                           border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-gray-900 focus:ring-2 focus:ring-blue-500/20 
                                           text-gray-900 dark:text-white appearance-none transition-all outline-none cursor-pointer">
                                <option value="sem_aula" @selected($evento->tipo === 'sem_aula')>Sem Aula (Folga)</option>
                                <option value="feriado" @selected($evento->tipo === 'feriado')>Feriado Nacional</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Botões de Ação --}}
                <div class="pt-6 flex flex-col-reverse sm:flex-row gap-3">
                    <a href="{{ route('eventos.index') }}"
                       class="w-full sm:w-auto px-6 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700
                              text-gray-700 dark:text-gray-300 font-bold text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:flex-1 px-6 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 
                                   text-white font-bold text-center shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transition transform active:scale-[0.98]">
                        Salvar Alterações
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>