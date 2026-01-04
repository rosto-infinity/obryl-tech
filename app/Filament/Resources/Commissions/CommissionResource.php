<?php

namespace App\Filament\Resources\Commissions;

use App\Filament\Resources\Commissions\Pages\CreateCommission;
use App\Filament\Resources\Commissions\Pages\EditCommission;
use App\Filament\Resources\Commissions\Pages\ListCommissions;
use App\Filament\Resources\Commissions\Pages\ViewCommission;
use App\Filament\Resources\Commissions\Schemas\CommissionForm;
use App\Filament\Resources\Commissions\Schemas\CommissionInfolist;
use App\Filament\Resources\Commissions\Tables\CommissionsTable;
use App\Models\Commission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'project_id';

    public static function form(Schema $schema): Schema
    {
        return CommissionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CommissionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommissionsTable::configure($table);
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
            'index' => ListCommissions::route('/'),
            'create' => CreateCommission::route('/create'),
            'view' => ViewCommission::route('/{record}'),
            'edit' => EditCommission::route('/{record}/edit'),
        ];
    }

    // Protection des permissions
    public static function canViewAny(): bool
    {
        return auth()->user()->can('viewAnyCommission');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('createCommission');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('updateCommission', $record);
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('deleteCommission', $record);
    }

    public static function canRestoreAny(): bool
    {
        return auth()->user()->can('restoreAnyCommission');
    }

    public static function canForceDeleteAny(): bool
    {
        return auth()->user()->can('forceDeleteAnyCommission');
    }
}
