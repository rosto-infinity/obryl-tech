<?php

namespace App\Filament\Resources\WorkloadManagement\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkloadManagementTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('developer.name')
                    ->searchable(),
                TextColumn::make('current_projects_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_projects_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('availability_status')
                    ->badge(),
                TextColumn::make('workload_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
