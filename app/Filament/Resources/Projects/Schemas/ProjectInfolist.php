<?php

declare(strict_types=1);

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('slug'),
                TextEntry::make('client.name')
                    ->label('Client'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('priority')
                    ->badge(),
                TextEntry::make('budget')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('final_cost')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('currency'),
                TextEntry::make('deadline')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('started_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('progress_percentage')
                    ->numeric(),
                IconEntry::make('is_published')
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('likes_count')
                    ->numeric(),
                TextEntry::make('views_count')
                    ->numeric(),
                TextEntry::make('reviews_count')
                    ->numeric(),
                TextEntry::make('average_rating')
                    ->numeric(),
                TextEntry::make('admin_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cancellation_reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Project $record): bool => $record->trashed()),
            ]);
    }
}
