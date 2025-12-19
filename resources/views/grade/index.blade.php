<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $disciplina->cor }}"></div>
                    <h2 class="font-bold text-lg text-gray-800 dark:text-white leading-tight truncate max-w-[150px]">
                        {{ $disciplina->nome }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Novo Horário</h3>
                
                <form action="{{ route('grade.store', $disciplina->id) }}" method="POST" x-data="{ dia: '1' }">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 mb-2">Dia da Semana</label>
                        <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                            @php
                                $dias = [
                                    1 => 'Seg', 2 => 'Ter', 3 => 'Qua', 
                                    4 => 'Qui', 5 => 'Sex', 6 => 'Sab'
                                ];
                            @endphp
                            
                            @foreach($dias as $k => $d)
                                <label class="cursor-pointer">
                                    <input type="radio" name="dia_semana" value="{{ $k }}" class="sr-only" x-model="dia">
                                    <span class="px-4 py-3 rounded-xl text-sm font-bold border transition-all inline-block min-w-[60px] text-center"
                                          :class="dia == '{{ $k }}' 
                                            ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-500/30' 
                                            : 'bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-transparent hover:bg-gray-100 dark:hover:bg-gray-600'">
                                        {{ $d }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Início</label>
                            <input type="time" name="horario_inicio" required class="w-full text-center rounded-xl bg-gray-50 dark:bg-gray-700 border-0 focus:ring-2 focus:ring-blue-500 dark:text-white py-3 font-mono text-lg font-bold">
                        </div>
                        <div class="flex items-end pb-3 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Fim</label>
                            <input type="time" name="horario_fim" required class="w-full text-center rounded-xl bg-gray-50 dark:bg-gray-700 border-0 focus:ring-2 focus:ring-blue-500 dark:text-white py-3 font-mono text-lg font-bold">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black dark:bg-white dark:text-black text-white font-bold py-3.5 rounded-xl shadow-lg active:scale-[0.98] transition flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Adicionar Horário
                    </button>
                </form>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 px-1">Horários Definidos</h3>
                
                @if($disciplina->horarios->count() > 0)
                    <div class="space-y-3">
                        @foreach($disciplina->horarios->sortBy('dia_semana') as $horario)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex justify-between items-center group">
                                
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col items-center justify-center w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400">
                                        <span class="text-[10px] font-bold uppercase">Dia</span>
                                        <span class="text-lg font-extrabold leading-none">
                                            {{ substr(\Carbon\Carbon::parse("2023-01-0{$horario->dia_semana}")->locale('pt_BR')->dayName, 0, 3) }}
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Horário da aula</p>
                                        <p class="font-mono font-bold text-gray-800 dark:text-gray-200 text-lg">
                                            {{ \Carbon\Carbon::parse($horario->horario_inicio)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($horario->horario_fim)->format('H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <form action="{{ route('grade.destroy', $horario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl opacity-60">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-gray-500 font-medium">Nenhum horário ainda.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>