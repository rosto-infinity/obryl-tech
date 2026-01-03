<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Auth\UserStatus;
use App\Enums\Auth\UserType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                DateTimePicker::make('two_factor_confirmed_at'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('avatar'),
                Select::make('user_type')
                    ->options(UserType::class)
                    ->default('client')
                    ->required(),
                Select::make('status')
                    ->options(UserStatus::class)
                    ->default('active')
                    ->required(),
            ]);
    }
}
