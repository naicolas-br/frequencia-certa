<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Minhas Disciplinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-lg font-bold mb-4">Grade Curricular</h3>

                    @if($disciplinas->isEmpty())
                        <p class="text-gray-500">Nenhuma disciplina cadastrada.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($disciplinas as $disciplina)
                                <div class="border-l-4 bg-gray-50 dark:bg-gray-700 p-4 rounded shadow hover:shadow-md transition"
                                     style="border-color: {{ $disciplina->cor }}">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-xl font-bold text-slate-800 dark:text-white">
                                            {{ $disciplina->nome }}
                                        </h4>
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $disciplina->cor }}"></span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">
                                        Aulas semanais: {{ $disciplina->aulas_semanais ?? 'Não definido' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>