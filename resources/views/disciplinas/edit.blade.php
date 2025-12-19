<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}"
               class="p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                Editar Matéria
            </h2>
        </div>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="POST"
                  x-data="{
                      color: '{{ old('cor', $disciplina->cor) }}',
                      customColor: '{{ old('cor', $disciplina->cor) }}',
                      updateCustom() {
                          this.color = this.customColor;
                      }
                  }">
                @csrf
                @method('PUT')

                <input type="hidden" name="cor" :value="color">

                <div class="space-y-8">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                            Nome da Matéria
                        </label>
                        <input type="text" name="nome" placeholder="Ex: Matemática" required
                               value="{{ old('nome', $disciplina->nome) }}"
                               class="w-full text-lg font-semibold bg-transparent border-0 border-b-2
                                      border-gray-300 dark:border-gray-600 focus:border-blue-500
                                      focus:ring-0 px-1 py-3 placeholder-gray-300
                                      dark:placeholder-gray-600 dark:text-white transition-colors">
                        @error('nome')
                            <p class="text-red-500 text-xs mt-1 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 ml-1">
                            Cor da Etiqueta
                        </label>

                        <div class="grid grid-cols-5 gap-4">
                            @php
                                $cores = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#6366F1', '#14B8A6', '#F97316', '#64748B'];
                            @endphp

                            @foreach($cores as $c)
                                <label class="relative flex items-center justify-center cursor-pointer group">
                                    <input type="radio" class="sr-only"
                                           x-model="color"
                                           value="{{ $c }}">

                                    <div class="w-12 h-12 rounded-full shadow-sm transition-transform active:scale-90"
                                         style="background-color: {{ $c }}"
                                         :class="color === '{{ $c }}'
                                             ? 'ring-4 ring-offset-2 ring-blue-500/50 scale-110'
                                             : 'hover:scale-105'">
                                    </div>

                                    <svg x-show="color === '{{ $c }}'"
                                         class="absolute w-6 h-6 text-white pointer-events-none"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </label>
                            @endforeach

                            <div class="relative flex items-center justify-center">
                                <div class="relative w-12 h-12 rounded-full shadow-sm
                                            transition-transform active:scale-90 cursor-pointer
                                            border-2 border-dashed border-gray-300 dark:border-gray-600
                                            overflow-hidden flex items-center justify-center"
                                     :class="color === customColor
                                         ? 'ring-4 ring-offset-2 ring-blue-500/50 scale-110 border-transparent'
                                         : 'hover:scale-105'">

                                    <div class="absolute inset-[2px] rounded-full"
                                         :style="`background-color: ${customColor}`"></div>

                                    <div class="absolute inset-[2px] rounded-full bg-black/10"></div>

                                    <svg class="w-6 h-6 text-white drop-shadow z-10 pointer-events-none"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>

                                    <input type="color"
                                           x-model="customColor"
                                           @input="updateCustom()"
                                           class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                </div>
                            </div>
                        </div>

                        @error('cor')
                            <p class="text-red-500 text-xs mt-2 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 dark:bg-gray-900/80
                            backdrop-blur-md border-t border-gray-100 dark:border-gray-800 z-50">
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold
                                   text-lg py-4 rounded-2xl shadow-xl shadow-blue-600/20
                                   transition transform active:scale-[0.98]
                                   flex items-center justify-center gap-2">
                        <span>Salvar Alterações</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>