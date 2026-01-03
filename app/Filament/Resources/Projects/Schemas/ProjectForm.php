<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),
                Select::make('type')
                    ->options(ProjectType::class)
                    ->default('web')
                    ->required(),
                Select::make('status')
                    ->options(ProjectStatus::class)
                    ->default('pending')
                    ->required(),
                Select::make('priority')
                    ->options(ProjectPriority::class)
                    ->default('medium')
                    ->required(),
                TextInput::make('budget')
                    ->numeric(),
                TextInput::make('final_cost')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('currency')
                    ->required()
                    ->default('XAF'),
                DatePicker::make('deadline'),
                DatePicker::make('started_at'),
                DatePicker::make('completed_at'),
                TextInput::make('progress_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('technologies'),
                TextInput::make('attachments'),
                TextInput::make('milestones'),
                TextInput::make('tasks'),
                TextInput::make('collaborators'),
                Toggle::make('is_published')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('likes_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('views_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reviews_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('average_rating')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
                Textarea::make('cancellation_reason')
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->image(),
                TextInput::make('gallery_images'),
            ]);
    }
}
