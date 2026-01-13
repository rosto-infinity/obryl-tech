<div class="space-y-6">
    {{-- Header avec statistiques --}}
    <div class="bg-white rounded-lg shadow p-4 md:p-6">
        {{-- Titre et Statistiques --}}
        <div class="mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Projets</h2>

            {{-- Statistiques responsive --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3 ">
                <div class="bg-blue-50 px-2 md:px-3 py-2 rounded-lg ">
                    <div class="text-xs md:text-sm font-medium text-primary">{{ $stats['total'] }}</div>
                    <div class="text-xs text-primary/70">Total</div>
                </div>
                <div class="bg-green-50 px-2 md:px-3 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium text-green-600">{{ $stats['published'] }}</div>
                    <div class="text-xs text-green-600/70">Publiés</div>
                </div>
                <div class="bg-purple-50 px-2 md:px-3 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium text-purple-600">{{ $stats['featured'] }}</div>
                    <div class="text-xs text-purple-600/70">En vedette</div>
                </div>
                <div class="bg-yellow-50 px-2 md:px-3 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium text-yellow-600">{{ $stats['in_progress'] }}</div>
                    <div class="text-xs text-yellow-600/70">En cours</div>
                </div>
            </div>
        </div>

        {{-- Filtres --}}
        <div class="space-y-3">
            {{-- Ligne 1: Recherche + Statut + Type --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5">Recherche</label>
                    <input type="text" wire:model.live="search" placeholder="Titre, description..."
                        class="w-full px-2.5 md:px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 transition" />
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5">Statut</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-2.5 md:px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                        <option value="all">Tous</option>
                        @foreach ($projectStatuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5">Type</label>
                    <select wire:model.live="typeFilter"
                        class="w-full px-2.5 md:px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                        <option value="all">Tous</option>
                        @foreach ($projectTypes as $type)
                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Ligne 2: Priorité + Trier par + Checkboxes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5">Priorité</label>
                    <select wire:model.live="priorityFilter"
                        class="w-full px-2.5 md:px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                        <option value="all">Toutes</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority['value'] }}">{{ $priority['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5">Trier par</label>
                    <select wire:model.live="sortBy"
                        class="w-full px-2.5 md:px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                        <option value="created_at">Date de création</option>
                        <option value="title">Titre</option>
                        <option value="budget">Budget</option>
                        <option value="deadline">Date limite</option>
                    </select>
                </div>

                {{-- Checkboxes --}}
                <div class="flex flex-col justify-end space-y-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="showFeaturedOnly"
                            class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50">
                        <span class="ml-2 text-xs md:text-sm text-gray-700">En vedette</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="showPublishedOnly"
                            class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50">
                        <span class="ml-2 text-xs md:text-sm text-gray-700">Publiés seulement</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

 <!-- Grille des projets: 2 colonnes (md+), 1 colonne (mobile) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col">
                
                {{-- Image featured --}}
                @if($project->featured_image)
                    <div class="relative h-40 bg-gray-200 overflow-hidden">
                        <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        
                        {{-- Badges overlay --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                            @if($project->is_featured)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-400/90 text-yellow-900 backdrop-blur-sm">
                                    ⭐ En vedette
                                </span>
                            @endif
                            
                            @switch($project->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-400/90 text-yellow-900 backdrop-blur-sm">
                                        ⏳ En attente
                                    </span>
                                    @break
                                @case('in_progress')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-400/90 text-blue-900 backdrop-blur-sm">
                                        ⚙️ En cours
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-400/90 text-green-900 backdrop-blur-sm">
                                        ✅ Complété
                                    </span>
                                    @break
                                @case('published')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/90 text-white backdrop-blur-sm">
                                        📢 Publié
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                @endif
                
                {{-- Contenu --}}
                <div class="p-4 flex-1 flex flex-col">
                    {{-- Titre et code --}}
                    <div class="mb-3">
                        <h3 class="text-base font-semibold text-gray-900 line-clamp-2">{{ $project->title }}</h3>
                        <p class="text-xs text-gray-500 font-mono">{{ $project->code }}</p>
                    </div>
                    
                    {{-- Description --}}
                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ Str::limit($project->description, 100) }}</p>
                    
                    {{-- Informations compactes --}}
                    <div class="space-y-1.5 mb-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client:</span>
                            <span class="font-medium text-gray-900">{{ $project->client?->name ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Budget:</span>
                            <span class="font-medium text-gray-900">{{ number_format($project->budget, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        @if($project->deadline)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date limite:</span>
                                <span class="font-medium {{ $project->deadline->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $project->deadline->format('d/m/Y') }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium text-gray-900">{{ $project->type->label() }}</span>
                        </div>
                    </div>
                    
                    {{-- Barre de progression --}}
                    @if($project->progress_percentage)
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-gray-600">Progression</span>
                                <span class="text-xs font-semibold text-gray-900">{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-secondary h-1.5 rounded-full transition-all duration-300"
                                 style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Technologies --}}
                    @if($project->technologies)
                        <div class="mb-3">
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $technologies = $project->technologies;
                                    $displayedTechs = array_slice($technologies, 0, 3);
                                @endphp
                                @foreach($displayedTechs as $tech)
                                    <span class="inline-block px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                                @if(count($technologies) > 3)
                                    <span class="inline-block px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded font-medium">
                                        +{{ count($technologies) - 3 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    {{-- Statistiques --}}
                    <div class="flex justify-between items-center text-xs text-gray-600 mb-4 py-2 border-t border-gray-100">
                        <div class="flex items-center space-x-3">
                            @if($project->average_rating > 0)
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★</span>
                                    <span class="ml-1 font-medium text-gray-900">{{ number_format($project->average_rating, 1) }}</span>
                                    <span class="text-gray-400 ml-0.5">({{ $project->reviews_count ?? 0 }})</span>
                                </div>
                            @else
                                <span class="text-gray-400">Pas noté</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="flex items-center">
                                <span class="text-red-500">❤️</span>
                                <span class="ml-0.5 font-medium">{{ $project->likes_count ?? 0 }}</span>
                            </span>
                            <span class="flex items-center">
                                <span class="text-blue-500">👁️</span>
                                <span class="ml-0.5 font-medium">{{ $project->views_count ?? 0 }}</span>
                            </span>
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('projects.detail', $project->slug) }}" class="flex-1 bg-primary text-white text-center px-3 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition-colors duration-200">
                            Voir
                        </a>
                        @if($project->status === 'published')
                            <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors duration-200 text-sm">
                                ❤️
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="text-gray-400 text-lg mb-2">📭 Aucun projet trouvé</div>
                <div class="text-gray-500 text-sm">Essayez d'ajuster vos filtres de recherche</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-lg shadow">
            {{ $projects->links() }}
        </div>
    @endif
</div>