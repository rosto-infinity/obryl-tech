<?php

namespace App\Filament\Resources\ExternalDeveloperCommissions\Pages;

use App\Filament\Resources\ExternalDeveloperCommissions\ExternalDeveloperCommissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExternalDeveloperCommissions extends ListRecords
{
    protected static string $resource = ExternalDeveloperCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
