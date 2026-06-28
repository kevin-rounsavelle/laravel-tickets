<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'provider', 'provider_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role_id'           => UserRole::class,
        ];
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function ticketReplies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === UserRole::Admin;
    }

    public function isAgent(): bool
    {
        return $this->role_id === UserRole::Agent;
    }

    public function isStaff(): bool
    {
        return in_array($this->role_id, [UserRole::Agent, UserRole::Admin]);
    }

    /**
     * Prevent password reset emails from being sent
     * to social-provider accounts.
     */
    public function sendPasswordResetNotification($token): void
    {
        if (!empty($this->provider)) {
            return;
        }

        $this->notify(new ResetPassword($token));
    }
}