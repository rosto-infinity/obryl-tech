<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Profile --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-primary to-secondary h-32"></div>
        <div class="px-8 pb-8">
            <div class="flex items-end -mt-16 mb-6">
                <div class="w-32 h-32 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                    <span class="text-3xl font-bold text-primary">{{ $developer->initials() }}</span>
                </div>
                <div class="ml-6 mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $developer->name }}</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        {{ $developer->profile?->specialization?->label() ?? 'Développeur' }}
                    </p>
                    <div class="flex items-center mt-2 space-x-4">
                        @if($developer->profile?->is_verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                ✓ Développeur vérifié
                            </span>
                        @endif
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @switch($developer->profile?->availability)
                                @case('available')
                                    bg-green-100 text-green-800
                                @break
                                @case('busy')
                                    bg-yellow-100 text-yellow-800
                                @break
                                @case('unavailable')
                                    bg-red-100 text-red-800
                                @break
                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ $developer->profile?->availability?->label() ?? 'Non disponible' }}
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- Bio --}}
            @if($developer->profile?->bio)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Bio</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $developer->profile?->bio }}</p>
                </div>
            @endif
            
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">{{ $stats['completed_projects'] }}</div>
                    <div class="text-sm text-gray-600">Projets complétés</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">{{ number_format($stats['total_earnings'], 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-600">Gains totaux</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">{{ number_format($stats['average_rating'], 1) }}</div>
                    <div class="text-sm text-gray-600">Note moyenne</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">{{ $stats['total_reviews'] }}</div>
                    <div class="text-sm text-gray-600">Avis clients</div>
                </div>
            </div>
            
            {{-- Contact Actions --}}
            <div class="flex space-x-4">
                <button class="flex-1 bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-200">
                    Contacter
                </button>
                <button class="flex-1 border border-primary text-primary px-6 py-3 rounded-lg hover:bg-primary/10 transition-colors duration-200">
                    Voir le portfolio
                </button>
            </div>
        </div>
    </div>
    
    {{-- Skills Section --}}
    @if(count($skillsWithLevels) > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Compétences</h2>
            <div class="space-y-4">
                @foreach($skillsWithLevels as $skill)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $skill['name'] }}</span>
                            <span class="text-sm text-gray-500">{{ $skill['level'] }}/5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all duration-300" style="width: {{ ($skill['level'] / 5) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    {{-- Recent Projects --}}
    @if($projects->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Projets récents</h2>
                <a href="#" class="text-primary hover:text-primary/80 text-sm font-medium">Voir tout</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $project->title }}</h3>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $project->status->label() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">{{ $project->description }}</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Client: {{ $project->client->name }}</span>
                            <span class="font-semibold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} XAF</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    {{-- Reviews Section --}}
    @if($reviews->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Avis clients</h2>
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($stats['average_rating']))
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        @endif
                    @endfor
                    <span class="ml-2 text-sm text-gray-600">({{ $stats['average_rating'] }})</span>
                </div>
            </div>
            
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-gray-600">{{ $review->client->initials() }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $review->client->name }}</p>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
