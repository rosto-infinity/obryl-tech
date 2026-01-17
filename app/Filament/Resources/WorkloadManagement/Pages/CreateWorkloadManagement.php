<?php

declare(strict_types=1);

namespace App\Filament\Resources\WorkloadManagement\Pages;

use App\Filament\Resources\WorkloadManagement\WorkloadManagementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkloadManagement extends CreateRecord
{
    protected static string $resource = WorkloadManagementResource::class;
}
