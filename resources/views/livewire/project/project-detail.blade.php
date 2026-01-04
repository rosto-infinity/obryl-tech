<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->title }}</h1>
                    <div class="flex items-center mt-2 space-x-4">
                        {{-- Type --}}
                        @if($project->type)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                                {{ $project->type->label() }}
                            </span>
                        @endif
                        
                        {{-- Status --}}
                        @if($project->status)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
                                {{ $project->status->label() }}
                            </span>
                        @endif
                        
                        {{-- Created Date --}}
                        <span class="text-sm text-gray-500">
                            Créé le {{ $project->created_at }}
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200">
                        Contacter le développeur
                    </button>
                    <button class="border border-primary text-primary px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors duration-200">
                        <livewire:portfolio.project-like :project="$project" />
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Project Image --}}
                @if($project->featured_image)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ $project->featured_image }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-96 object-cover">
                    </div>
                @endif

                {{-- Description --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Description du projet</h2>
                    <div class="prose prose-gray dark:prose-invert max-w-none">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $project->description }}</p>
                    </div>
                </div>

                {{-- Technologies --}}
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Technologies utilisées</h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach($project->technologies as $tech)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-primary/10 text-primary border border-primary/20">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Milestones --}}
                @if($project->milestones && count($project->milestones) > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jalons du projet</h2>
                        <div class="space-y-4">
                            @foreach($project->milestones as $milestone)
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-semibold text-xs">{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $milestone['title'] ?? 'Jalon ' . $loop->iteration }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $milestone['description'] ?? 'Description du jalon' }}</p>
                                        @if(isset($milestone['deadline']))
                                            <p class="text-xs text-gray-500 mt-2">Date limite: {{ $milestone['deadline'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Reviews --}}
                @if($project->reviews && count($project->reviews) > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Avis des clients</h2>
                        <div class="space-y-4">
                            @foreach($project->reviews as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                                                <span class="text-primary font-semibold text-sm">{{ $review->client->initials() }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $review->client->name }}</h4>
                                                <div class="flex items-center mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-2 text-sm text-gray-500">{{ $review->rating }}/5</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Project Info --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informations du projet</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Budget</p>
                            <p class="text-xl font-bold text-primary">{{ number_format($project->budget ?? 0, 0, ',', ' ') }} XAF</p>
                        </div>
                        @if($project->deadline)
                            <div>
                                <p class="text-sm text-gray-500">Date limite</p>
                                <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $project->deadline->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($project->priority)
                            <div>
                                <p class="text-sm text-gray-500">Priorité</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $project->priority->color() }}">
                                    {{ $project->priority->label() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Developer Info --}}
                @if($project->developer && $project->developer->profile)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Développeur</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center">
                                <span class="text-primary font-semibold text-lg">{{ $project->developer->initials() }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $project->developer->name }}</p>
                                @if($project->developer->profile->specialization)
                                    <p class="text-sm text-gray-500">{{ $project->developer->profile->specialization->label() }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            @if($project->developer->profile->availability)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Disponibilité</span>
                                    <span class="text-green-500 font-medium">{{ $project->developer->profile->availability->label() }}</span>
                                </div>
                            @endif
                            @if($project->developer->profile->skill_level)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Niveau</span>
                                    <span class="text-primary font-medium">{{ $project->developer->profile->skill_level->label() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Client Info --}}
                @if($project->client)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Client</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center">
                                <span class="text-secondary font-semibold text-lg">{{ $project->client->initials() }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $project->client->name }}</p>
                                <p class="text-sm text-gray-500">{{ $project->client->email }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Stats --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistiques</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Vues</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $stats['views'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Likes</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $stats['likes'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Avis</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $stats['reviews'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Note moyenne</span>
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
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ number_format($stats['rating'], 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="space-y-3">
                          <a href="{{ route('projects.progress', $project->id) }}" 
                           class="block w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 text-center">
                            Suivre la progression
                        </a>
                        <button class="w-full border border-primary text-primary px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors duration-200">
                            Signaler un problème
                        </button>
                        <button class="w-full border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            Partager le projet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
