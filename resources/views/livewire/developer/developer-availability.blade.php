<x-app-layout>
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Disponibilité des Développeurs
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Consultez les développeurs disponibles pour vos projets
        </p>
    </div>

    {{-- Filtres --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filtres</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <flux:input
                wire:model.live="search"
                placeholder="Rechercher un développeur..."
                icon="magnifying-glass"
            />
            
            <flux:select
                wire:model.live="specialization"
                placeholder="Spécialisation"
            >
                <option value="">Toutes les spécialisations</option>
                @foreach($specializations as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </flux:select>
            
            <flux:select
                wire:model.live="skillLevel"
                placeholder="Niveau de compétence"
            >
                <option value="">Tous les niveaux</option>
                @foreach($skillLevels as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </flux:select>
            
            <flux:button 
                wire:click="clearFilters" 
                variant="secondary"
                class="w-full"
            >
                <flux:icon name="x-mark" class="w-4 h-4" />
                Effacer les filtres
            </flux:button>
        </div>
    </div>

    {{-- Liste des développeurs --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        @if($developers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($developers as $developer)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-lg transition-shadow">
                        {{-- Header développeur --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                    <flux:icon name="user" class="w-5 h-5 text-primary" />
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $developer->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $developer->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($developer->workload)
                                    @switch($developer->workload->availability_status)
                                        @case('available')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Disponible
                                            </span>
                                        @break
                                        @case('busy')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Occupé
                                            </span>
                                        @break
                                        @case('overloaded')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Surchargé
                                            </span>
                                        @break
                                    @endswitch
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inconnu
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Détails développeur --}}
                        <div class="space-y-3">
                            @if($developer->profile)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Niveau:</span>
                                    <span class="font-medium">{{ $skillLevels[$developer->profile->skill_level] ?? 'Inconnu' }}</span>
                                </div>
                                
                                @if($developer->profile->specializations)
                                    <div class="text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Spécialisations:</span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($developer->profile->specializations as $spec)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                                                    {{ $specializations[$spec] ?? $spec }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if($developer->workload)
                                <div class="border-t pt-3 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Projets actifs:</span>
                                        <span class="font-medium">{{ $developer->workload->current_projects_count }} / {{ $developer->workload->max_projects_capacity }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Charge de travail:</span>
                                        <span class="font-medium">{{ number_format($developer->workload->workload_percentage, 1) }}%</span>
                                    </div>
                                    
                                    {{-- Barre de progression --}}
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div 
                                            class="bg-primary h-2 rounded-full transition-all duration-300"
                                            style="width: {{ min(100, $developer->workload->workload_percentage) }}%"
                                        ></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 pt-4 border-t">
                            <flux:button 
                                wire:navigate="route('developers.profile', $developer->id)"  wire:navigate
                                class="w-full"
                                variant="outline"
                            >
                                <flux:icon name="eye" class="w-4 h-4" />
                                Voir le profil
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $developers->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <flux:icon name="users" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Aucun développeur trouvé
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Essayez d'ajuster vos filtres ou revenez plus tard.
                </p>
            </div>
        @endif
    </div>
</div>
</x-app-layout>
