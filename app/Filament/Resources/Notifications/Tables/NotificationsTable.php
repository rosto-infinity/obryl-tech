<?php

declare(strict_types=1);

namespace App\Filament\Resources\Notifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->label('Titre'),
                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary',
                        'success' => 'commission_paid',
                        'warning' => 'project_assigned',
                    ])
                    ->formatStateUsing(fn ($state): string => $state instanceof \App\Enums\Notification\NotificationType ? $state->label() : (string) $state),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Utilisateur'),
                \Filament\Tables\Columns\IconColumn::make('read_at')
                    ->boolean()
                    ->label('Lu')
                    ->getStateUsing(fn ($record) => $record->read_at !== null),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Date'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
