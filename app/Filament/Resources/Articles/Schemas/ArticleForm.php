<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\Blog\ArticleCategory;
use App\Enums\Blog\ArticleStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->image(),
                Select::make('status')
                    ->options(ArticleStatus::class)
                    ->default('draft')
                    ->required(),
                TextInput::make('tags'),
                Select::make('category')
                    ->options(ArticleCategory::class),
                TextInput::make('seo'),
                DateTimePicker::make('published_at'),
                DateTimePicker::make('scheduled_at'),
                TextInput::make('views_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('likes_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('comments_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('comments'),
            ]);
    }
}
