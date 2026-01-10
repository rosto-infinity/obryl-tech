<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\WorkloadDashboard;

class WorkloadDashboardWrapper extends WorkloadDashboard
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.workload-dashboard-wrapper');
    }
}
