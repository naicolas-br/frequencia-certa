<x-app-layout>
    {{-- Container Principal com Padding ajustado para mobile --}}
    <div class="min-h-screen pb-20">
        
        {{-- HEADER STICKY (Melhor para mobile) --}}
        <div class="sticky top-0 z-20 backdrop-blur-xl bg-gray-100/80 dark:bg-gray-900/80 border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-5xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0"> {{-- min-w-0 impede que texto longo quebre o layout --}}
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">
                            Dias Livres
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">
                            Gerencie seus feriados e folgas
                        </p>
                    </div>

                    <a href="{{ route('dashboard') }}"
                       class="shrink-0 inline-flex items-center justify-center p-2.5 sm:px-4 sm:py-2 rounded-xl 
                              bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                              text-gray-700 dark:text-gray-300 font-medium text-sm
                              shadow-sm active:scale-95 transition-transform duration-200">
                        {{-- Ícone apenas no mobile, Texto no Desktop --}}
                        <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Voltar</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-6">

            {{-- LISTAGEM --}}
            @if($eventos->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center
                            bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-300 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-gray-900 dark:text-white">
                        Nenhum dia livre
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Seus dias de folga aparecerão aqui.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($eventos as $evento)
                        @php
                            $isFeriado = $evento->tipo === 'feriado';
                            $tipoLabel = ucfirst(str_replace('_', ' ', $evento->tipo));
                            $dataCarbon = \Carbon\Carbon::parse($evento->data);
                        @endphp

                        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                            
                            {{-- Indicador Lateral Colorido --}}
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $isFeriado ? 'bg-red-500' : 'bg-blue-500' }}"></div>

                            <div class="p-5 pl-7">
                                {{-- CABEÇALHO DO CARD (Data e Badge) --}}
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold uppercase text-gray-400">
                                            {{ $dataCarbon->translatedFormat('l') }} {{-- Ex: Segunda-feira --}}
                                        </span>
                                        <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $dataCarbon->format('d/m') }} <span class="text-sm font-normal text-gray-400">/{{ $dataCarbon->format('Y') }}</span>
                                        </span>
                                    </div>

                                    {{-- Badge de Tipo --}}
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide uppercase
                                        {{ $isFeriado 
                                            ? 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400' 
                                            : 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                        {{ $tipoLabel }}
                                    </span>
                                </div>

                                {{-- CONTEÚDO --}}
                                <div class="mb-5">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 leading-snug">
                                        {{ $evento->titulo }}
                                    </h3>
                                    @if($evento->descricao)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                            {{ $evento->descricao }}
                                        </p>
                                    @endif
                                </div>

                                {{-- DIVISOR --}}
                                <div class="h-px w-full bg-gray-100 dark:bg-gray-700 mb-4"></div>

                                {{-- AÇÕES (Área de toque grande) --}}
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('eventos.edit', $evento->id) }}"
                                       class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl
                                              text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20
                                              active:bg-blue-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>

                                    <form action="{{ route('eventos.destroy', $evento->id) }}"
                                          method="POST"
                                          class="flex-1 sm:flex-none"
                                          data-confirm="Deseja excluir este dia livre?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl
                                                       text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20
                                                       active:bg-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>