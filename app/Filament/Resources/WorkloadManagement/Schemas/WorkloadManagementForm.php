<?php

namespace App\Filament\Resources\WorkloadManagement\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkloadManagementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('developer_id')
                    ->label('Développeur')
                    ->relationship('developer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Le développeur est obligatoire.',
                    ]),
                TextInput::make('current_projects_count')
                    ->label('Nombre de projets actuels')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->validationMessages([
                        'required' => 'Le nombre de projets actuels est obligatoire.',
                        'numeric' => 'Le nombre de projets doit être une valeur numérique.',
                        'min_value' => 'Le nombre de projets ne peut pas être négatif.',
                    ]),
                TextInput::make('max_projects_capacity')
                    ->label('Capacité maximale de projets')
                    ->numeric()
                    ->default(3)
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'La capacité maximale est obligatoire.',
                        'numeric' => 'La capacité maximale doit être une valeur numérique.',
                        'min_value' => 'La capacité maximale doit être d\'au moins 1.',
                    ]),
                Select::make('availability_status')
                    ->label('Statut de disponibilité')
                    ->options([
                        'available' => 'Disponible',
                        'busy' => 'Occupé',
                        'overloaded' => 'Surchargé'
                    ])
                    ->default('available')
                    ->required()
                    ->validationMessages([
                        'required' => 'Le statut de disponibilité est obligatoire.',
                    ]),
                TextInput::make('workload_percentage')
                    ->label('Pourcentage de charge (%)')
                    ->numeric()
                    ->default(0.0)
                    ->minValue(0)
                    ->maxValue(200)
                    ->step(0.1)
                    ->suffix('%')
                    ->validationMessages([
                        'required' => 'Le pourcentage de charge est obligatoire.',
                        'numeric' => 'Le pourcentage de charge doit être une valeur numérique.',
                        'min_value' => 'Le pourcentage de charge ne peut pas être négatif.',
                        'max_value' => 'Le pourcentage de charge ne peut pas dépasser 200%.',
                    ]),
                DateTimePicker::make('last_updated_at')
                    ->label('Dernière mise à jour')
                    ->required()
                    ->validationMessages([
                        'required' => 'La date de dernière mise à jour est obligatoire.',
                    ]),
            ]);
    }
}
