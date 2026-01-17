<?php

declare(strict_types=1);

namespace App\Filament\Resources\ExternalDeveloperCommissions\Pages;

use App\Filament\Resources\ExternalDeveloperCommissions\ExternalDeveloperCommissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExternalDeveloperCommission extends CreateRecord
{
    protected static string $resource = ExternalDeveloperCommissionResource::class;
}
