<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ExternalDeveloperCommission;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ExternalDeveloperCommissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ExternalDeveloperCommission');
    }

    public function view(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('View:ExternalDeveloperCommission');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ExternalDeveloperCommission');
    }

    public function update(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('Update:ExternalDeveloperCommission');
    }

    public function delete(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('Delete:ExternalDeveloperCommission');
    }

    public function restore(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('Restore:ExternalDeveloperCommission');
    }

    public function forceDelete(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('ForceDelete:ExternalDeveloperCommission');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ExternalDeveloperCommission');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ExternalDeveloperCommission');
    }

    public function replicate(AuthUser $authUser, ExternalDeveloperCommission $externalDeveloperCommission): bool
    {
        return $authUser->can('Replicate:ExternalDeveloperCommission');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ExternalDeveloperCommission');
    }
}
