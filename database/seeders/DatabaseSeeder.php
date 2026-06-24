<?php

namespace Database\Seeders;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Support Admin',
            'email' => 'admin@support.local',
            'password' => Hash::make('Password123#'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $agent = User::factory()->create([
            'name' => 'Agent Smith',
            'email' => 'agent@support.local',
            'password' => Hash::make('Password123#'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $customers = User::factory(5)->create([
            'password' => Hash::make('Password123#'),
            'email_verified_at' => now(),
        ]);

        $customers->each(function (User $customer) use ($admin, $agent) {
            $tickets = Ticket::factory(rand(2, 4))->create([
                'user_id' => $customer->id,
                'assigned_to' => fake()->boolean(60) ? fake()->randomElement([$admin->id, $agent->id]) : null,
            ]);

            $tickets->each(function (Ticket $ticket) use ($admin, $agent, $customer) {
                TicketReply::factory(rand(1, 3))->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => fake()->randomElement([$customer->id, $admin->id, $agent->id]),
                    'via' => fake()->randomElement(['web', 'email']),
                ]);
            });
        });

        Ticket::factory()->create([
            'user_id' => $customers->first()->id,
            'title' => 'Cannot reset my password',
            'description' => "I've tried resetting my password three times but never receive the email. Can you help?",
            'status' => TicketStatus::Open,
            'assigned_to' => null,
        ]);

        Ticket::factory()->create([
            'user_id' => $customers->skip(1)->first()->id,
            'title' => 'Billing charge appears twice',
            'description' => 'My last invoice shows a duplicate charge for the Pro plan subscription.',
            'status' => TicketStatus::InProcess,
            'assigned_to' => $admin->id,
        ]);

        Ticket::factory()->create([
            'user_id' => $customers->skip(2)->first()->id,
            'title' => 'Feature request: dark mode',
            'description' => 'Would love a dark mode option in the dashboard settings.',
            'status' => TicketStatus::Assigned,
            'assigned_to' => $agent->id,
        ]);

        Ticket::factory()->create([
            'user_id' => $customers->skip(3)->first()->id,
            'title' => 'Upload error on mobile',
            'description' => 'When uploading screenshots from my phone the page times out.',
            'status' => TicketStatus::Completed,
            'assigned_to' => $admin->id,
        ]);

        Ticket::factory()->create([
            'user_id' => $customers->last()->id,
            'title' => 'Account closure request',
            'description' => 'Please close my account and confirm when complete.',
            'status' => TicketStatus::Closed,
            'assigned_to' => $agent->id,
        ]);
    }
}
