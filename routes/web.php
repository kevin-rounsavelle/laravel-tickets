<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\InboundEmailController;
use App\Http\Controllers\TicketAttachmentController;
use App\Livewire\AdminCreateUser;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminEditUser;
use App\Livewire\AdminTicketShow;
use App\Livewire\AdminUsers;
use App\Livewire\CreateTicket;
use App\Livewire\PublicTicketView;
use App\Livewire\ShowTicket;
use App\Livewire\UserDashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('tickets/view/{token}', PublicTicketView::class)->name('tickets.public');

Route::post('webhooks/inbound-email', InboundEmailController::class)
    ->name('webhooks.inbound-email');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', UserDashboard::class)->name('dashboard');

    Route::get('tickets/create', CreateTicket::class)->name('tickets.create');
    Route::get('tickets/{ticket}', ShowTicket::class)->name('tickets.show');
    Route::get('tickets/{ticket}/attachments/{attachment}', [TicketAttachmentController::class, 'download'])
        ->name('tickets.attachments.download');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('tickets', AdminDashboard::class)->name('dashboard');
        Route::get('tickets/{ticket}', AdminTicketShow::class)->name('tickets.show');

        Route::get('users', AdminUsers::class)->name('users');
        Route::get('users/create', AdminCreateUser::class)->name('users.create');
        Route::get('users/{user}/edit', AdminEditUser::class)->name('users.edit');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
