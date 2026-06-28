<footer class="border-t border-slate-200/60 dark:border-white/5 bg-white/40 dark:bg-transparent py-8 text-xs text-slate-500 dark:text-slate-400 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'SupportDesk') }}. All rights reserved.</p>
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="hover:underline hover:text-slate-800 dark:hover:text-white transition-colors">Home</a>
            <a href="{{ route('kb.index') }}" wire:navigate class="hover:underline hover:text-slate-800 dark:hover:text-white transition-colors font-medium">Knowledge Base</a>
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate class="hover:underline hover:text-slate-800 dark:hover:text-white transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hover:underline hover:text-slate-800 dark:hover:text-white transition-colors">Sign In</a>
            @endauth
        </div>
    </div>
</footer>
