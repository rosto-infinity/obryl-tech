<?php

declare(strict_types=1);

namespace App\Filament\Resources\ExternalDeveloperCommissions;

use App\Filament\Resources\ExternalDeveloperCommissions\Pages\CreateExternalDeveloperCommission;
use App\Filament\Resources\ExternalDeveloperCommissions\Pages\EditExternalDeveloperCommission;
use App\Filament\Resources\ExternalDeveloperCommissions\Pages\ListExternalDeveloperCommissions;
use App\Filament\Resources\ExternalDeveloperCommissions\Schemas\ExternalDeveloperCommissionForm;
use App\Filament\Resources\ExternalDeveloperCommissions\Tables\ExternalDeveloperCommissionsTable;
use App\Models\ExternalDeveloperCommission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ExternalDeveloperCommissionResource extends Resource
{
    protected static ?string $model = ExternalDeveloperCommission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Projets & Commissions';

    protected static ?string $navigationLabel = 'Commissions Externes';

    protected static ?string $pluralLabel = 'Commissions Externes';

    protected static ?string $modelLabel = 'Commission Externe';

    protected static ?string $recordTitleAttribute = 'project_id';

    public static function form(Schema $schema): Schema
    {
        return ExternalDeveloperCommissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExternalDeveloperCommissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExternalDeveloperCommissions::route('/'),
            'create' => CreateExternalDeveloperCommission::route('/create'),
            'edit' => EditExternalDeveloperCommission::route('/{record}/edit'),
        ];
    }
}
