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
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <div class="brand-dot group-hover:scale-110 transition-transform"></div>
                <span class="text-2xl font-bold tracking-tight text-white">
                    Support<span class="text-indigo-400">Desk</span>
                </span>
            </a>
            <p class="mt-2 text-slate-500 text-sm">Customer support, simplified.</p>
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
