<?php

declare(strict_types=1);

namespace App\Filament\Resources\ExternalDeveloperCommissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExternalDeveloperCommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label('Projet')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Le projet est obligatoire.',
                    ]),
                Select::make('external_developer_id')
                    ->label('Développeur externe')
                    ->relationship('externalDeveloper', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Le développeur externe est obligatoire.',
                    ]),
                TextInput::make('amount')
                    ->label('Montant')
                    ->numeric()
                    ->prefix('XAF')
                    ->minValue(0)
                    ->step(0.01)
                    ->required()
                    ->validationMessages([
                        'required' => 'Le montant est obligatoire.',
                        'numeric' => 'Le montant doit être une valeur numérique.',
                        'min_value' => 'Le montant ne peut pas être négatif.',
                    ]),
                TextInput::make('currency')
                    ->label('Devise')
                    ->default('XAF')
                    ->maxLength(10)
                    ->required()
                    ->validationMessages([
                        'required' => 'La devise est obligatoire.',
                        'max_length' => 'La devise ne peut pas dépasser 10 caractères.',
                    ]),
                TextInput::make('commission_rate')
                    ->label('Taux de commission (%)')
                    ->numeric()
                    ->default(10.0)
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1)
                    ->suffix('%')
                    ->required()
                    ->validationMessages([
                        'required' => 'Le taux de commission est obligatoire.',
                        'numeric' => 'Le taux de commission doit être une valeur numérique.',
                        'min_value' => 'Le taux de commission ne peut pas être négatif.',
                        'max_value' => 'Le taux de commission ne peut pas dépasser 100%.',
                    ]),
                Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'approved' => 'Approuvée',
                        'paid' => 'Payée',
                        'cancelled' => 'Annulée',
                    ])
                    ->default('pending')
                    ->required()
                    ->validationMessages([
                        'required' => 'Le statut est obligatoire.',
                    ]),
                Select::make('payment_method')
                    ->label('Méthode de paiement')
                    ->options([
                        'bank_transfer' => 'Virement bancaire',
                        'mobile_money' => 'Mobile money',
                        'crypto' => 'Cryptomonnaie',
                        'wallet' => 'Portefeuille électronique',
                    ])
                    ->required()
                    ->validationMessages([
                        'required' => 'La méthode de paiement est obligatoire.',
                    ]),
                TextInput::make('payment_details')
                    ->label('Détails de paiement')
                    ->placeholder('Numéro de compte, adresse de portefeuille, etc.')
                    ->validationMessages([
                        'max' => 'Les détails de paiement ne peuvent pas dépasser 255 caractères.',
                    ]),
                DateTimePicker::make('work_delivered_at')
                    ->label('Date de livraison du travail')
                    ->validationMessages([
                        'date' => 'La date de livraison doit être une date valide.',
                    ]),
                DateTimePicker::make('approved_at')
                    ->label('Date d\'approbation')
                    ->validationMessages([
                        'date' => 'La date d\'approbation doit être une date valide.',
                    ]),
                DateTimePicker::make('paid_at')
                    ->label('Date de paiement')
                    ->validationMessages([
                        'date' => 'La date de paiement doit être une date valide.',
                    ]),
                TextInput::make('approved_by')
                    ->label('Approuvé par (ID)')
                    ->numeric()
                    ->validationMessages([
                        'numeric' => 'L\'ID de l\'approbateur doit être une valeur numérique.',
                    ]),
            ]);
    }
}
