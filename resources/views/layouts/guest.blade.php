<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SupportDesk') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @if(config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
    <script>window.recaptchaSiteKey = "{{ config('services.recaptcha.site_key') }}";</script>
    @endif
</head>
<body class="auth-bg min-h-screen antialiased">

    <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-10">

        <!-- Brand -->
        <div class="mb-8 flex flex-col items-center text-center">
            <a href="{{ url('/') }}" class="flex flex-col items-center gap-3 group">
                <span class="inline-flex items-center justify-center p-2 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 text-white shadow-md shadow-indigo-900/30 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                <span class="text-2xl font-bold tracking-tight text-white">{{ config('app.name', 'Support Tickets') }}</span>
            </a>
        </div>

        <!-- Card -->
        <div class="auth-card auth-card-wrap rounded-2xl px-8 py-8">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-8 text-xs text-slate-600">
            &copy; {{ date('Y') }} SupportDesk. All rights reserved.
        </p>
    </div>

</body>
</html>
