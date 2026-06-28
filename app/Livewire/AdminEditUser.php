<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AdminEditUser extends Component
{
    public UserForm $form;

    public User $user;

    public int $selectedRole = 1;

    public bool $confirmingDelete = false;

    public function mount(User $user): void
    {
        $this->user = $user->load(['tickets']);
        $this->form->fillFromUser($user);
        $this->selectedRole = $user->role_id->value;
    }

    public function save(): void
    {
        $this->form->update($this->user);

        $this->user->refresh();

        session()->flash('status', 'User details updated successfully.');
    }

    public function changeRole(): void
    {
        if ($this->user->id === auth()->id()) {
            session()->flash('error', 'You cannot change your own role.');
            return;
        }

        $this->validate(['selectedRole' => ['required', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))]]);

        $this->user->update(['role_id' => $this->selectedRole]);
        $this->user->refresh();

        session()->flash('status', "Role updated to {$this->user->role_id->label()}.");
    }

    public function deleteUser(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        if ($this->user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $name = $this->user->name;
        $this->user->delete();

        session()->flash('status', "User {$name} has been deleted.");

        $this->redirectRoute('admin.users', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin-edit-user', [
            'roles' => UserRole::cases(),
        ]);
    }
}
