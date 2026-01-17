<?php

declare(strict_types=1);

namespace App\Filament\Resources\SupportTickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SupportTicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('assigned_to')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('project.title')
                    ->label('Project')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('priority')
                    ->badge(),
                TextEntry::make('category')
                    ->badge(),
                TextEntry::make('severity')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('resolved_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
