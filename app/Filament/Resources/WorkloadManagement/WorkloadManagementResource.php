<?php

namespace App\Filament\Resources\WorkloadManagement;

use App\Filament\Resources\WorkloadManagement\Pages\CreateWorkloadManagement;
use App\Filament\Resources\WorkloadManagement\Pages\EditWorkloadManagement;
use App\Filament\Resources\WorkloadManagement\Pages\ListWorkloadManagement;
use App\Filament\Resources\WorkloadManagement\Schemas\WorkloadManagementForm;
use App\Filament\Resources\WorkloadManagement\Tables\WorkloadManagementTable;
use App\Models\WorkloadManagement;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkloadManagementResource extends Resource
{
    protected static ?string $model = WorkloadManagement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Projets & Commissions';

    protected static ?string $navigationLabel = 'Gestion de Charge';

    protected static ?string $pluralLabel = 'Gestion de Charge';

    protected static ?string $modelLabel = 'Charge';

    protected static ?string $recordTitleAttribute = 'developer_id';

    public static function form(Schema $schema): Schema
    {
        return WorkloadManagementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkloadManagementTable::configure($table);
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
            'index' => ListWorkloadManagement::route('/'),
            'create' => CreateWorkloadManagement::route('/create'),
            'edit' => EditWorkloadManagement::route('/{record}/edit'),
        ];
    }
}
