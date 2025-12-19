<x-app-layout>
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob dark:bg-blue-900/20"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000 dark:bg-purple-900/20"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-emerald-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000 dark:bg-emerald-900/20"></div>
    </div>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-white/50 dark:hover:bg-gray-800/50 transition lg:hidden">
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                Meu Perfil
            </h2>
        </div>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex items-center gap-5 p-6 rounded-3xl bg-white/60 dark:bg-gray-900/60 backdrop-blur-xl border border-white/20 dark:border-gray-800 shadow-sm">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-500/20">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 font-medium">Aluno Matriculado</p>
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white/70 dark:bg-gray-900/70 backdrop-blur-md shadow-sm rounded-[2rem] border border-white/20 dark:border-gray-800">
                <section>
                    <header class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Informações Pessoais
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Atualize seu nome e email de contato.
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nome Completo</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-black/20 dark:text-white focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition-all"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" 
                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-black/20 dark:text-white focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition-all"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition transform active:scale-95 text-sm">
                                Salvar Alterações
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Salvo!
                                </p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <div class="p-6 sm:p-8 bg-white/70 dark:bg-gray-900/70 backdrop-blur-md shadow-sm rounded-[2rem] border border-white/20 dark:border-gray-800">
                <section>
                    <header class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Segurança
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Certifique-se de usar uma senha longa e segura.
                        </p>
                    </header>

                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Senha Atual</label>
                            <input type="password" name="current_password" autocomplete="current-password" 
                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-black/20 dark:text-white focus:border-blue-500 focus:ring-blue-500 py-3 px-4"
                            >
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nova Senha</label>
                                <input type="password" name="password" autocomplete="new-password" 
                                    class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-black/20 dark:text-white focus:border-blue-500 focus:ring-blue-500 py-3 px-4"
                                >
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Confirmar Senha</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password" 
                                    class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-black/20 dark:text-white focus:border-blue-500 focus:ring-blue-500 py-3 px-4"
                                >
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit" class="px-6 py-3 bg-gray-800 dark:bg-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-gray-200 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95 text-sm">
                                Atualizar Senha
                            </button>

                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Senha alterada!
                                </p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <div class="p-6 sm:p-8 bg-red-50/50 dark:bg-red-900/10 backdrop-blur-md shadow-sm rounded-[2rem] border border-red-100 dark:border-red-900/30">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-bold text-red-600 dark:text-red-400">
                            Deletar Conta
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Uma vez deletada, todos os seus dados (presenças, matérias) serão perdidos permanentemente.
                        </p>
                    </header>

                    <button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transition transform active:scale-95 text-sm"
                    >
                        Deletar Minha Conta
                    </button>

                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 dark:bg-gray-900">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                Tem certeza que deseja sair?
                            </h2>

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Digite sua senha para confirmar a exclusão definitiva da conta.
                            </p>

                            <div class="mt-6">
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" placeholder="Sua senha" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white py-3 px-4 focus:ring-red-500 focus:border-red-500" />
                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-bold hover:bg-gray-200 transition">
                                    Cancelar
                                </button>

                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 shadow-lg shadow-red-500/30 transition">
                                    Deletar Conta
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>