<div class="bg-card rounded-md border border-border p-6 shadow-sm">
    <h3 class="text-lg font-bold text-foreground mb-6">Informations principales</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Code du projet --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Code du projet</label>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-muted text-foreground border border-border">
                    {{ $project->formatted_code }}
                </span>
                <button 
                    x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('{{ $project->code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="text-muted-foreground hover:text-primary transition-colors cursor-pointer"
                    :title="copied ? 'Copié !' : 'Copier le code'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- URL du projet --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider">URL du projet</label>
            <div class="flex items-center space-x-2">
                <a href="{{ $project->url }}" target="_blank"
                   class="text-primary hover:text-secondary text-sm font-medium truncate max-w-[200px]">
                    {{ $project->url }}
                </a>
                <button 
                    x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('{{ $project->url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="text-muted-foreground hover:text-primary transition-colors cursor-pointer"
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
                <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Statut</label>
                <div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold {{ $project->status->color() }}">
                        {{ $project->status->label() }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Type de projet --}}
        @if($project->type)
            <div class="space-y-2">
                <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Type</label>
                <div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-muted text-foreground border border-border">
                        {{ $project->type->label() }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    {{-- Informations supplémentaires --}}
    <div class="mt-8 pt-6 border-t border-border/50">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase tracking-wider">Créé le</p>
                <p class="text-sm font-bold text-foreground">{{ $project->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase tracking-wider">Budget</p>
                <p class="text-sm font-bold text-primary">{{ number_format($project->budget ?? 0, 0, ',', ' ') }} <span class="text-[9px] opacity-70">XAF</span></p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase tracking-wider">Progression</p>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-foreground">{{ $project->progress_percentage ?? 0 }}%</span>
                    <div class="flex-grow bg-muted rounded-full h-1 overflow-hidden">
                        <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: {{ $project->progress_percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
