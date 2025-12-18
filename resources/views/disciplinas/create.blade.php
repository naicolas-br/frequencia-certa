<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nova Disciplina') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('disciplinas.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="nome" value="Nome da Matéria" />
                            <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full h-12" placeholder="Ex: Matemática" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                        </div>

                        <div>
                            <x-input-label for="cor" value="Cor da Etiqueta" />
                            <div class="mt-2 flex items-center gap-4">
                                <div class="relative w-full h-14">
                                    <input type="color" name="cor" id="cor" value="#1E3A8A" 
                                           class="absolute top-0 left-0 w-full h-full p-1 rounded-lg border border-gray-300 dark:border-gray-700 cursor-pointer bg-white dark:bg-gray-900">
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Toque na barra acima para escolher uma cor personalizada.
                            </p>
                            <x-input-error class="mt-2" :messages="$errors->get('cor')" />
                        </div>

                        <div class="pt-4">
                            <x-primary-button class="w-full justify-center h-12 text-lg">
                                {{ __('Salvar Disciplina') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>