{{-- Composant pour afficher les informations principales du projet --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informations Principales</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Code du projet --}}
        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Code du projet</label>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                    {{ $project->formatted_code }}
                </span>
                <button 
                    x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('{{ $project->code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="text-xs text-gray-500 hover:text-primary cursor-pointer transition-colors"
                    :title="copied ? 'Copié !' : 'Copier le code'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- URL du projet --}}
        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">URL du projet</label>
            <div class="flex items-center space-x-2">
                <a href="{{ $project->url }}" 
                   target="_blank" 
                   class="text-primary hover:text-secondary text-sm truncate max-w-xs">
                    {{ $project->url }}
                </a>
                <button 
                    x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('{{ $project->url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="text-xs text-gray-500 hover:text-primary cursor-pointer transition-colors"
                    :title="copied ? 'Copié !' : 'Copier l\'URL'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Statut du projet --}}
        @if($project->status)
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
                    {{ $project->status->label() }}
                </span>
            </div>
        @endif

        {{-- Type de projet --}}
        @if($project->type)
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                    {{ $project->type->label() }}
                </span>
            </div>
        @endif
    </div>

    {{-- Informations supplémentaires --}}
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Créé le</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $project->created_at->format('d/m/Y') }}</span>
            </div>
            <div>
                <span class="text-gray-500">Budget</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($project->budget ?? 0, 0, ',', ' ') }} XAF</span>
            </div>
            <div>
                <span class="text-gray-500">Progression</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $project->progress_percentage ?? 0 }}%</span>
            </div>
        </div>
    </div>
</div>
