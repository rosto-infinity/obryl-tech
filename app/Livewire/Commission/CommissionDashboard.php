<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Enums\Commission\CommissionStatus;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CommissionDashboard extends Component
{
    use WithPagination;

    public string $statusFilter = 'all';

    public string $typeFilter = 'all';

    public int $developerId = 0;

    public string $search = '';

    public int $perPage = 10;

    /**
     * Reset pagination when filters change.
     */
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Get commission statistics.
     */
    public function getCommissionStatsProperty(): array
    {
        $query = Commission::query();

        if ($this->developerId > 0) {
            $query->where('developer_id', $this->developerId);
        }

        return [
            'total' => $query->count(),
            'pending' => $query->pending()->count(),
            'approved' => $query->approved()->count(),
            'paid' => $query->paid()->count(),
            'total_amount' => $query->where('status', CommissionStatus::PAID->value)->sum('amount'),
        ];
    }

    /**
     * Get filtered commissions.
     */
    public function getCommissionsProperty(): LengthAwarePaginator
    {
        $query = Commission::query()
            ->with(['project.client', 'developer.profile', 'approvedBy'])
            ->when($this->developerId > 0, fn ($q) => $q->where('developer_id', $this->developerId))
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->typeFilter !== 'all', fn ($q) => $q->where('type', $this->typeFilter))
            ->when($this->search, fn ($q) => $q->where('description', 'like', '%'.$this->search.'%'))
            ->orderByDesc('created_at');

        return $query->paginate($this->perPage);
    }

    /**
     * Get developers for filter dropdown.
     */
    public function getDevelopersProperty(): Collection
    {
        return User::query()
            ->where('user_type', 'developer')
            ->with('profile')
            ->orderBy('name')
            ->get();
    }

    /**
     * Approve a commission.
     */
    public function approveCommission(int $commissionId): void
    {
        $commission = Commission::findOrFail($commissionId);

        $this->authorize('approve', $commission);

        $commission->markAsApproved(Auth::id());

        $this->dispatch('commission-approved', commissionId: $commissionId);
    }

    /**
     * Mark commission as paid.
     */
    public function markAsPaid(int $commissionId): void
    {
        $commission = Commission::findOrFail($commissionId);

        $this->authorize('pay', $commission);

        if (! $commission->canBePaid()) {
            $this->addError('payment', 'Cette commission ne peut pas être payée.');

            return;
        }

        $commission->markAsPaid();

        $this->dispatch('commission-paid', commissionId: $commissionId);
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.commission.commission-dashboard', [
            'stats' => $this->commissionStats,
            'commissions' => $this->commissions,
            'developers' => $this->developers,
        ]);
    }
}
