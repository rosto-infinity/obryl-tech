<div class="space-y-6">
    {{-- Header avec statistiques --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Projets</h2>
            <div class="flex space-x-4 text-sm">
                <div class="bg-blue-50 px-3 py-1 rounded-full">
                    <span class="text-blue-600 font-medium">{{ $stats['total'] }}</span>
                    <span class="text-blue-500">Total</span>
                </div>
                <div class="bg-green-50 px-3 py-1 rounded-full">
                    <span class="text-green-600 font-medium">{{ $stats['published'] }}</span>
                    <span class="text-green-500">Publiés</span>
                </div>
                <div class="bg-purple-50 px-3 py-1 rounded-full">
                    <span class="text-purple-600 font-medium">{{ $stats['featured'] }}</span>
                    <span class="text-purple-500">En vedette</span>
                </div>
                <div class="bg-yellow-50 px-3 py-1 rounded-full">
                    <span class="text-yellow-600 font-medium">{{ $stats['in_progress'] }}</span>
                    <span class="text-yellow-500">En cours</span>
                </div>
            </div>
        </div>
        
        {{-- Filtres --}}
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Titre, description..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous</option>
                    @foreach($projectStatuses as $status)
                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select wire:model.live="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous</option>
                    @foreach($projectTypes as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                <select wire:model.live="priorityFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Toutes</option>
                    @foreach($priorities as $priority)
                        <option value="{{ $priority['value'] }}">{{ $priority['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="created_at">Date de création</option>
                    <option value="title">Titre</option>
                    <option value="budget">Budget</option>
                    <option value="deadline">Date limite</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" wire:model.live="showFeaturedOnly" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">En vedette</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" wire:model.live="showPublishedOnly" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Publiés seulement</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Liste des projets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                {{-- Image featured --}}
                @if($project->featured_image)
                    <div class="h-48 bg-gray-200 rounded-t-lg overflow-hidden">
                        <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                    </div>
                @endif
                
                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                        ⭐ En vedette
                                    </span>
                                @endif
                                
                                @switch($project->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            ⏳ En attente
                                        </span>
                                        @break
                                    @case('in_progress')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            ⚙️ En cours
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            ✅ Complété
                                        </span>
                                        @break
                                    @case('published')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            📢 Publié
                                        </span>
                                        @break
                                @endswitch
                            </div>
                            
                            <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $project->code }}</p>
                        </div>
                    </div>
                    
                    {{-- Description --}}
                    <div class="mb-4">
                        <p class="text-sm text-gray-700 line-clamp-3">{{ Str::limit($project->description, 150) }}</p>
                    </div>
                    
                    {{-- Informations --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Client:</span>
                            <span class="font-medium">{{ $project->client?->name ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Budget:</span>
                            <span class="font-medium">{{ number_format($project->budget, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        @if($project->deadline)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Date limite:</span>
                                <span class="font-medium {{ $project->deadline->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $project->deadline->format('d/m/Y') }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $project->type->label() }}</span>
                        </div>
                        
                        @if($project->progress_percentage)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Progression:</span>
                                <span class="font-medium">{{ $project->progress_percentage }}%</span>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Barre de progression --}}
                    @if($project->progress_percentage)
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Statistiques --}}
                    <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            @if($project->average_rating > 0)
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★</span>
                                    <span class="ml-1">{{ number_format($project->average_rating, 1) }}</span>
                                    <span class="text-gray-400 ml-1">({{ $project->reviews_count ?? 0 }})</span>
                                </div>
                            @else
                                <span class="text-gray-400">Pas encore noté</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <span class="text-red-500">❤️</span>
                                <span class="ml-1">{{ $project->likes_count ?? 0 }}</span>
                            </span>
                            <span class="flex items-center">
                                <span class="text-blue-500">👁️</span>
                                <span class="ml-1">{{ $project->views_count ?? 0 }}</span>
                            </span>
                        </div>
                    </div>
                    
                    {{-- Technologies --}}
                    @if($project->technologies)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $technologies = json_decode($project->technologies, true) ?? [];
                                    $displayedTechs = array_slice($technologies, 0, 3);
                                @endphp
                                @foreach($displayedTechs as $tech)
                                    <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                                @if(count($technologies) > 3)
                                    <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                        +{{ count($technologies) - 3 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    {{-- Actions --}}
                    <div class="flex space-x-2">
                        <a href="#" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Voir le projet
                        </a>
                        @if($project->status === 'published')
                            <button class="px-4 py-2 border border-red-600 text-red-600 rounded-md hover:bg-red-50 transition-colors duration-200">
                                <span class="text-red-500">❤️</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-lg mb-2">Aucun projet trouvé</div>
                <div class="text-gray-500">Essayez d'ajuster vos filtres de recherche</div>
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
