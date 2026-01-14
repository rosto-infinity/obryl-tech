<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuration Globale')
                    ->description('Modifiez les paramètres du système avec précaution.')
                    ->schema([
                        TextInput::make('key')
                            ->label('Clé du paramètre')
                            ->placeholder('Ex: platform_commission_rate')
                            ->hint('Format snake_case recommandé')
                            ->required()
                            ->disabled() // Généralement on ne change pas la clé une fois créée
                            ->dehydrated(),
                        TextInput::make('type')
                            ->label('Type de donnée')
                            ->required()
                            ->default('string')
                            ->disabled(),
                        Textarea::make('value')
                            ->label('Valeur')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description de l\'utilité')
                            ->placeholder('À quoi sert ce paramètre ?')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
