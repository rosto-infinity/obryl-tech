<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Enums\Commission\CommissionStatus;
use App\Models\Commission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CommissionHistory extends Component
{
    use WithPagination;

    public string $periodFilter = 'all';

    public string $statusFilter = 'all';

    public string $typeFilter = 'all';

    public string $search = '';

    public int $perPage = 10;

    /**
     * Get commissions for history.
     */
    public function getCommissionsProperty(): LengthAwarePaginator
    {
        $query = Commission::query()
            ->with(['project.client', 'developer.profile', 'approvedBy'])
            ->when($this->periodFilter !== 'all', function ($q): void {
                match ($this->periodFilter) {
                    'today' => $q->whereDate('created_at', today()),
                    'week' => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $q->whereMonth('created_at', now()->month),
                    'year' => $q->whereYear('created_at', now()->year),
                    default => $q,
                };
            })
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->typeFilter !== 'all', fn ($q) => $q->where('type', $this->typeFilter))
            ->when($this->search, fn ($q) => $q->where('description', 'like', '%'.$this->search.'%'))
            ->orderByDesc('created_at');

        return $query->paginate($this->perPage);
    }

    /**
     * Get statistics.
     */
    public function getStatsProperty(): array
    {
        $query = Commission::query();

        return [
            'total' => $query->count(),
            'paid' => $query->where('status', CommissionStatus::PAID->value)->count(),
            'pending' => $query->where('status', CommissionStatus::PENDING->value)->count(),
            'total_amount' => $query->where('status', CommissionStatus::PAID->value)->sum('amount'),
        ];
    }

    /**
     * Approve a commission.
     */
    public function approveCommission(int $commissionId): void
    {
        $commission = Commission::findOrFail($commissionId);

        if (Auth::user()->can('approve', $commission)) {
            $commission->update([
                'status' => CommissionStatus::APPROVED->value,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            $this->dispatch('commissionApproved', commissionId: $commissionId);
        }
    }

    /**
     * Mark commission as paid.
     */
    public function markAsPaid(int $commissionId): void
    {
        $commission = Commission::findOrFail($commissionId);

        if (Auth::user()->can('pay', $commission)) {
            $commission->update([
                'status' => CommissionStatus::PAID->value,
                'paid_at' => now(),
            ]);

            $this->dispatch('commissionPaid', commissionId: $commissionId);
        }
    }

    /**
     * Reset pagination when filters change.
     */
    public function updatedPeriodFilter(): void
    {
        $this->resetPage();
    }

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

    public function render(): View
    {
        return view('livewire.commission.commission-history', [
            'stats' => $this->stats,
            'commissions' => $this->commissions,
        ]);
    }
}
