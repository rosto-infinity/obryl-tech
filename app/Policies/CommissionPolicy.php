<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Commission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommissionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Commission');
    }

    public function view(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('View:Commission');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Commission');
    }

    public function update(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('Update:Commission');
    }

    public function delete(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('Delete:Commission');
    }

    public function restore(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('Restore:Commission');
    }

    public function forceDelete(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('ForceDelete:Commission');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Commission');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Commission');
    }

    public function replicate(AuthUser $authUser, Commission $commission): bool
    {
        return $authUser->can('Replicate:Commission');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Commission');
    }

}