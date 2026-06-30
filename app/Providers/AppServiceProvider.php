<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load AI credentials as global variables
        $GLOBALS['AI_PROVIDER'] = env('AI_PROVIDER');
        $GLOBALS['AI_PROVIDER_API_KEY'] = env('AI_PROVIDER_API_KEY');
        $GLOBALS['AI_PROVIDER_ACCOUNT_ID'] = env('AI_PROVIDER_ACCOUNT_ID');
        $GLOBALS['OPENAI_API_KEY'] = env('OPENAI_API_KEY');

        // Dynamically include custom AI response files if they exist
        $ticketPath = app_path('Includes/ai_ticket_response.php');
        if (file_exists($ticketPath)) {
            include_once $ticketPath;
        }

        $kbPath = app_path('Includes/ai_kb_article_content.php');
        if (file_exists($kbPath)) {
            include_once $kbPath;
        }

        Password::defaults(function () {
            return Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });
    }
}