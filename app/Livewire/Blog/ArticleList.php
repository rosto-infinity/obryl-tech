<?php

declare(strict_types=1);

namespace App\Livewire\Blog;

use App\Models\Article;
use App\Enums\Blog\ArticleCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ArticleList extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $category = null;
    public string $sort = 'recent';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
        'sort' => ['except' => 'recent'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
        $this->resetPage();
    }

    public function render(): View
    {
        $articles = Article::query()
            ->published()
            ->when($this->search, fn (Builder $q) => $q->search($this->search))
            ->when($this->category, fn (Builder $q) => $q->byCategory($this->category))
            ->when($this->sort === 'recent', fn (Builder $q) => $q->orderBy('published_at', 'desc'))
            ->when($this->sort === 'popular', fn (Builder $q) => $q->orderBy('views_count', 'desc'))
            ->paginate(12);

        $categories = ArticleCategory::cases();

        return view('livewire.blog.article-list', [
            'articles' => $articles,
            'categories' => $categories,
        ])->extends('components.layouts.public')->section('content');
    }
}
