<?php

namespace App\Livewire;

use App\Livewire\Forms\KbArticleForm;
use App\Models\KbCategory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AdminKbCreate extends Component
{
    public KbArticleForm $form;

    public function save(): void
    {
        $article = $this->form->store();

        session()->flash('status', "Article '{$article->title}' created successfully.");

        $this->redirectRoute('admin.kb.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin-kb-create', [
            'categories' => KbCategory::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
