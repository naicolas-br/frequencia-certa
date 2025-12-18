<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">
                Horários: {{ $disciplina->nome }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-8">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Novo Horário</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Quando ocorrem as aulas?</p>
                    </header>

                    <form method="post" action="{{ route('grade.store', $disciplina->id) }}" class="mt-6 space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="dia_semana" value="Dia da Semana" />
                                <select id="dia_semana" name="dia_semana" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-11">
                                    <option value="1">Segunda-feira</option>
                                    <option value="2">Terça-feira</option>
                                    <option value="3">Quarta-feira</option>
                                    <option value="4">Quinta-feira</option>
                                    <option value="5">Sexta-feira</option>
                                    <option value="6">Sábado</option>
                                </select>
                                <x-input-error :messages="$errors->get('dia_semana')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4 md:col-span-2 md:grid-cols-2">
                                <div>
                                    <x-input-label for="horario_inicio" value="Início" />
                                    <x-text-input id="horario_inicio" name="horario_inicio" type="time" class="mt-1 block w-full h-11" required />
                                    <x-input-error :messages="$errors->get('horario_inicio')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="horario_fim" value="Término" />
                                    <x-text-input id="horario_fim" name="horario_fim" type="time" class="mt-1 block w-full h-11" required />
                                    <x-input-error :messages="$errors->get('horario_fim')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-2">
                            <x-primary-button class="w-full sm:w-auto justify-center h-11">{{ __('Adicionar Horário') }}</x-primary-button>
                            
                            @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 dark:text-green-400 font-bold">
                                    {{ session('success') }}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Horários Cadastrados</h3>
                </div>

                @if($horarios->isEmpty())
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Nenhum horário definido ainda.
                    </div>
                @else
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($horarios as $horario)
                            <li class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 dark:text-gray-200 text-lg">
                                        {{ $horario->dia_semana_texto }}
                                    </span>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ date('H:i', strtotime($horario->horario_inicio)) }} às {{ date('H:i', strtotime($horario->horario_fim)) }}
                                    </div>
                                </div>

                                <form action="{{ route('grade.destroy', $horario->id) }}" method="POST" onsubmit="return confirm('Apagar este horário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-full transition" aria-label="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>