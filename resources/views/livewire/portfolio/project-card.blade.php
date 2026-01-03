<div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 {{ $showDetails ? 'ring-2 ring-primary/20' : '' }}">
    {{-- Header with Image --}}
    <div class="relative h-48 bg-gradient-to-br from-primary/10 to-secondary/10">
        @if($project->featured_image)
            <img src="{{ $project->featured_image }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <div class="w-16 h-16 bg-primary/20 rounded-lg flex items-center justify-center">
                    <span class="text-2xl font-bold text-primary">{{ $project->title[0] ?? 'P' }}</span>
                </div>
            @endif
        
        {{-- Type Badge --}}
        <div class="absolute top-4 left-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/90 text-white">
                {{ $project->type->label() }}
            </span>
        </div>
        
        @if($project->is_featured)
            <div class="absolute top-4 right-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-400 text-yellow-900">
                    ⭐ Vedette
                </span>
            </div>
        @endif
        
        {{-- Action Buttons --}}
        <div class="absolute bottom-4 right-4 flex space-x-2">
            <button wire:click="toggleLike" 
                    class="bg-white/90 p-2 rounded-full hover:bg-white transition-all duration-200 {{ $isLiked ? 'text-red-500' : 'text-gray-400' }}">
                <svg class="w-5 h-5 {{ $isLiked ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
            <button wire:click="toggleDetails" 
                    class="bg-white/90 p-2 rounded-full hover:bg-white transition-all duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $project->title }}</h2>
        
        <p class="text-gray-600 dark:text-gray-400 mb-4 {{ $showDetails ? '' : 'line-clamp-2' }}">
            {{ $project->description }}
        </p>
        
        {{-- Developer/Client Info --}}
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                @if($project->developer)
                    <span class="text-primary font-semibold text-sm">{{ $project->developer->initials() }}</span>
                @else
                    <span class="text-primary font-semibold text-sm">{{ $project->client->initials() }}</span>
                @endif
            </div>
            <div>
                @if($project->developer)
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->developer->name }}</p>
                    <p class="text-xs text-gray-500">{{ $project->developer->profile->specialization->label() }}</p>
                @else
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->client->name }}</p>
                    <p class="text-xs text-gray-500">Client</p>
                @endif
            </div>
        </div>
        
        {{-- Stats --}}
        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <div class="flex items-center space-x-4">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ $stats['views'] }}
                </span>
                <span class="flex items-center {{ $isLiked ? 'text-red-500' : '' }}">
                    <svg class="w-4 h-4 mr-1 {{ $isLiked ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ $stats['likes'] }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.003 9.003 0 00-8.354-5.834M3 15.436c-1.087 1.286-2.019 2.833-2.019 2.833 0 1.552.455 2.883 1.163 1.163 0 2.019-.732 2.019-2.833 0-1.552-.455-2.883-1.163C3.455 11.882 3 10.879 3 9.5c0-4.418 4.03-8 9-8s9 3.582 9 8c0 1.378.455 2.719 1.163 2.883 1.163 1.552 0 2.019-.732 2.019-2.833z" />
                    </svg>
                    {{ $stats['reviews'] }}
                </span>
            </div>
            <div class="flex items-center">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($stats['rating']))
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    @endif
                @endfor
                <span class="ml-1">{{ number_format($stats['rating'], 1) }}</span>
            </div>
        </div>
        
        {{-- Expanded Details --}}
        @if($showDetails)
            <div class="border-t border-gray-200 pt-4 mt-4">
                {{-- Technologies --}}
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Technologies utilisées</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                {{-- Budget --}}
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Budget</h3>
                    <p class="text-lg font-bold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} XAF</p>
                </div>
                
                {{-- Deadline --}}
                @if($project->deadline)
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Date limite</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $project->deadline->format('d/m/Y') }}</p>
                    </div>
                @endif
                
                {{-- Actions --}}
                <div class="flex space-x-3">
                    <button class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200">
                        Contacter le développeur
                    </button>
                    <a href="{{ route('projects.detail', $project->id) }}" 
                       class="flex-1 border border-primary text-primary px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors duration-200 text-center">
                        Voir le projet complet
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
        @else
            <div class="flex items-center justify-center h-full">
                <svg class="w-20 h-20 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 013.657-3.657 3.657h3.414a2 2 0 011.414 1.414L16 16l-4.586 4.586a2 2 0 01-3.657-3.657 3.657H6.414A2 2 0 015 14.586 12L4 16z" />
                </svg>
            </div>
        @endif
        
        <!-- Overlay with Actions -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
            <div class="absolute top-4 right-4 flex space-x-2">
                @if($project->is_featured)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-400 text-yellow-900">
                        ⭐ Vedette
                    </span>
                @endif
                
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/90 text-white">
                    {{ $project->category ?? 'Web' }}
                </span>
            </div>
            
            <div class="absolute bottom-4 left-4 right-4">
                <h3 class="text-xl font-bold text-white mb-1 line-clamp-1">{{ $project->title }}</h3>
                <p class="text-sm text-white/90 line-clamp-2">{{ $project->description }}</p>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        <!-- Developer Info -->
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                <span class="text-primary font-semibold">{{ $project->developer->initials() }}</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->developer->name }}</p>
                <p class="text-xs text-gray-500">{{ $project->developer->profile->specialization->label() }} • {{ $project->developer->profile->experience_years }} ans</p>
            </div>
            <div class="text-right">
                <div class="flex items-center text-yellow-500">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($project->developer->average_rating))
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        @elseif($i - 0.5 <= $project->developer->average_rating)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        @endif
                    @endfor
                    <span class="text-xs text-gray-500 ml-1">({{ $project->developer->average_rating }})</span>
                </div>
            </div>
        </div>
        
        <!-- Technologies -->
        @if($project->technologies && count($project->technologies) > 0)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Technologies utilisées:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($project->technologies, 0, 4) as $tech)
                        <span class="inline-block px-2 py-1 text-xs bg-primary/10 text-primary rounded-full border border-primary/20">
                            {{ $tech }}
                        </span>
                    @endforeach
                    @if(count($project->technologies) > 4)
                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                            +{{ count($project->technologies) - 4 }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Project Details -->
        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
            <div>
                <p class="text-gray-500">Budget</p>
                <p class="font-semibold text-gray-900">{{ number_format($project->budget, 0, ',', ' ') }} XAF</p>
            </div>
            <div>
                <p class="text-gray-500">Durée</p>
                <p class="font-semibold text-gray-900">{{ $project->duration ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Date</p>
                <p class="font-semibold text-gray-900">{{ $project->completed_at?->format('d/m/Y') ?? $project->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Status</p>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ $project->status->label() }}
                </span>
            </div>
        </div>
        
        <!-- Stats Bar -->
        <div class="flex items-center justify-between py-3 border-t border-gray-200 mb-4">
            <div class="flex items-center space-x-4 text-sm text-gray-500">
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
                <span class="flex items-center">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    {{ $project->comments_count }}
                </span>
            </div>
            <span class="text-xs text-gray-400">{{ $project->created_at->diffForHumans() }}</span>
        </div>
        
        <!-- Actions -->
        <div class="flex space-x-3">
            <button wire:click="likeProject({{ $project->id }})" class="flex-1 flex items-center justify-center px-4 py-2 border border-primary text-primary rounded-lg hover:bg-primary/10 transition-colors duration-200">
                <svg class="w-5 h-5 {{ $project->is_liked ? 'text-red-500' : 'text-primary' }} mr-2" fill="{{ $project->is_liked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                {{ $project->is_liked ? 'Liké' : 'Like' }}
            </button>
            
            <button class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200">
                Voir le projet
            </button>
        </div>
    </div>
</div>
