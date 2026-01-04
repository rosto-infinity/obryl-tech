<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Auth\Country;
use App\Enums\Auth\UserType;
use Filament\Schemas\Schema;
use App\Enums\Auth\UserStatus;

use Filament\Forms\Components\Select;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('user_tabs')
                    ->tabs([
                        // ONGLET: INFORMATIONS PRINCIPALES
                        Tabs\Tab::make('Informations Principales')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Informations de base')
                                    ->description('Données personnelles de l\'utilisateur')
                                    ->icon('heroicon-o-user-circle')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nom complet')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Nom et prénom de l\'utilisateur'),
                                        
                                        TextInput::make('email')
                                            ->label('Adresse email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Adresse email de connexion'),
                                        
                                        TextInput::make('phone')
                                            ->label('Téléphone')
                                            ->tel()
                                            ->maxLength(20)
                                            ->helperText('Numéro de téléphone (optionnel)'),
                                    ])
                                    ->columns(2),
                                
                                Section::make('Avatar et profil')
                                    ->description('Photo de profil et informations publiques')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        FileUpload::make('avatar')
                                            ->label('Photo de profil')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('avatars')
                                            ->maxSize(1024)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->helperText('Image de profil (max 1MB, formats: JPG, PNG, WebP)'),
                                    ]),
                            ]),
                        
                        // ONGLET: SÉCURITÉ ET ACCÈS
                        Tabs\Tab::make('Sécurité et Accès')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Mot de passe')
                                    ->description('Paramètres de sécurité du compte')
                                    ->icon('heroicon-o-key')
                                    ->schema([
                                        TextInput::make('password')
                                            ->label('Mot de passe')
                                            ->password()
                                            ->revealable()
                                            ->helperText('Laissez vide pour ne pas modifier le mot de passe')
                                            ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null),
                                    ]),
                                
                                Section::make('Authentification à deux facteurs')
                                    ->description('Configuration 2FA pour la sécurité renforcée')
                                    ->icon('heroicon-o-lock-closed')
                                    ->schema([
                                        Textarea::make('two_factor_secret')
                                            ->label('Secret 2FA')
                                            ->rows(2)
                                            ->columnSpanFull()
                                            ->helperText('Secret pour l\'authentification à deux facteurs (généré automatiquement)'),
                                        
                                        Textarea::make('two_factor_recovery_codes')
                                            ->label('Codes de récupération')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->helperText('Codes de récupération 2FA (un par ligne)'),
                                        
                                        DateTimePicker::make('two_factor_confirmed_at')
                                            ->label('Date de confirmation 2FA')
                                            ->displayFormat('d/m/Y H:i')
                                            ->helperText('Date à laquelle l\'authentification 2FA a été confirmée')
                                            ->disabled(),
                                    ]),
                            ]),
                        
                        // ONGLET: STATUT ET PERMISSIONS
                        Tabs\Tab::make('Statut et Permissions')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Type et statut')
                                    ->description('Rôle et état du compte utilisateur')
                                    ->icon('heroicon-o-flag')
                                    ->schema([
                                        Select::make('user_type')
                                            ->label('Type d\'utilisateur')
                                            ->options(UserType::class)
                                            ->default(UserType::CLIENT->value)
                                            ->required()
                                            ->helperText('Rôle de l\'utilisateur dans la plateforme'),
                                        
                                        Select::make('status')
                                            ->label('Statut du compte')
                                            ->options(UserStatus::class)
                                            ->default(UserStatus::ACTIVE->value)
                                            ->required()
                                            ->helperText('État actuel du compte utilisateur'),
                                    ])
                                    ->columns(2),
                                
                                Section::make('Vérification et localisation')
                                    ->description('Informations de vérification et géographiques')
                                    ->icon('heroicon-o-globe-alt')
                                    ->schema([
                                        Select::make('country')
                                            ->label('Pays')
                                            ->options(Country::class)
                                            ->searchable()
                                            ->helperText('Pays de résidence de l\'utilisateur'),
                                        
                                        DateTimePicker::make('email_verified_at')
                                            ->label('Email vérifié le')
                                            ->displayFormat('d/m/Y H:i')
                                            ->helperText('Date de vérification de l\'adresse email')
                                            ->disabled(),
                                    ])
                                    ->columns(2),
                            ]),
                        
                        // ONGLET: PRÉFÉRENCES
                        Tabs\Tab::make('Préférences')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Section::make('Paramètres utilisateur')
                                    ->description('Préférences personnelles et configuration')
                                    // ->icon('heroicon-o-adjustments')
                                    ->schema([
                                        Toggle::make('email_notifications')
                                            ->label('Notifications email')
                                            ->default(true)
                                            ->helperText('Recevoir les notifications par email'),
                                        
                                        Toggle::make('sms_notifications')
                                            ->label('Notifications SMS')
                                            ->default(false)
                                            ->helperText('Recevoir les notifications par SMS'),
                                        
                                        Toggle::make('marketing_emails')
                                            ->label('Emails marketing')
                                            ->default(false)
                                            ->helperText('Recevoir les emails marketing et promotionnels'),
                                        
                                        Select::make('language')
                                            ->label('Langue préférée')
                                            ->options([
                                                'fr' => 'Français',
                                                'en' => 'English',
                                                'es' => 'Español',
                                            ])
                                            ->default('fr')
                                            ->helperText('Langue de l\'interface utilisateur'),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
