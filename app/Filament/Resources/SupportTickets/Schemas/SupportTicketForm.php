<?php

declare(strict_types=1);

namespace App\Filament\Resources\SupportTickets\Schemas;

use App\Enums\Support\TicketCategory;
use App\Enums\Support\TicketPriority;
use App\Enums\Support\TicketSeverity;
use App\Enums\Support\TicketStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupportTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Demandeur & Projet')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Client / Utilisateur')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('project_id')
                                    ->relationship('project', 'title')
                                    ->label('Projet concerné')
                                    ->searchable()
                                    ->preload()
                                    ->hint('Optionnel si le ticket n\'est pas lié à un projet spécifique'),
                            ]),
                    ]),

                Section::make('Détails du Ticket')
                    ->schema([
                        TextInput::make('title')
                            ->label('Sujet du ticket')
                            ->placeholder('Ex: Problème d\'accès au dashboard')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description détaillée')
                            ->placeholder('Décrivez le problème le plus précisément possible...')
                            ->rows(5)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Statut & Urgence')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Select::make('status')
                                    ->options(TicketStatus::class)
                                    ->label('Statut')
                                    ->default('open')
                                    ->required(),
                                Select::make('priority')
                                    ->options(TicketPriority::class)
                                    ->label('Priorité')
                                    ->default('medium')
                                    ->required(),
                                Select::make('category')
                                    ->options(TicketCategory::class)
                                    ->label('Catégorie')
                                    ->default('general')
                                    ->required(),
                                Select::make('severity')
                                    ->options(TicketSeverity::class)
                                    ->label('Gravité')
                                    ->default('minor')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Assignation & Résolution')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('assigned_to')
                                    ->relationship('assignedTo', 'name')
                                    ->label('Assigné à (Admin/Support)')
                                    ->searchable()
                                    ->preload()
                                    ->hint('Laissez vide pour une assignation automatique'),
                                DateTimePicker::make('resolved_at')
                                    ->label('Date de résolution')
                                    ->disabled()
                                    ->placeholder('Date à laquelle le ticket a été clos'),
                            ]),
                    ]),
            ]);
    }
}
