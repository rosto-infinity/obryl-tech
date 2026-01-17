<?php

declare(strict_types=1);

namespace App\Livewire\Blog;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ArticleDetail extends Component
{
    public Article $article;

    public $similarArticles;

    public string $commentContent = '';

    public bool $hasLiked = false;

    public function mount(Article $article): void
    {
        $this->article = $article;

        // Incrémenter les vues (une fois par session)
        $viewedKey = "article_viewed_{$article->id}";
        if (! Session::has($viewedKey)) {
            $this->article->incrementViews();
            Session::put($viewedKey, true);
        }

        $this->similarArticles = $article->getSimilarArticles(3);
        $this->hasLiked = Session::has("article_liked_{$article->id}");
    }

    public function toggleLike(): void
    {
        if (! auth()->check()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Veuillez vous connecter pour aimer cet article.']);

            return;
        }

        $likedKey = "article_liked_{$this->article->id}";

        if ($this->hasLiked) {
            return;
        }

        $this->article->incrementLikes();
        Session::put($likedKey, true);
        $this->hasLiked = true;

        $this->dispatch('article-liked');
    }

    public function addComment(): void
    {
        if (! auth()->check()) {
            return; // Normalement géré par le bouton/formulaire masqué en UI
        }

        $this->validate([
            'commentContent' => 'required|min:3|max:1000',
        ]);

        $user = auth()->user();

        $comments = $this->article->comments ?? [];
        $comments[] = [
            'id' => uniqid(),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'content' => $this->commentContent,
            'status' => 'approved',
            'created_at' => now()->toDateTimeString(),
        ];

        $this->article->update([
            'comments' => $comments,
            'comments_count' => count($comments),
        ]);

        $this->commentContent = '';

        Session::flash('comment_status', 'Merci pour votre contribution ! Votre commentaire a été publié.');
    }

    public function render(): View
    {
        return view('livewire.blog.article-detail', [
            'author' => $this->article->author,
        ])->extends('components.layouts.public')->section('content');
    }
}
