{{-- Sidebar - Informations du projet --}}
<div class="space-y-6">
    {{-- Project Info --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('projects.progress', $project->slug) }}" 
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
