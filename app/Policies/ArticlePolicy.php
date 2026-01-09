<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Article');
    }

    public function view(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('View:Article');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Article');
    }

    public function update(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('Update:Article');
    }

    public function delete(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('Delete:Article');
    }

    public function restore(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('Restore:Article');
    }

    public function forceDelete(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('ForceDelete:Article');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Article');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Article');
    }

    public function replicate(AuthUser $authUser, Article $article): bool
    {
        return $authUser->can('Replicate:Article');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Article');
    }

}