<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Nova Disciplina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('disciplinas.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Matéria</label>
                            <input type="text" name="nome" id="nome" required placeholder="Ex: Matemática"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Escolha uma Cor (Etiqueta)</label>
                            <div class="flex gap-4 flex-wrap">
                                @php
                                    $colors = [
                                        '#1E3A8A' => 'Azul Inst.', 
                                        '#DC2626' => 'Vermelho', 
                                        '#F59E0B' => 'Amarelo', 
                                        '#10B981' => 'Verde', 
                                        '#8B5CF6' => 'Roxo', 
                                        '#EC4899' => 'Rosa'
                                    ];
                                @endphp

                                @foreach($colors as $hex => $label)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="cor" value="{{ $hex }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gray-200 peer-checked:ring-4 ring-offset-2 ring-blue-500 transition-all flex items-center justify-center text-white"
                                             style="background-color: {{ $hex }}">
                                             </div>
                                        <span class="text-xs text-center block mt-1 text-gray-500">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('cor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm underline">Cancelar</a>
                            
                            <button type="submit" 
                                class="bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition">
                                Salvar Disciplina
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>