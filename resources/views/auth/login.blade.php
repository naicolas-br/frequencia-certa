<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - {{ config('app.name', 'Frequência') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-black text-gray-900 dark:text-white min-h-screen flex items-center justify-center relative overflow-hidden font-sans selection:bg-blue-500 selection:text-white">

        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob dark:bg-blue-900/20"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000 dark:bg-purple-900/20"></div>
            <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-emerald-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000 dark:bg-emerald-900/20"></div>
        </div>

        <div class="absolute top-6 right-6 z-50">
            <button type="button" x-data @click="localStorage.theme === 'dark' ? (localStorage.theme='light', document.documentElement.classList.remove('dark')) : (localStorage.theme='dark', document.documentElement.classList.add('dark'))" class="p-3 text-gray-600 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md rounded-full hover:bg-white dark:hover:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-800 transition-all hover:scale-110 active:scale-95 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 outline-none">
                <svg class="w-6 h-6 hidden dark:block text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg class="w-6 h-6 block dark:hidden text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>
        </div>

        <main class="relative z-10 w-full max-w-[400px] px-4">
            <div class="bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-gray-800 p-8 sm:p-10 relative overflow-hidden transition-all duration-500">
                
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30 mb-5 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Bem-vindo de volta</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Acesse sua conta para continuar.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 animate-fade-in-down">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-medium">{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false, showPassword: false }" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2 ml-1">Email</label>
                        <input id="email" 
                               class="w-full text-base font-medium bg-white/50 dark:bg-black/20 border border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-4 placeholder-gray-400 dark:text-white transition-all duration-300 shadow-sm focus:scale-[1.01] focus:bg-white dark:focus:bg-black/40 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" 
                               type="email" 
                               name="email" 
                               :value="old('email')" 
                               required autofocus autocomplete="username" 
                               placeholder="seu@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 ml-1 animate-pulse" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2 ml-1">Senha</label>
                        <div class="relative">
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'"
                                   class="w-full text-base font-medium bg-white/50 dark:bg-black/20 border border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-4 pr-12 placeholder-gray-400 dark:text-white transition-all duration-300 shadow-sm focus:scale-[1.01] focus:bg-white dark:focus:bg-black/40 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror"
                                   type="password" 
                                   name="password" 
                                   required autocomplete="current-password" 
                                   placeholder="••••••••" />
                            
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.517-2.925m2.766-2.541A9.996 9.996 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-1.127 2.18m-4.545 3.328A3 3 0 0112 15a3 3 0 01-3-3 3 3 0 01.373-1.46m-1.795-3.076A3.385 3.385 0 0112 9a3.385 3.385 0 012.352 1.056m-5.322-2.31L17.5 17.5"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 ml-1 animate-pulse" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="flex items-center cursor-pointer group select-none py-2 -my-2 pr-2">
                            <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer transition-transform checked:scale-110" name="remember">
                            <span class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Lembrar de mim</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition underline underline-offset-4 decoration-blue-300/50 p-2 -mr-2" href="{{ route('password.request') }}">
                                Esqueceu?
                            </a>
                        @endif
                    </div>

                    <button type="submit" :disabled="loading" class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-70 disabled:cursor-not-allowed text-white font-bold text-lg py-4 rounded-2xl shadow-xl shadow-blue-600/30 transition-all duration-200 transform active:scale-[0.98] hover:shadow-2xl flex items-center justify-center gap-2 mt-4 outline-none focus:ring-4 focus:ring-blue-600/30">
                        <span x-show="!loading" class="flex items-center gap-2">
                            Entrar
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Entrando...
                        </span>
                    </button>
                </form>

                <div class="mt-8 text-center pt-6 border-t border-gray-200/60 dark:border-gray-800">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline p-2">
                            Cadastre-se
                        </a>
                    </p>
                </div>

            </div>
        </main>
    </body>
</html>