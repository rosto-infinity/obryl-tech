<?php

declare(strict_types=1);

namespace App\Filament\Resources\ExternalDeveloperCommissions\Pages;

use App\Filament\Resources\ExternalDeveloperCommissions\ExternalDeveloperCommissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExternalDeveloperCommission extends EditRecord
{
    protected static string $resource = ExternalDeveloperCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
