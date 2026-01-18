<div class="space-y-8">
    {{-- Project Info --}}
    <div class="bg-card rounded-md border border-border p-8 shadow-sm">
        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-6">Investissement & temps</h3>
        <div class="space-y-6">
            <div>
                <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase">Budget</p>
                <p class="text-2xl font-bold text-primary tracking-tight">{{ number_format($project->budget ?? 0, 0, ',', ' ') }} <span class="text-xs">XAF</span></p>
            </div>
            @if($project->deadline)
                <div>
                    <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase">Date limite</p>
                    <p class="text-base font-bold text-foreground">{{ $project->deadline->format('d/m/Y') }}</p>
                </div>
            @endif
            @if($project->priority)
                <div>
                    <p class="text-[10px] font-bold text-muted-foreground mb-1 uppercase">Priorité</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold {{ $project->priority->color() }}">
                        {{ $project->priority->label() }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Actor Info (Dev & Client) --}}
    <div class="bg-card rounded-md border border-border p-8 shadow-sm space-y-8">
        {{-- Developer --}}
        @if($project->developer)
            <div>
                <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-4">L'expert</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-muted rounded-md border border-border flex items-center justify-center shrink-0">
                        <span class="text-primary font-bold text-base">{{ $project->developer?->initials() ?? '?' }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-foreground leading-tight">{{ $project->developer?->name }}</p>
                        <p class="text-[10px] font-bold text-muted-foreground mt-0.5">{{ $project->developer?->profile?->specialization?->label() ?? 'Ingénieur Fullstack' }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Client --}}
        @if($project->client)
            <div class="pt-6 border-t border-border/50">
                <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-4">Le partenaire</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-muted rounded-md border border-border flex items-center justify-center shrink-0">
                        <span class="text-secondary font-bold text-base">{{ $project->client?->initials() ?? '?' }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-foreground leading-tight">{{ $project->client?->name }}</p>
                        <p class="text-[10px] font-bold text-muted-foreground mt-0.5">Partenaire client</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Stats --}}
    <div class="bg-card rounded-md border border-border p-8 shadow-sm">
        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-6">Visibilité</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between py-2 border-b border-border/30 last:border-0">
                <span class="text-xs font-bold text-muted-foreground">Vues</span>
                <span class="text-xs font-bold text-foreground">{{ $stats['views'] }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-border/30 last:border-0">
                <span class="text-xs font-bold text-muted-foreground">Likes</span>
                <span class="text-xs font-bold text-foreground">{{ $stats['likes'] }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-border/30 last:border-0">
                <span class="text-xs font-bold text-muted-foreground">Avis</span>
                <span class="text-xs font-bold text-foreground">{{ $stats['reviews'] }}</span>
            </div>
            <div class="flex items-center justify-between pt-2">
                <span class="text-xs font-bold text-muted-foreground">Note moyenne</span>
                <div class="flex items-center gap-1">
                    <span class="text-secondary mr-1">★</span>
                    <span class="text-xs font-bold text-foreground">{{ number_format($stats['rating'], 1) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="space-y-3">
        <a href="{{ route('projects.progress', $project->slug) }}" 
           class="block w-full bg-primary text-primary-foreground font-bold px-6 py-3 rounded-md hover:translate-y-[-2px] transition-all text-center shadow-lg shadow-primary/20 text-sm">
            Suivre la progression
        </a>
        <button class="w-full bg-card border border-border text-foreground font-bold px-6 py-3 rounded-md hover:bg-muted transition-all text-sm">
            Signaler un problème
        </button>
        <button class="w-full bg-card border border-border text-foreground font-bold px-6 py-3 rounded-md hover:bg-muted transition-all text-sm">
            Partager l'analyse
        </button>
    </div>
</div>
