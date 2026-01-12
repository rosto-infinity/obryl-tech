<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Appearance extends Component
{
    /**
     * Les options de thème disponibles
     */
    public const THEME_LIGHT = 'light';
    public const THEME_DARK = 'dark';
    public const THEME_SYSTEM = 'system';

    /**
     * Rendre le composant
     */
    public function render(): View
    {
        return view('livewire.settings.appearance');
    }

    /**
     * Monter le composant avec les données utilisateur
     */
    public function mount(): void
    {
        // Le thème est géré via localStorage et les directives Flux
        // Aucune donnée à récupérer en base de données pour l'instant
    }
}

