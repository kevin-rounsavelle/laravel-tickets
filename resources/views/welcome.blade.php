<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark bg-[#090d16]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#090d16">
        <title>{{ config('app.name', 'Support Ticketing') }} | Customer Support, Simplified</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-[#090d16] text-slate-100 overflow-x-hidden selection:bg-indigo-500 selection:text-white">
        <!-- Background Glows -->
       <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-[-20%] left-[-10%] w-[60vw] h-[60vw] rounded-full bg-gradient-to-tr from-indigo-900/40 to-violet-800/30 blur-3xl opacity-60"></div>

    <div class="absolute top-[40%] right-[-15%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-br from-indigo-950/50 to-purple-900/30 blur-3xl opacity-50"></div>
</div>

        <div class="min-h-[100dvh] flex flex-col justify-between relative">
            <!-- Navigation -->
            <header class="border-b border-white/5 bg-[#090d16]/70 backdrop-blur-md sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center p-2 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 text-white shadow-md shadow-indigo-900/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-white">{{ config('app.name', 'Support Tickets') }}</span>
                    </div>

                    <nav class="flex items-center gap-2 sm:gap-4 flex-wrap justify-end">
                        <div class="w-full sm:w-64 lg:w-80 order-last sm:order-none mt-4 sm:mt-0">
                            <livewire:kb-search-bar />
                        </div>
                        
                        <a href="{{ route('kb.index') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-900/40 hover:bg-indigo-500 transition-all hover:scale-105 active:scale-95">
                            Knowledge Base
                        </a>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">
                                    Sign In
                                </a>
                            @endauth
                        @endif
                    </nav>
                </div>
            </header>

            <!-- Hero Section -->
            <main class="flex-1 flex flex-col justify-center py-20 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-indigo-500/20 bg-indigo-500/10 text-xs font-semibold text-indigo-400">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            Introducing Next-Gen Support Ticketing
                        </div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl max-w-4xl mx-auto leading-tight bg-gradient-to-b from-white to-slate-400 bg-clip-text text-transparent">
                            Customer support, simplified and accelerated
                        </h1>
                        <p class="mt-6 text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                            Submit support tickets instantly, upload screenshots, get real-time email notifications, and reply seamlessly either via email or our secure dashboard.
                        </p>
                        <p class="mt-2 text-base text-slate-500 max-w-2xl mx-auto leading-relaxed font-medium">
                            Plus, empower your customers to find answers instantly with our built-in, search-driven Knowledge Base.
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 px-8 py-4 text-base font-semibold text-white shadow-xl shadow-indigo-900/40 hover:from-indigo-600 hover:to-violet-700 transition-all hover:-translate-y-0.5 active:translate-y-0">
                                Go to My Tickets
                                <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 px-8 py-4 text-base font-semibold text-white shadow-xl shadow-indigo-900/40 hover:from-indigo-600 hover:to-violet-700 transition-all hover:-translate-y-0.5 active:translate-y-0">
                                Create Free Account
                                <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm px-8 py-4 text-base font-semibold text-slate-200 hover:bg-white/10 hover:text-white transition-all hover:-translate-y-0.5 active:translate-y-0">
                                Sign In
                            </a>
                        @endauth
                    </div>

                    <!-- App Features grid -->
                    <div class="pt-20 grid gap-8 sm:grid-cols-2 lg:grid-cols-4 max-w-6xl mx-auto text-left">
                        <!-- Feature 1 -->
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] p-6 hover:bg-white/[0.04] transition-colors group">
                            <span class="inline-flex items-center justify-center p-3 rounded-xl bg-indigo-500/10 text-indigo-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-white mb-2">Reply via Email</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">Respond to support agent updates directly from your email client without opening the browser.</p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] p-6 hover:bg-white/[0.04] transition-colors group">
                            <span class="inline-flex items-center justify-center p-3 rounded-xl bg-indigo-500/10 text-indigo-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-white mb-2">File Attachments</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">Post screenshots, PDFs, or system reports with your ticket to help agents resolve issues faster.</p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] p-6 hover:bg-white/[0.04] transition-colors group">
                            <span class="inline-flex items-center justify-center p-3 rounded-xl bg-indigo-500/10 text-indigo-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-white mb-2">Secure Public Links</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">View and update specific tickets securely through generated unique links without full authentication.</p>
                        </div>
                        <!-- Feature 4 -->
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] p-6 hover:bg-white/[0.04] transition-colors group">
                            <span class="inline-flex items-center justify-center p-3 rounded-xl bg-indigo-500/10 text-indigo-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-white mb-2">Admin Dashboard</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">Assign issues, filter by status (In Process, Assigned, Closed, etc.), and manage support queues.</p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @include('layouts.footer', ['theme' => 'dark'])
        </div>
    </body>
</html>
