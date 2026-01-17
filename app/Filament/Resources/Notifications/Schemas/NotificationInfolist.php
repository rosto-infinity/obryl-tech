<?php

declare(strict_types=1);

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NotificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('title'),
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('channel')
                    ->badge(),
                TextEntry::make('read_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('sent_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
