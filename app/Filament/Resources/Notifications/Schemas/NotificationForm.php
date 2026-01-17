<?php

declare(strict_types=1);

namespace App\Filament\Resources\Notifications\Schemas;

use App\Enums\Notification\NotificationChannel;
use App\Enums\Notification\NotificationType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Destinataire & Canal')
                    ->description('Gérez qui reçoit cette notification et par quel canal.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Utilisateur')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('type')
                                    ->options(NotificationType::class)
                                    ->label('Type de Notification')
                                    ->required(),
                                Select::make('channel')
                                    ->options(NotificationChannel::class)
                                    ->label('Canal d\'envoi')
                                    ->default('in_app')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Contenu de la Notification')
                    ->description('Le message qui sera affiché à l\'utilisateur.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->placeholder('Ex: Nouveau projet assigné')
                            ->required(),
                        Textarea::make('message')
                            ->label('Message détaillé')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('data')
                            ->label('Données additionnelles (JSON)')
                            ->hint('Données techniques liées à la notification')
                            ->placeholder('{"project_id": 1, "url": "/..."}')
                            ->columnSpanFull(),
                    ]),

                Section::make('Statut & Planification')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('sent_at')
                                    ->label('Date d\'envoi')
                                    ->placeholder('Maintenant par défaut'),
                                DateTimePicker::make('read_at')
                                    ->label('Date de lecture')
                                    ->disabled()
                                    ->placeholder('Sera rempli automatiquement'),
                            ]),
                    ]),
            ]);
    }
}
