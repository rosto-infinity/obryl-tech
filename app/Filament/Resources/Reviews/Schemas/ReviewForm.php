<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reviews\Schemas;

use App\Enums\ReviewStatus;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de l\'Avis')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('project_id')
                                    ->label('Projet')
                                    ->relationship('project', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Sélectionnez le projet concerné'),

                                Select::make('client_id')
                                    ->label('Client')
                                    ->relationship('client', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Client qui donne l\'avis'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('developer_id')
                                    ->label('Développeur')
                                    ->relationship('developer', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Développeur évalué'),

                                Select::make('rating')
                                    ->label('Note')
                                    ->options([
                                        1 => '⭐ (Très mauvais)',
                                        2 => '⭐⭐ (Mauvais)',
                                        3 => '⭐⭐⭐ (Moyen)',
                                        4 => '⭐⭐⭐⭐ (Bon)',
                                        5 => '⭐⭐⭐⭐⭐ (Excellent)',
                                    ])
                                    ->required()
                                    ->default(5)
                                    ->helperText('Note globale du développeur'),
                            ]),
                    ]),

                Section::make('Critères d\'Évaluation')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('criteria.quality')
                                    ->label('Qualité du code')
                                    ->options([
                                        1 => '1 - Très faible',
                                        2 => '2 - Faible',
                                        3 => '3 - Moyen',
                                        4 => '4 - Bon',
                                        5 => '5 - Excellent',
                                    ])
                                    ->default(3)
                                    ->required(),

                                Select::make('criteria.communication')
                                    ->label('Communication')
                                    ->options([
                                        1 => '1 - Très faible',
                                        2 => '2 - Faible',
                                        3 => '3 - Moyen',
                                        4 => '4 - Bon',
                                        5 => '5 - Excellent',
                                    ])
                                    ->default(3)
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('criteria.deadline')
                                    ->label('Respect des délais')
                                    ->options([
                                        1 => '1 - Jamais',
                                        2 => '2 - Rarement',
                                        3 => '3 - Parfois',
                                        4 => '4 - Souvent',
                                        5 => '5 - Toujours',
                                    ])
                                    ->default(3)
                                    ->required(),

                                Select::make('criteria.professionalism')
                                    ->label('Professionnalisme')
                                    ->options([
                                        1 => '1 - Très faible',
                                        2 => '2 - Faible',
                                        3 => '3 - Moyen',
                                        4 => '4 - Bon',
                                        5 => '5 - Excellent',
                                    ])
                                    ->default(3)
                                    ->required(),
                            ]),
                    ]),

                Section::make('Commentaires')
                    ->schema([
                        Textarea::make('comment')
                            ->label('Commentaire général')
                            ->columnSpanFull()
                            ->rows(4)
                            ->helperText('Décrivez votre expérience avec ce développeur'),

                        Textarea::make('strengths')
                            ->label('Points forts')
                            ->rows(3)
                            ->helperText('Quelles sont les qualités remarquables ?'),

                        Textarea::make('improvements')
                            ->label('Axes d\'amélioration')
                            ->rows(3)
                            ->helperText('Quels aspects pourraient être améliorés ?'),
                    ]),

                Section::make('Statut')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Statut')
                                    ->options(ReviewStatus::getOptions())
                                    ->default(ReviewStatus::APPROVED->value)
                                    ->required()
                                    ->helperText('Statut de validation de l\'avis'),

                                Placeholder::make('created_at')
                                    ->label('Date de création')
                                    ->content(fn ($record) => $record?->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'))
                                    ->hidden(fn ($record) => $record === null),
                            ]),
                    ]),
            ]);
    }
}
