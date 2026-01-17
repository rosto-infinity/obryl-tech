<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ArticleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('author.name')
                    ->label('Author'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('excerpt')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('content')
                    ->columnSpanFull(),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('category')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('scheduled_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('views_count')
                    ->numeric(),
                TextEntry::make('likes_count')
                    ->numeric(),
                TextEntry::make('comments_count')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Article $record): bool => $record->trashed()),
            ]);
    }
}
