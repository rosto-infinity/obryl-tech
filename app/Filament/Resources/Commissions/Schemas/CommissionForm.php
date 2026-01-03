<?php

namespace App\Filament\Resources\Commissions\Schemas;

use App\Enums\Commission\CommissionStatus;
use App\Enums\Commission\CommissionType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'title')
                    ->required(),
                Select::make('developer_id')
                    ->relationship('developer', 'name')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('XAF'),
                TextInput::make('percentage')
                    ->numeric(),
                Select::make('status')
                    ->options(CommissionStatus::class)
                    ->default('pending')
                    ->required(),
                Select::make('type')
                    ->options(CommissionType::class)
                    ->default('project_completion')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('breakdown'),
                DateTimePicker::make('approved_at'),
                DateTimePicker::make('paid_at'),
                TextInput::make('approved_by')
                    ->numeric(),
                TextInput::make('payment_details'),
            ]);
    }
}
