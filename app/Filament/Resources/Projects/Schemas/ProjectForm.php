<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use App\Enums\Project\ProjectType;
use Filament\Infolists\Components;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;

use App\Enums\Project\ProjectStatus;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use App\Enums\Project\ProjectPriority;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Actions\Action;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('project_tabs')
                    ->tabs([
                        // ONGLET: INFORMATIONS GÉNÉRALES
                        Tabs\Tab::make('Informations Générales')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Informations Principales')
                                    ->description('Les informations de base du projet')
                                    ->icon('heroicon-o-document-text')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Code du projet')
                                            ->placeholder('Ex: PROJ-2024-001')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(20)
                                            ->helperText('Code unique pour identifier le projet'),
                                        
                                        TextInput::make('title')
                                            ->label('Titre du projet')
                                            ->placeholder('Entrez le titre du projet')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Str::slug($state))),
                                        
                                        TextInput::make('slug')
                                            ->label('URL du projet')
                                            ->placeholder('url-du-projet')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->helperText('URL unique pour le projet (généré automatiquement)'),
                                    ]),
                                
                                Section::make('Description')
                                    ->description('Description détaillée du projet')
                                    ->icon('heroicon-o-document')
                                    ->schema([
                                        Textarea::make('description')
                                            ->label('Description du projet')
                                            ->placeholder('Décrivez le projet en détail...')
                                            ->required()
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        // ONGLET: ASSIGNATION ET STATUT
                        Tabs\Tab::make('Assignation et Statut')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Assignation')
                                    ->description('Assignation du projet aux clients et développeurs')
                                    ->icon('heroicon-o-users')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('client_id')
                                            ->label('Client')
                                            ->placeholder('Sélectionner un client')
                                            ->relationship('client', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Nom du client')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('email')
                                                    ->label('Email du client')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionUsing(function (array $data) {
                                                $client = User::create([
                                                    'name' => $data['name'],
                                                    'email' => $data['email'],
                                                    'user_type' => 'client',
                                                    'password' => bcrypt('password'),
                                                ]);
                                                return $client->id;
                                            }),
                                        
                                        Select::make('developer_id')
                                            ->label('Développeur')
                                            ->placeholder('Sélectionner un développeur')
                                            ->relationship('developer', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Laissez vide pour assigner plus tard'),
                                    ]),
                                
                                Section::make('Statut du Projet')
                                    ->description('Configuration du statut et priorité')
                                    ->icon('heroicon-o-flag')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('type')
                                            ->label('Type de projet')
                                            ->placeholder('Sélectionner le type')
                                            ->options(ProjectType::class)
                                            ->default('web')
                                            ->required()
                                            ->searchable()
                                            ->getSearchResultsUsing(function (string $search) {
                                                return collect(ProjectType::cases())
                                                    ->filter(fn ($case) => str_contains($case->label(), $search))
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()]);
                                            }),
                                        
                                        Select::make('status')
                                            ->label('Statut')
                                            ->placeholder('Sélectionner le statut')
                                            ->options(ProjectStatus::class)
                                            ->default('pending')
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                // Auto-compléter certaines dates selon le statut
                                                if ($state === 'completed' && !$get('completed_at')) {
                                                    $set('completed_at', now()->format('Y-m-d'));
                                                }
                                                if ($state === 'in_progress' && !$get('started_at')) {
                                                    $set('started_at', now()->format('Y-m-d'));
                                                }
                                            }),
                                        
                                        Select::make('priority')
                                            ->label('Priorité')
                                            ->placeholder('Sélectionner la priorité')
                                            ->options(ProjectPriority::class)
                                            ->default('medium')
                                            ->required(),
                                    ]),
                            ]),
                        
                        // ONGLET: BUDGET ET DATES
                        Tabs\Tab::make('Budget et Dates')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make('Informations Financières')
                                    ->description('Budget et coûts du projet')
                                    ->icon('heroicon-o-banknotes')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('budget')
                                            ->label('Budget estimé')
                                            ->placeholder('0.00')
                                            ->numeric()
                                            ->prefix('XAF')
                                            ->step(0.01)
                                            ->helperText('Budget total estimé pour le projet'),
                                        
                                        TextInput::make('final_cost')
                                            ->label('Coût final')
                                            ->placeholder('0.00')
                                            ->numeric()
                                            ->prefix('XAF')
                                            ->step(0.01)
                                            ->helperText('Coût réel final du projet'),
                                        
                                        Select::make('currency')
                                            ->label('Devise')
                                            ->placeholder('Sélectionner la devise')
                                            ->options([
                                                'XAF' => 'XAF (Franc CFA)',
                                                'EUR' => 'EUR (Euro)',
                                                'USD' => 'USD (Dollar Américain)',
                                            ])
                                            ->default('XAF')
                                            ->required(),
                                    ]),
                                
                                Section::make('Planning')
                                    ->description('Dates importantes du projet')
                                    ->icon('heroicon-o-calendar')
                                    ->columns(3)
                                    ->schema([
                                        DatePicker::make('deadline')
                                            ->label('Date limite')
                                            ->placeholder('Sélectionner la date limite')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->helperText('Date de fin prévue du projet'),
                                        
                                        DatePicker::make('started_at')
                                            ->label('Date de début')
                                            ->placeholder('Sélectionner la date de début')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->helperText('Date réelle de début du projet'),
                                        
                                        DatePicker::make('completed_at')
                                            ->label('Date de fin')
                                            ->placeholder('Sélectionner la date de fin')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->helperText('Date réelle de fin du projet'),
                                    ]),
                            ]),
                        
                        // ONGLET: PROGRESSION ET CONTENU
                        Tabs\Tab::make('Progression et Contenu')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('Progression')
                                    ->description('Suivi de la progression du projet')
                                    ->icon('heroicon-o-chart-pie')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('progress_percentage')
                                            ->label('Pourcentage de progression')
                                            ->placeholder('0')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->suffix('%')
                                            ->helperText('Progression actuelle du projet (0-100%)'),
                                        
                                        ToggleButtons::make('is_published')
                                            ->label('Publication')
                                            ->required()
                                            ->default(false)
                                            ->inline()
                                            ->options([
                                                'published' => 'Publié',
                                                'draft' => 'Brouillon',
                                            ])
                                            ->helperText('Rendre le projet visible publiquement'),
                                    ]),
                                
                                Section::make('Technologies et Contenu')
                                    ->description('Configuration technique et contenu du projet')
                                    ->icon('heroicon-o-cog')
                                    ->schema([
                                        Textarea::make('technologies')
                                            ->label('Technologies utilisées')
                                            ->placeholder('Ex: Laravel, React, Vue.js (une par ligne)')
                                            ->helperText('Liste des technologies utilisées dans le projet')
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('milestones')
                                            ->label('Jalons du projet')
                                            ->placeholder('Ex: Phase 1 - Développement\nPhase 2 - Tests\nPhase 3 - Déploiement')
                                            ->helperText('Jalons importants du projet (un par ligne)')
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('tasks')
                                            ->label('Tâches du projet')
                                            ->placeholder('Ex: Configuration de la base de données\nDéveloppement des API\nTests unitaires')
                                            ->helperText('Tâches détaillées du projet (une par ligne)')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        // ONGLET: MÉDIAS ET VISIBILITÉ
                        Tabs\Tab::make('Médias et Visibilité')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Images du Projet')
                                    ->description('Images et médias du projet')
                                    ->icon('heroicon-o-photo')
                                    ->columns(2)
                                    ->schema([
                                        FileUpload::make('featured_image')
                                            ->label('Image principale')
                                            ->placeholder('Télécharger l\'image principale')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('projects/featured')
                                            // ->visibility('public')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->helperText('Image principale du projet (max 2MB, formats: JPG, PNG, WebP)'),
                                        
                                        FileUpload::make('gallery_images')
                                            ->label('Galerie d\'images')
                                            ->placeholder('Télécharger les images de la galerie')
                                            ->multiple()
                                            ->reorderable()
                                            ->image()
                                            ->imageEditor()
                                            ->directory('projects/gallery')
                                            
                                            ->maxSize(1024)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->default([])
                                            ->helperText('Images additionnelles pour la galerie (max 1MB par image)'),
                                    ]),
                                
                                Section::make('Visibilité et Promotion')
                                    ->description('Options de visibilité et promotion')
                                    ->icon('heroicon-o-eye')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('is_featured')
                                            ->label('Projet mis en avant')
                                            ->default(false)
                                            ->helperText('Mettre ce projet en avant sur la page d\'accueil'),
                                        
                                        Textarea::make('collaborators')
                                            ->label('Collaborateurs')
                                            ->placeholder('Ex: John Doe - Développeur Frontend\nJane Smith - Designer UX')
                                            ->helperText('Liste des collaborateurs externes (un par ligne)')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        // ONGLET: STATISTIQUES ET ADMINISTRATION
                        Tabs\Tab::make('Statistiques et Administration')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('Statistiques')
                                    ->description('Statistiques du projet')
                                    ->icon('heroicon-o-chart-bar')
                                    ->columns(4)
                                    ->schema([
                                        TextInput::make('likes_count')
                                            ->label('Nombre de likes')
                                            ->placeholder('0')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->helperText('Nombre total de likes reçus'),
                                        
                                        TextInput::make('views_count')
                                            ->label('Nombre de vues')
                                            ->placeholder('0')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->helperText('Nombre total de vues'),
                                        
                                        TextInput::make('reviews_count')
                                            ->label('Nombre d\'avis')
                                            ->placeholder('0')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->helperText('Nombre total d\'avis reçus'),
                                        
                                        TextInput::make('average_rating')
                                            ->label('Note moyenne')
                                            ->placeholder('0.0')
                                            ->numeric()
                                            ->default(0.0)
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(5)
                                            ->disabled()
                                            ->helperText('Note moyenne des avis (0-5)'),
                                    ]),
                                
                                Section::make('Administration')
                                    ->description('Notes administratives et gestion')
                                    ->icon('heroicon-o-shield-check')
                                    ->schema([
                                        Textarea::make('admin_notes')
                                            ->label('Notes administratives')
                                            ->placeholder('Notes internes pour l\'administration...')
                                            ->rows(4)
                                            ->columnSpanFull()
                                            ->helperText('Notes visibles uniquement par les administrateurs'),
                                        
                                        Textarea::make('cancellation_reason')
                                            ->label('Raison d\'annulation')
                                            ->placeholder('Raison de l\'annulation du projet...')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->visible(fn (callable $get) => $get('status') === 'cancelled')
                                            ->helperText('Raison de l\'annulation (visible uniquement si le projet est annulé)'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString()
                    ->activeTab(1),
            ])
            ->columns(1);
    }
    
    /**
     * Validation personnalisée pour le formulaire
     */
    public static function getValidationRules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:projects,code,{{recordId}}'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,{{recordId}}'],
            'description' => ['required', 'string', 'min:10'],
            'client_id' => ['required', 'exists:users,id'],
            'developer_id' => ['nullable', 'exists:users,id'],
            'type' => ['required', 'in:' . implode(',', array_column(ProjectType::cases(), 'value'))],
            'status' => ['required', 'in:' . implode(',', array_column(ProjectStatus::cases(), 'value'))],
            'priority' => ['required', 'in:' . implode(',', array_column(ProjectPriority::cases(), 'value'))],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'final_cost' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'in:XAF,EUR,USD'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'started_at' => ['nullable', 'date', 'before_or_equal:completed_at'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'progress_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'featured_image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'],
            'gallery_images.*' => ['nullable', 'image', 'max:1024', 'mimes:jpeg,png,webp'],
        ];
    }
    
    /**
     * Messages d'erreur personnalisés en français
     */
    public static function getValidationMessages(): array
    {
        return [
            'code.required' => 'Le code du projet est obligatoire.',
            'code.unique' => 'Ce code de projet existe déjà.',
            'code.max' => 'Le code du projet ne peut pas dépasser 20 caractères.',
            
            'title.required' => 'Le titre du projet est obligatoire.',
            'title.max' => 'Le titre du projet ne peut pas dépasser 255 caractères.',
            
            'slug.required' => 'L\'URL du projet est obligatoire.',
            'slug.unique' => 'Cette URL existe déjà. Veuillez en choisir une autre.',
            'slug.max' => 'L\'URL du projet ne peut pas dépasser 255 caractères.',
            
            'description.required' => 'La description du projet est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            
            'client_id.required' => 'La sélection d\'un client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            
            'developer_id.exists' => 'Le développeur sélectionné n\'existe pas.',
            
            'type.required' => 'Le type de projet est obligatoire.',
            'type.in' => 'Le type de projet sélectionné n\'est pas valide.',
            
            'status.required' => 'Le statut du projet est obligatoire.',
            'status.in' => 'Le statut sélectionné n\'est pas valide.',
            
            'priority.required' => 'La priorité du projet est obligatoire.',
            'priority.in' => 'La priorité sélectionnée n\'est pas valide.',
            
            'budget.numeric' => 'Le budget doit être un nombre.',
            'budget.min' => 'Le budget doit être supérieur ou égal à 0.',
            
            'final_cost.numeric' => 'Le coût final doit être un nombre.',
            'final_cost.min' => 'Le coût final doit être supérieur ou égal à 0.',
            
            'currency.required' => 'La devise est obligatoire.',
            'currency.in' => 'La devise sélectionnée n\'est pas valide.',
            
            'deadline.date' => 'La date limite doit être une date valide.',
            'deadline.after_or_equal' => 'La date limite doit être aujourd\'hui ou une date future.',
            
            'started_at.date' => 'La date de début doit être une date valide.',
            'started_at.before_or_equal' => 'La date de début doit être avant ou égale à la date de fin.',
            
            'completed_at.date' => 'La date de fin doit être une date valide.',
            'completed_at.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
            
            'progress_percentage.required' => 'Le pourcentage de progression est obligatoire.',
            'progress_percentage.numeric' => 'Le pourcentage de progression doit être un nombre.',
            'progress_percentage.min' => 'Le pourcentage de progression doit être au moins 0.',
            'progress_percentage.max' => 'Le pourcentage de progression ne peut pas dépasser 100.',
            
            'featured_image.image' => 'Le fichier doit être une image.',
            'featured_image.max' => 'L\'image principale ne peut pas dépasser 2MB.',
            'featured_image.mimes' => 'L\'image principale doit être au format JPG, PNG ou WebP.',
            
            'gallery_images.*.image' => 'Tous les fichiers de la galerie doivent être des images.',
            'gallery_images.*.max' => 'Chaque image de la galerie ne peut pas dépasser 1MB.',
            'gallery_images.*.mimes' => 'Les images de la galerie doivent être au format JPG, PNG ou WebP.',
        ];
    }
}
