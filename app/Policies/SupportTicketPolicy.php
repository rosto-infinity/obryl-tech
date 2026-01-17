<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SupportTicket;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SupportTicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SupportTicket');
    }

    public function view(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('View:SupportTicket');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SupportTicket');
    }

    public function update(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('Update:SupportTicket');
    }

    public function delete(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('Delete:SupportTicket');
    }

    public function restore(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('Restore:SupportTicket');
    }

    public function forceDelete(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('ForceDelete:SupportTicket');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SupportTicket');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SupportTicket');
    }

    public function replicate(AuthUser $authUser, SupportTicket $supportTicket): bool
    {
        return $authUser->can('Replicate:SupportTicket');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SupportTicket');
    }
}
