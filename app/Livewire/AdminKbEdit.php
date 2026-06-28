<?php

namespace App\Livewire;

use App\Livewire\Forms\KbArticleForm;
use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AdminKbEdit extends Component
{
    public KbArticleForm $form;
    public KbArticle $article;

    public function mount(KbArticle $article): void
    {
        $this->article = $article;
        $this->form->fillFromArticle($article);
    }

    public function save(): void
    {
        $this->form->update($this->article);

        $this->article->refresh();

        session()->flash('status', "Article '{$this->article->title}' updated successfully.");

        $this->redirectRoute('admin.kb.index', navigate: true);
    }

    public function deleteArticle(): void
    {
        $title = $this->article->title;
        $this->article->delete();

        session()->flash('status', "Article '{$title}' has been deleted.");

        $this->redirectRoute('admin.kb.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin-kb-edit', [
            'categories' => KbCategory::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
