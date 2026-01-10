<?php

namespace App\Filament\Resources\WorkloadManagement\Pages;

use App\Filament\Resources\WorkloadManagement\WorkloadManagementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkloadManagement extends EditRecord
{
    protected static string $resource = WorkloadManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
