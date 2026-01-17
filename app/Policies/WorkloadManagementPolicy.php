<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\WorkloadManagement;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class WorkloadManagementPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WorkloadManagement');
    }

    public function view(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('View:WorkloadManagement');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WorkloadManagement');
    }

    public function update(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('Update:WorkloadManagement');
    }

    public function delete(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('Delete:WorkloadManagement');
    }

    public function restore(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('Restore:WorkloadManagement');
    }

    public function forceDelete(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('ForceDelete:WorkloadManagement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WorkloadManagement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WorkloadManagement');
    }

    public function replicate(AuthUser $authUser, WorkloadManagement $workloadManagement): bool
    {
        return $authUser->can('Replicate:WorkloadManagement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WorkloadManagement');
    }
}
