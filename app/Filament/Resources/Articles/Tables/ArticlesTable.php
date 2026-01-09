<?php

namespace App\Filament\Resources\Articles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular(),
                
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn ($record) => $record->slug),
                
                TextColumn::make('author.name')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->sortable(),
                
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->sortable(),
                
                TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('views_count')
                    ->label('Vues')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                
                TextColumn::make('likes_count')
                    ->label('Likes')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                
                TextColumn::make('comments_count')
                    ->label('Comms')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(\App\Enums\Blog\ArticleCategory::class),
                
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options(\App\Enums\Blog\ArticleStatus::class),
                
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
