<div class="bg-card border-b border-border shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl lg:text-4xl font-bold text-foreground tracking-tight mb-3">{{ $project->title }}</h1>
                <div class="flex flex-wrap items-center gap-4">
                    @if($project->type)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-primary/10 text-primary border border-primary/10">
                            {{ $project->type->label() }}
                        </span>
                    @endif
                    
                    @if($project->status)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold {{ $project->status->color() }}">
                            {{ $project->status->label() }}
                        </span>
                    @endif
                    
                    <span class="text-xs font-medium text-muted-foreground">
                        Lancé le {{ $project->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="bg-primary text-primary-foreground px-6 py-2.5 rounded-md font-bold text-sm hover:translate-y-[-2px] transition-all shadow-lg shadow-primary/20">
                    Contacter l'expert
                </button>
                <button class="bg-card border border-border text-foreground px-4 py-2.5 rounded-md hover:bg-muted transition-colors">
                    <livewire:portfolio.project-like :project="$project" />
                </button>
            </div>
        </div>
    </div>
</div>
