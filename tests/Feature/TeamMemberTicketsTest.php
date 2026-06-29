<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TeamMemberTicketsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed default roles to database since they are required for foreign key constraints
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\DatabaseSeeder']);
    }

    public function test_admin_can_access_admin_dashboard_and_delete_tickets(): void
    {
        $admin = User::factory()->create(['role_id' => UserRole::Admin->value]);
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/tickets');
        $response->assertOk();

        // Admin can delete ticket via Livewire AdminDashboard
        Livewire::actingAs($admin)
            ->test(\App\Livewire\AdminDashboard::class)
            ->call('deleteTicket', $ticket->id);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    public function test_team_member_cannot_access_admin_dashboard(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);

        $response = $this->actingAs($agent)->get('/admin/tickets');
        $response->assertStatus(403);
    }

    public function test_team_member_can_access_assigned_tickets_dashboard(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->get('/admin/assigned-tickets');
        $response->assertOk()
            ->assertSee($ticket->title);
    }

    public function test_team_member_can_view_and_reply_to_assigned_ticket(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->get("/admin/tickets/{$ticket->id}");
        $response->assertOk();

        // Team member can post reply
        Livewire::actingAs($agent)
            ->test(\App\Livewire\AdminTicketShow::class, ['ticket' => $ticket])
            ->set('body', 'This is a team member reply')
            ->call('reply');

        $this->assertDatabaseHas('ticket_replies', [
            'ticket_id' => $ticket->id,
            'user_id' => $agent->id,
            'body' => 'This is a team member reply',
        ]);
    }

    public function test_team_member_cannot_view_unassigned_or_other_agents_ticket(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $otherAgent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        
        $unassignedTicket = Ticket::factory()->create(['assigned_to' => null]);
        $otherAgentTicket = Ticket::factory()->create(['assigned_to' => $otherAgent->id]);

        $response1 = $this->actingAs($agent)->get("/admin/tickets/{$unassignedTicket->id}");
        $response1->assertStatus(403);

        $response2 = $this->actingAs($agent)->get("/admin/tickets/{$otherAgentTicket->id}");
        $response2->assertStatus(403);
    }

    public function test_team_member_cannot_delete_tickets(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        // Attempting to delete via AdminTicketShow component should abort
        Livewire::actingAs($agent)
            ->test(\App\Livewire\AdminTicketShow::class, ['ticket' => $ticket])
            ->call('deleteTicket')
            ->assertStatus(403);

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);
    }

    public function test_reassignment_redirects_agent_to_dashboard(): void
    {
        $agent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $otherAgent = User::factory()->create(['role_id' => UserRole::Agent->value]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        Livewire::actingAs($agent)
            ->test(\App\Livewire\AdminTicketShow::class, ['ticket' => $ticket])
            ->set('assigned_to', $otherAgent->id)
            ->call('updateStatus')
            ->assertRedirect(route('admin.assigned-tickets'));
    }
}
