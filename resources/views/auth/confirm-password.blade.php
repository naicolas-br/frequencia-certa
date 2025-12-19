<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Confirmar Senha - {{ config('app.name', 'Frequência') }}</title>
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

        <main class="relative z-10 w-full max-w-[400px] px-4">
            <div class="bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-gray-800 p-8 sm:p-10 relative overflow-hidden">
                
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-500 to-orange-500 text-white shadow-lg shadow-orange-500/30 mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Área Segura</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 px-2 leading-relaxed">
                        Esta é uma ação sensível. Por favor, confirme sua senha antes de continuar.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6" x-data="{ showPassword: false }">
                    @csrf

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2 ml-1">Senha</label>
                        <div class="relative">
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'"
                                   class="w-full text-base font-medium bg-white/50 dark:bg-black/20 border border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-4 pr-12 placeholder-gray-400 dark:text-white transition-all duration-300 shadow-sm focus:scale-[1.01] focus:bg-white dark:focus:bg-black/40 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @error('password') border-red-500 @enderror"
                                   name="password" 
                                   required autocomplete="current-password" 
                                   placeholder="Sua senha" />
                            
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.517-2.925m2.766-2.541A9.996 9.996 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-1.127 2.18m-4.545 3.328A3 3 0 0112 15a3 3 0 01-3-3 3 3 0 01.373-1.46m-1.795-3.076A3.385 3.385 0 0112 9a3.385 3.385 0 012.352 1.056m-5.322-2.31L17.5 17.5"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 ml-1 animate-pulse" />
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-2xl shadow-xl shadow-blue-600/30 transition-all duration-200 transform active:scale-[0.98] hover:shadow-2xl flex items-center justify-center gap-2 mt-4">
                        Confirmar
                    </button>
                </form>
            </div>
        </main>
    </body>
</html>