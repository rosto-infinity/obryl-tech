<?php

declare(strict_types=1);

namespace App\Livewire\Developer;

use Livewire\Component;

class DeveloperSearch extends Component
{
    public function render()
    {
        return view('livewire.developer.developer-search')->extends('components.layouts.public');
    }
}
