<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Portfolio Gallery</h1>
        <p class="text-gray-600 dark:text-gray-300">Découvrez les réalisations exceptionnelles de nos développeurs</p>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Projets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_projects'] }}</p>
                </div>
                <div class="bg-primary/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Développeurs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['developers'] }}</p>
                </div>
                <div class="bg-secondary/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 100 5.646 5.646L17 14l-1.646-1.646A4 4 0 0012 4.354z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Likes Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_likes'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Catégories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['categories'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Titre, description..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select wire:model.live="categoryFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all">Toutes</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['value'] }}">{{ $category['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Technologie</label>
                <select wire:model.live="techFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all">Toutes</option>
                    @foreach($technologies as $tech)
                        <option value="{{ $tech }}">{{ $tech }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="created_at">Date</option>
                    <option value="likes">Likes</option>
                    <option value="views">Vues</option>
                    <option value="title">Titre</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <!-- Image -->
                <div class="relative h-48 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-t-lg overflow-hidden">
                    @if($project->image_url)
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <svg class="w-16 h-16 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 013.657-3.657 3.657h3.414a2 2 0 011.414 1.414L16 16l-4.586 4.586a2 2 0 01-3.657-3.657 3.657H6.414A2 2 0 015 14.586 12L4 16z" />
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-2">
                        <button wire:click="likeProject({{ $project->id }})" class="bg-white/90 p-2 rounded-full hover:bg-white transition-colors duration-200">
                            <svg class="w-5 h-5 {{ $project->is_liked ? 'text-red-500' : 'text-gray-600' }}" fill="{{ $project->is_liked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('projects.detail', $project->id) }}" 
                       class="block w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 text-center">
                        Voir le projet
                    </a>
                    </div>
                    
                    {{-- Type Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/90 text-white">
                            {{ $project->type->label() }}
                        </span>
                    </div>
                    
                    @if($project->is_featured)
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-400 text-yellow-900">
                                ⭐ Vedette
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $project->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">{{ $project->description }}</p>
                    
                    <!-- Developer Info -->
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center mr-2">
                            @if($project->developer)
                                <span class="text-primary font-semibold text-xs">{{ $project->developer->initials() }}</span>
                            @else
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 100 5.646 5.646L17 14l-1.646-1.646A4 4 0 0012 4.354z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            @if($project->developer)
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->developer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $project->developer->profile->specialization->label() }}</p>
                            @else
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Client</p>
                                <p class="text-xs text-gray-500">{{ $project->client->name }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ $project->likes_count }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $project->views_count }}
                            </span>
                        </div>
                        <span class="text-xs">{{ $project->created_at->diffForHumans() }}</span>
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
        <div class="mt-8">
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-lg shadow">
                {{ $projects->links() }}
            </div>
        </div>
    @endif
</div>
