<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\Blog\ArticleCategory;
use App\Enums\Blog\ArticleStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Article')
                    ->tabs([
                        Tab::make('Contenu')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Select::make('author_id')
                                    ->relationship('author', 'name')
                                    ->default(auth()->id())
                                    ->required()
                                    ->searchable()
                                    ->validationMessages([
                                        'required' => 'L\'auteur est obligatoire.',
                                    ]),

                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->validationMessages([
                                        'required' => 'Le titre est obligatoire.',
                                        'max_length' => 'Le titre ne peut pas dépasser 255 caractères.',
                                    ])
                                    ->afterStateUpdated(
                                        fn (string $operation, $state, \Filament\Schemas\Components\Utilities\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                    ),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'required' => 'Le slug est obligatoire.',
                                        'max_length' => 'Le slug ne peut pas dépasser 255 caractères.',
                                        'unique' => 'Ce slug existe déjà.',
                                    ]),

                                Textarea::make('excerpt')
                                    ->label('Résumé')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                \Filament\Forms\Components\MarkdownEditor::make('content')
                                    ->label('Contenu Markdown')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('articles/attachments')
                                    ->validationMessages([
                                        'required' => 'Le contenu est obligatoire.',
                                    ]),
                            ]),

                        Tab::make('Médias & Taxonomie')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('Image à la une')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('articles/featured')
                                    ->disk('public') // Explicitly use public disk
                                    ->visibility('public')
                                    ->maxSize(2048) // 2MB limit
                                    ->columnSpanFull()
                                    ->helperText('Format recommandé: 1200x800px. Maximum 2Mo.'),

                                Select::make('category')
                                    ->label('Catégorie')
                                    ->options(ArticleCategory::class)
                                    ->required()
                                    ->native(false)
                                    ->validationMessages([
                                        'required' => 'La catégorie est obligatoire.',
                                    ]),

                                \Filament\Forms\Components\TagsInput::make('tags')
                                    ->label('Tags')
                                    ->placeholder('Nouveau tag')
                                    ->separator(','),
                            ]),

                        Tab::make('Statut & SEO')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('status')
                                            ->options(ArticleStatus::class)
                                            ->default(ArticleStatus::DRAFT)
                                            ->required()
                                            ->native(false)
                                            ->validationMessages([
                                                'required' => 'Le statut est obligatoire.',
                                            ]),

                                        DateTimePicker::make('published_at')
                                            ->label('Date de publication'),

                                        DateTimePicker::make('scheduled_at')
                                            ->label('Programmé pour'),
                                    ]),

                                Section::make('SEO')
                                    ->description('Métadonnées pour les moteurs de recherche')
                                    ->collapsed()
                                    ->schema([
                                        \Filament\Forms\Components\KeyValue::make('seo')
                                            ->label('Données SEO')
                                            ->keyLabel('Propriété (meta_description, keywords, etc.)')
                                            ->valueLabel('Valeur')
                                            ->addActionLabel('Ajouter une métadonnée'),
                                    ]),
                            ]),

                        Tab::make('Commentaires')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                \Filament\Forms\Components\Repeater::make('comments')
                                    ->label('Gestion des commentaires')
                                    ->schema([
                                        TextInput::make('user_name')
                                            ->label('Utilisateur')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Le nom d\'utilisateur est obligatoire.',
                                            ]),
                                        Textarea::make('content')
                                            ->label('Commentaire')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Le commentaire est obligatoire.',
                                            ]),
                                        Select::make('status')
                                            ->options([
                                                'pending' => 'En attente',
                                                'approved' => 'Approuvé',
                                                'rejected' => 'Rejeté',
                                            ])
                                            ->default('pending')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Le statut du commentaire est obligatoire.',
                                            ]),
                                        DateTimePicker::make('created_at')
                                            ->label('Date')
                                            ->default(now()),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['user_name'] ?? null)
                                    ->collapsible()
                                    ->collapsed()
                                    ->grid(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
