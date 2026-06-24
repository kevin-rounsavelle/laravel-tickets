<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if(config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
        <script>window.recaptchaSiteKey = "{{ config('services.recaptcha.site_key') }}";</script>
        @endif
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen bg-[#f8fafc] relative overflow-hidden flex flex-col justify-between">
 <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-[-20%] left-[-10%] w-[60vw] h-[60vw] rounded-full bg-gradient-to-tr from-indigo-900/40 to-violet-800/30 blur-3xl opacity-60"></div>

    <div class="absolute top-[40%] right-[-15%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-br from-indigo-950/50 to-purple-900/30 blur-3xl opacity-50"></div>
</div>
            
            <div class="relative z-10 flex-1">
                <!-- Simple Header -->
                <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center p-2 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 text-white shadow-md shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-900 to-indigo-950 bg-clip-text text-transparent">{{ config('app.name') }}</span>
                        </div>
                        <div>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition-colors">
                                    Go to Dashboard
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1.5 transition-colors">
                                    Sign In
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                </header>

                <main class="py-8">
                    {{ $slot }}
                </main>
            </div>
            
            <footer class="relative z-10 border-t border-slate-200/50 bg-white/40 py-6 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </footer>
        </div>
    </body>
</html>
