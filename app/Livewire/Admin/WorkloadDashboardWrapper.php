<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

class WorkloadDashboardWrapper extends WorkloadDashboard
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.workload-dashboard-wrapper');
    }
}
