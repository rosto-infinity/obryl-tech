<?php

namespace App\Filament\Resources\WorkloadManagement\Pages;

use App\Filament\Resources\WorkloadManagement\WorkloadManagementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkloadManagement extends ListRecords
{
    protected static string $resource = WorkloadManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
