<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                Grade Horária
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ diaAtivo: {{ date('N') > 6 ? 1 : date('N') }} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="md:hidden mb-6">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dia da Semana</label>
                <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar">
                    @foreach([1=>'Seg', 2=>'Ter', 3=>'Qua', 4=>'Qui', 5=>'Sex', 6=>'Sáb'] as $num => $nome)
                        <button @click="diaAtivo = {{ $num }}" 
                            class="px-5 py-3 rounded-2xl text-sm font-bold transition-all transform active:scale-95 whitespace-nowrap shadow-sm"
                            :class="diaAtivo === {{ $num }} 
                                ? 'bg-blue-600 text-white shadow-blue-500/30 ring-2 ring-blue-600 ring-offset-2 dark:ring-offset-gray-900' 
                                : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-100 dark:border-gray-700'"
                        >
                            {{ $nome }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="md:hidden space-y-4 min-h-[300px]">
                @for($i = 1; $i <= 6; $i++)
                    <div x-show="diaAtivo === {{ $i }}" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                    >
                        @if(isset($gradePorDia[$i]) && count($gradePorDia[$i]) > 0)
                            <div class="space-y-3">
                                @foreach($gradePorDia[$i] as $aula)
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden flex items-center justify-between">
                                        
                                        <div class="absolute left-0 top-0 bottom-0 w-1.5" style="background-color: {{ $aula->disciplina->cor }}"></div>
                                        
                                        <div class="pl-4">
                                            <h3 class="font-bold text-gray-800 dark:text-white text-lg leading-tight">
                                                {{ $aula->disciplina->nome }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1 font-medium bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-md inline-block">
                                                Professor(a) não definido
                                            </p>
                                        </div>

                                        <div class="text-right">
                                            <p class="text-2xl font-mono font-bold text-gray-700 dark:text-gray-200 tracking-tight">
                                                {{ date('H:i', strtotime($aula->horario_inicio)) }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium uppercase">Até {{ date('H:i', strtotime($aula->horario_fim)) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-16 text-center opacity-60">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-bold">Dia Livre!</p>
                                <p class="text-xs text-gray-400">Aproveite para descansar.</p>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>

            <div class="hidden md:grid grid-cols-5 gap-6">
                @foreach([1=>'Segunda', 2=>'Terça', 3=>'Quarta', 4=>'Quinta', 5=>'Sexta'] as $num => $nome)
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-center mb-4">
                            <span class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-bold text-gray-500 uppercase tracking-widest shadow-sm">
                                {{ $nome }}
                            </span>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-3xl p-3 h-full border border-gray-100 dark:border-gray-700/50 space-y-3">
                            @if(isset($gradePorDia[$num]))
                                @foreach($gradePorDia[$num] as $aula)
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition group relative overflow-hidden">
                                        <div class="absolute top-4 right-4 w-2 h-2 rounded-full" style="background-color: {{ $aula->disciplina->cor }}"></div>
                                        
                                        <p class="font-bold text-gray-800 dark:text-white text-sm pr-4">
                                            {{ $aula->disciplina->nome }}
                                        </p>
                                        <div class="mt-2 flex items-center text-xs text-gray-500 dark:text-gray-400 font-mono bg-gray-50 dark:bg-gray-700/50 rounded px-2 py-1 w-fit">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ date('H:i', strtotime($aula->horario_inicio)) }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="h-full flex items-center justify-center">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold opacity-50">Livre</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>