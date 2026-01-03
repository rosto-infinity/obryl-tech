<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Filtres</h3>
        <button wire:click="resetFilters" 
                class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
            Réinitialiser
        </button>
    </div>

    {{-- Search --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Recherche
        </label>
        <div class="relative">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Rechercher un projet..."
                   class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Project Type --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Type de projet
        </label>
        <select wire:model.live="typeFilter" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <option value="all">Tous les types</option>
            @foreach($projectTypes as $type)
                <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>

    {{-- Project Status --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Statut
        </label>
        <select wire:model.live="statusFilter" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <option value="all">Tous les statuts</option>
            @foreach($projectStatuses as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    {{-- Priority --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Priorité
        </label>
        <select wire:model.live="priorityFilter" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <option value="all">Toutes les priorités</option>
            @foreach($priorities as $priority)
                <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
            @endforeach
        </select>
    </div>

    {{-- Budget Range --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Budget (XAF)
        </label>
        <div class="space-y-2">
            <input type="number" 
                   wire:model.live="minBudget" 
                   placeholder="Min"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <input type="number" 
                   wire:model.live="maxBudget" 
                   placeholder="Max"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
        </div>
    </div>

    {{-- Technologies --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Technologies
        </label>
        <div class="space-y-2">
            @foreach($technologies as $tech)
                <label class="flex items-center">
                    <input type="checkbox" 
                           wire:model.live="selectedTechnologies.{{ $loop->index }}" 
                           value="{{ $tech }}"
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $tech }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Date Range --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Période
        </label>
        <div class="space-y-2">
            <input type="date" 
                   wire:model.live="startDate" 
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <input type="date" 
                   wire:model.live="endDate" 
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
        </div>
    </div>

    {{-- Sort Options --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Trier par
        </label>
        <select wire:model.live="sortBy" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
            <option value="created_at">Date de création</option>
            <option value="updated_at">Date de mise à jour</option>
            <option value="title">Titre</option>
            <option value="budget">Budget</option>
            <option value="deadline">Date limite</option>
        </select>
    </div>

    <div class="flex items-center">
        <input type="checkbox" 
               wire:model.live="sortDesc" 
               id="sort-desc"
               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary dark:border-gray-600 dark:bg-gray-700">
        <label for="sort-desc" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
            Ordre décroissant
        </label>
    </div>

    {{-- Active Filters Display --}}
    @if($hasActiveFilters)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Filtres actifs</h4>
            <div class="flex flex-wrap gap-2">
                @if($search)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        Recherche: {{ $search }}
                        <button wire:click="clearSearch" class="ml-2 text-primary hover:text-primary/80">
                            ×
                        </button>
                    </span>
                @endif
                @if($typeFilter !== 'all')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        Type: {{ $typeFilter }}
                        <button wire:click="clearType" class="ml-2 text-primary hover:text-primary/80">
                            ×
                        </button>
                    </span>
                @endif
                @if($statusFilter !== 'all')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        Statut: {{ $statusFilter }}
                        <button wire:click="clearStatus" class="ml-2 text-primary hover:text-primary/80">
                            ×
                        </button>
                    </span>
                @endif
                @if($priorityFilter !== 'all')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        Priorité: {{ $priorityFilter }}
                        <button wire:click="clearPriority" class="ml-2 text-primary hover:text-primary/80">
                            ×
                        </button>
                    </span>
                @endif
                @if(count($selectedTechnologies) > 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        Technologies ({{ count($selectedTechnologies) }})
                        <button wire:click="clearTechnologies" class="ml-2 text-primary hover:text-primary/80">
                            ×
                        </button>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
