<?php

declare(strict_types=1);

namespace App\Filament\Resources\Commissions\Schemas;

use App\Enums\Commission\CommissionStatus;
use App\Enums\Commission\CommissionType;
use App\Enums\Commission\PaymentMethod;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class CommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('commission_tabs')
                    ->tabs([
                        // ONGLET: INFORMATIONS PRINCIPALES
                        Tabs\Tab::make('Informations Principales')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Informations de la commission')
                                    ->description('Détails principaux de la commission')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->schema([
                                        Select::make('project_id')
                                            ->label('Projet associé')
                                            ->relationship('project', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->helperText('Sélectionnez le projet concerné par cette commission'),

                                        Select::make('developer_id')
                                            ->label('Développeur')
                                            ->relationship('developer', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->helperText('Développeur qui reçoit cette commission'),

                                        Select::make('type')
                                            ->label('Type de commission')
                                            ->options(CommissionType::class)
                                            ->default(CommissionType::PROJECT_COMPLETION->value)
                                            ->required()
                                            ->helperText('Nature de la commission'),
                                    ])
                                    ->columns(2),

                                Section::make('Montant et paiement')
                                    ->description('Informations financières de la commission')
                                    ->icon('heroicon-o-banknotes')
                                    ->schema([
                                        TextInput::make('amount')
                                            ->label('Montant')
                                            ->prefix('FCFA')
                                            ->numeric()
                                            ->required()
                                            ->step(0.01)
                                            ->helperText('Montant de la commission en FCFA'),

                                        TextInput::make('percentage')
                                            ->label('Pourcentage (%)')
                                            ->suffix('%')
                                            ->numeric()

                                            ->step(0.1)
                                            ->helperText('Pourcentage prélevé sur le montant du projet'),

                                        Select::make('currency')
                                            ->label('Devise')
                                            ->options([
                                                'XAF' => 'FCFA - Franc CFA',
                                                'USD' => 'USD - Dollar Américain',
                                                'EUR' => 'EUR - Euro',
                                            ])
                                            ->default('XAF')
                                            ->required()
                                            ->helperText('Devise utilisée pour cette commission'),
                                    ])
                                    ->columns(3),
                            ]),

                        // ONGLET: STATUT ET VALIDATION
                        Tabs\Tab::make('Statut et Validation')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Section::make('État de la commission')
                                    ->description('Statut actuel et progression')
                                    ->icon('heroicon-o-flag')
                                    ->schema([
                                        Select::make('status')
                                            ->label('Statut')
                                            ->options(CommissionStatus::class)
                                            ->default(CommissionStatus::PENDING->value)
                                            ->required()
                                            ->helperText('État actuel de la commission'),

                                        Toggle::make('is_approved')
                                            ->label('Approuvée')
                                            ->default(false)
                                            ->helperText('Cochez si cette commission a été approuvée'),
                                    ])
                                    ->columns(2),

                                Section::make('Validation et paiement')
                                    ->description('Dates et responsables')
                                    ->icon('heroicon-o-calendar')
                                    ->schema([
                                        DateTimePicker::make('approved_at')
                                            ->label('Date d\'approbation')
                                            ->displayFormat('d/m/Y H:i')
                                            ->helperText('Date à laquelle la commission a été approuvée'),

                                        DateTimePicker::make('paid_at')
                                            ->label('Date de paiement')
                                            ->displayFormat('d/m/Y H:i')
                                            ->helperText('Date à laquelle la commission a été payée'),

                                        TextInput::make('approved_by')
                                            ->label('Approuvé par (ID)')
                                            ->numeric()
                                            ->helperText('ID de l\'utilisateur qui a approuvé cette commission'),
                                    ])
                                    ->columns(3),
                            ]),

                        // ONGLET: DÉTAILS SUPPLÉMENTAIRES
                        Tabs\Tab::make('Détails Supplémentaires')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Description et détails')
                                    ->description('Informations complémentaires')
                                    ->icon('heroicon-o-document-text')
                                    ->schema([
                                        Textarea::make('description')
                                            ->label('Description')
                                            ->rows(4)
                                            ->columnSpanFull()
                                            ->helperText('Description détaillée de la commission'),

                                        Textarea::make('breakdown')
                                            ->label('Répartition détaillée')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->helperText('Détail de la répartition des montants si applicable'),
                                    ]),

                                Section::make('Informations de paiement')
                                    ->description('Détails bancaires et méthodes')
                                    ->icon('heroicon-o-credit-card')
                                    ->schema([
                                        Select::make('payment_method')
                                            ->label('Méthode de paiement')
                                            ->options(PaymentMethod::class)
                                            ->helperText('Méthode utilisée pour cette commission'),

                                        Textarea::make('payment_details')
                                            ->label('Détails de paiement')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->helperText('Informations complémentaires sur le paiement (référence, compte bancaire, etc.)'),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
