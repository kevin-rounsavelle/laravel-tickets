<?php

use App\Models\User;
use App\Services\RecaptchaService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $recaptchaToken = '';

    public function register(RecaptchaService $recaptcha): void
    {
        $this->resetErrorBag();

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults()
            ],
        ]);

        if (! $recaptcha->verify($this->recaptchaToken, 'register')) {
            $this->addError(
                'email',
                'Security check failed. Please try again.'
            );

            return;
        }

        $validated['password'] = Hash::make(
            $validated['password']
        );

        event(
            new Registered(
                $user = User::create($validated)
            )
        );

        Auth::login($user);

        $this->redirect(
            route('dashboard'),
            navigate: true
        );
    }
};
?>

<div>

    <div class="mb-7">
        <h1 class="text-xl font-bold text-white">
            Create your account
        </h1>
    </div>


    <form
        novalidate
        x-data="{
            submitForm() {

                if (
                    typeof grecaptcha === 'undefined'
                    || !window.recaptchaSiteKey
                ) {
                    $wire.register()
                    return
                }

                grecaptcha.ready(() => {

                    grecaptcha.execute(
                        window.recaptchaSiteKey,
                        { action: 'register' }
                    )
                    .then(token => {

                        $wire.set(
                            'recaptchaToken',
                            token
                        )

                        $wire.register()

                    })

                })

            }
        }"
        @submit.prevent="submitForm"
    >


        <input
            type="hidden"
            wire:model.live="recaptchaToken"
        >


        <!-- Name -->
        <div class="mb-4">

            <label for="name" class="auth-label">
                Full Name
            </label>


            <input
                wire:model.live="name"
                id="name"
                type="text"
                autocomplete="name"
                placeholder="Jane Smith"
                class="auth-input block w-full rounded-lg px-4 py-2.5 text-sm focus:outline-none"
            />


         @error('name')
    <div class="mt-2 rounded-lg border-2 border-red-500 bg-black px-3 py-2 text-sm font-semibold text-white shadow-lg">
        <span class="text-red-400">⚠</span>
        {{ $message }}
    </div>
@enderror

        </div>



        <!-- Email -->
        <div class="mb-4">

            <label for="email" class="auth-label">
                Email Address
            </label>


            <input
                wire:model.live="email"
                id="email"
                type="email"
                autocomplete="username"
                placeholder="you@example.com"
                class="auth-input block w-full rounded-lg px-4 py-2.5 text-sm focus:outline-none"
            />


          @error('email')
    <div class="mt-2 rounded-lg border-2 border-red-500 bg-black px-3 py-2 text-sm font-semibold text-white shadow-lg">
        <span class="text-red-400">⚠</span>
        {{ $message }}
    </div>
@enderror

        </div>



        <!-- Password -->
        <div class="mb-4">

            <label for="password" class="auth-label">
                Password
            </label>


            <input
                wire:model.live="password"
                id="password"
                type="password"
                autocomplete="new-password"
                placeholder="Strong Password Required (min 12 char)"
                class="auth-input block w-full rounded-lg px-4 py-2.5 text-sm focus:outline-none"
            />


        @error('password')
    <div class="mt-2 rounded-lg border-2 border-red-500 bg-black px-3 py-2 text-sm font-semibold text-white shadow-lg">
        <span class="text-red-400">⚠</span>
        {{ $message }}
    </div>
@enderror
        </div>



        <!-- Confirm Password -->
        <div class="mb-5">

            <label for="password_confirmation" class="auth-label">
                Confirm Password
            </label>


            <input
                wire:model.live="password_confirmation"
                id="password_confirmation"
                type="password"
                autocomplete="new-password"
                placeholder="Repeat your password"
                class="auth-input block w-full rounded-lg px-4 py-2.5 text-sm focus:outline-none"
            />


          @error('password_confirmation')
    <div class="mt-2 rounded-lg border-2 border-red-500 bg-black px-3 py-2 text-sm font-semibold text-white shadow-lg">
        <span class="text-red-400">⚠</span>
        {{ $message }}
    </div>
@enderror
        </div>



        <!-- Submit -->
        <button type="submit" class="auth-btn w-full mt-2">

            <span wire:loading.remove wire:target="register">
                Create Account
            </span>


            <span wire:loading wire:target="register" class="flex items-center justify-center gap-2">

                <svg class="animate-spin h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24">

                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4">
                    </circle>

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                    </path>

                </svg>

                Creating account…

            </span>

        </button>

    </form>



    <!-- Divider -->
    <div class="auth-divider my-6" style="padding: 15px 0;">
        or register with
    </div>



    <!-- Social Buttons -->
    <div class="grid grid-cols-2 gap-3">

        <a href="{{ route('social.redirect', 'google') }}" class="social-btn">

            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>

            Google

        </a>



        <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn">

            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="#1877F2">

                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>

            </svg>

            Facebook

        </a>

    </div>



    <p class="auth-footer">

        Already have an account?

        <a href="{{ route('login') }}" class="auth-link font-medium ml-1">

            Sign in

        </a>

    </p>


</div>