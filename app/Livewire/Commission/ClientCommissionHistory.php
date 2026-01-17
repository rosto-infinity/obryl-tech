<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Models\Commission;
use Livewire\Component;
use Livewire\WithPagination;

class ClientCommissionHistory extends Component
{
    use WithPagination;

    public $status = '';

    public $dateFrom = '';

    public $dateTo = '';

    public $amountMin = '';

    public $amountMax = '';

    protected $queryString = [
        'status',
        'dateFrom',
        'dateTo',
        'amountMin',
        'amountMax',
    ];

    public function render()
    {
        $user = auth()->user();

        if ($user->user_type === 'developer') {
            // Développeur : voir ses commissions
            $commissions = $user->externalCommissions()
                ->when($this->status, function ($query): void {
                    $query->where('status', $this->status);
                })
                ->when($this->dateFrom, function ($query): void {
                    $query->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query): void {
                    $query->whereDate('created_at', '<=', $this->dateTo);
                })
                ->when($this->amountMin, function ($query): void {
                    $query->where('amount', '>=', $this->amountMin);
                })
                ->when($this->amountMax, function ($query): void {
                    $query->where('amount', '<=', $this->amountMax);
                })
                ->with(['project', 'approver'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Client : voir les commissions de ses projets
            $commissions = Commission::whereHas('project', function ($query) use ($user): void {
                $query->where('client_id', $user->id);
            })
                ->when($this->status, function ($query): void {
                    $query->where('status', $this->status);
                })
                ->when($this->dateFrom, function ($query): void {
                    $query->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query): void {
                    $query->whereDate('created_at', '<=', $this->dateTo);
                })
                ->when($this->amountMin, function ($query): void {
                    $query->where('amount', '>=', $this->amountMin);
                })
                ->when($this->amountMax, function ($query): void {
                    $query->where('amount', '<=', $this->amountMax);
                })
                ->with(['project', 'developer'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.commission.client-commission-history', [
            'commissions' => $commissions,
            'totalAmount' => $this->getTotalAmount(),
            'statusOptions' => $this->getStatusOptions(),
        ]);
    }

    private function getTotalAmount(): float
    {
        $user = auth()->user();

        if ($user->user_type === 'developer') {
            return $user->externalCommissions()
                ->when($this->status, function ($query): void {
                    $query->where('status', $this->status);
                })
                ->when($this->dateFrom, function ($query): void {
                    $query->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query): void {
                    $query->whereDate('created_at', '<=', $this->dateTo);
                })
                ->sum('amount');
        } else {
            return Commission::whereHas('project', function ($query) use ($user): void {
                $query->where('client_id', $user->id);
            })
                ->when($this->status, function ($query): void {
                    $query->where('status', $this->status);
                })
                ->when($this->dateFrom, function ($query): void {
                    $query->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query): void {
                    $query->whereDate('created_at', '<=', $this->dateTo);
                })
                ->sum('amount');
        }
    }

    private function getStatusOptions(): array
    {
        return [
            '' => 'Tous les statuts',
            'pending' => 'En attente',
            'approved' => 'Approuvée',
            'paid' => 'Payée',
            'cancelled' => 'Annulée',
        ];
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedAmountMin(): void
    {
        $this->resetPage();
    }

    public function updatedAmountMax(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['status', 'dateFrom', 'dateTo', 'amountMin', 'amountMax']);
        $this->resetPage();
    }
}
