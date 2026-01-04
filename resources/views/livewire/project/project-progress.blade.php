<div>
    {{-- Project Progress Page --}}
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('projects.list') }}" 
                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                Projets
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 14.707a1 1 0 01-1.414 0L4.586 10a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('projects.detail', $project->slug) }}" 
                                   class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    {{ $project->title }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 14.707a1 1 0 01-1.414 0L4.586 10a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-2 text-primary font-medium">Progression</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Project Header --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 sm:px-8 sm:py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $project->title }}
                            </h1>
                            <p class="mt-1 text-sm text-gray-500">
                                Code: {{ $project->code }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($project->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-8-8a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Terminé
                                </span>
                            @elseif($project->status === 'in_progress')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0114.004 0V3a1 1 0 00-1-1H4zm16 13a1 1 0 01-1 1V4a1 1 0 00-1-1h-2.101a7.002 7.002 0 00-14.004 0v13.101a1 1 0 001 1H20z" clip-rule="evenodd"/>
                                    </svg>
                                    En cours
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58-9.92c.375-.665.58-1.214.58-1.859 0-.819-.464-1.219-1.219l-5.58 9.92c-.382.675-.58 1.213-.58 1.859 0l-5.58-9.92c-.383-.665-.58-1.213-.58-1.859 0-.819.464-1.219 1.219z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $project->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Overview --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {{-- Overall Progress --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Progression Générale</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">Progression</span>
                                <span class="text-lg font-bold text-primary">{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-primary h-3 rounded-full transition-all duration-300" 
                                     style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Début</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $project->started_at ? \Carbon\Carbon::parse($project->started_at)->format('d/m/Y') : 'Non défini' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Échéance</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : 'Non défini' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Milestones Progress --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Jalons</h3>
                    <div class="space-y-3">
                        @if($milestoneProgress['total'] > 0)
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">Progression des jalons</span>
                                <span class="text-lg font-bold text-primary">
                                    {{ $milestoneProgress['completed'] }}/{{ $milestoneProgress['total'] }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full transition-all duration-300" 
                                     style="width: {{ $milestoneProgress['percentage'] }}%"></div>
                            </div>
                            
                            <div class="mt-4 space-y-3">
                                @php
                                    $milestones = $project->milestones ?? [];
                                @endphp
                                @foreach($milestones as $milestone)
                                    <div class="flex items-start space-x-3 p-3 rounded-lg border {{ $milestone['status'] === 'completed' ? 'bg-green-50 border-green-200' : ($milestone['status'] === 'in_progress' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200') }}">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $milestone['status'] === 'completed' ? 'bg-green-500' : ($milestone['status'] === 'in_progress' ? 'bg-blue-500' : 'bg-gray-400') }}">
                                            @if($milestone['status'] === 'completed')
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-8-8a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <span class="text-white text-xs font-bold">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $milestone['title'] ?? 'Jalon ' . $loop->iteration }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $milestone['description'] ?? 'Description du jalon' }}
                                            </p>
                                            @if(isset($milestone['due_date']))
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Échéance: {{ \Carbon\Carbon::parse($milestone['due_date'])->format('d/m/Y') }}
                                                </p>
                                            @endif
                                            <div class="flex items-center mt-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $milestone['status'] === 'completed' ? 'bg-green-100 text-green-800' : ($milestone['status'] === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    @if($milestone['status'] === 'completed')
                                                        Terminé
                                                    @elseif($milestone['status'] === 'in_progress')
                                                        En cours
                                                    @else
                                                        En attente
                                                    @endif
                                                </span>
                                                @if(isset($milestone['percentage_weight']))
                                                    <span class="ml-2 text-xs text-gray-500">
                                                        {{ $milestone['percentage_weight'] }}%
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 000-2H9z"/>
                                    <path d="M4 4a1 1 0 00-1 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1H4z"/>
                                    <path d="M14 8a1 1 0 00-1 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1h1a1 1 0 001 1H14z"/>
                                    <path d="M6 12a1 1 0 00-1 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1h1a1 1 0 001 1v2a1 1 0 001 1H6z"/>
                                </svg>
                                <p class="mt-2 text-gray-500">Aucun jalon défini pour ce projet</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistiques Rapides</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Budget</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ number_format($project->budget, 0, ',', ' ') }} XAF
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Coût final</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $project->final_cost ? number_format($project->final_cost, 0, ',', ' ') . ' XAF' : 'Non défini' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Équipe</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $teamMembers->count() }} membre{{ $teamMembers->count() > 1 ? 's' : '' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Client</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $project->client->name ?? 'Non assigné' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-center space-x-4 mb-8">
                <a href="{{ route('projects.detail', $project->slug) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Retour au projet
                </a>
                
                @if($project->status === 'in_progress')
                    <button wire:click="markAsCompleted" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/80">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-8-8a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Marquer comme terminé
                    </button>
                @endif
                
                <button wire:click="exportProgress" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1v6a1 1 0 01-1 1H3a1 1 0 01-1-1v-6a1 1 0 011-1h1a1 1 0 011 1v6a1 1 0 001 1H3z" clip-rule="evenodd"/>
                    </svg>
                    Exporter la progression
                </button>
            </div>
        </div>
    </div>
</div>