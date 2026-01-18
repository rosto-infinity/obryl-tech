<div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">
    {{-- Header Profile --}}
    <div class="bg-card rounded-md border border-border overflow-hidden mb-12 shadow-sm">
        <div class="p-8 lg:p-12">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8 lg:gap-12">
                <div class="w-32 h-32 bg-muted rounded-md border border-border shadow-sm flex items-center justify-center shrink-0 overflow-hidden">
                    @if($developer->avatar_url)
                        <img src="{{ $developer->avatar_url }}" alt="{{ $developer->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-primary">{{ $developer->initials() }}</span>
                    @endif
                </div>
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-4xl font-bold text-foreground tracking-tight mb-2">{{ $developer->name }}</h1>
                    <p class="text-lg text-muted-foreground font-medium mb-6">
                        {{ $developer->profile?->specialization?->label() ?? 'Ingénieur Fullstack' }}
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-4">
                        @if($developer->profile?->is_verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-primary/10 text-primary border border-primary/10">
                                Certifié
                            </span>
                        @endif
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold border
                            @switch($developer->profile?->availability)
                                @case('available')
                                    bg-green-500/10 text-green-600 border-green-500/20
                                @break
                                @case('busy')
                                    bg-yellow-500/10 text-yellow-600 border-yellow-500/20
                                @break
                                @case('unavailable')
                                    bg-red-500/10 text-red-600 border-red-500/20
                                @break
                                @default
                                    bg-muted text-muted-foreground border-border
                            @endswitch
                        ">
                            {{ $developer->profile?->availability?->label() ?? 'Non disponible' }}
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-col gap-3 min-w-[200px]">
                    <button class="w-full bg-primary text-primary-foreground font-bold px-6 py-3 rounded-md hover:translate-y-[-2px] transition-all shadow-lg shadow-primary/20">
                        Contacter l'expert
                    </button>
                    <button disabled class="w-full border border-border text-muted-foreground/60 font-bold px-6 py-3 rounded-md cursor-not-allowed text-sm">
                        Voir le portfolio
                    </button>
                </div>
            </div>
            
            {{-- Bio --}}
            @if($developer->profile?->bio)
                <div class="mt-12 pt-10 border-t border-border/50">
                    <h3 class="text-xs font-bold text-muted-foreground tracking-wider mb-4">À propos</h3>
                    <p class="text-foreground/80 font-medium leading-relaxed max-w-4xl italic text-lg">
                        "{{ $developer->profile?->bio }}"
                    </p>
                </div>
            @endif
            
            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                <div class="p-6 rounded-md bg-muted/30 border border-border/50 transition-colors hover:bg-muted/50">
                    <div class="text-3xl font-bold text-foreground mb-1">{{ $stats['completed_projects'] }}</div>
                    <div class="text-xs font-bold text-muted-foreground">Projets livrés</div>
                </div>
                <div class="p-6 rounded-md bg-muted/30 border border-border/50 transition-colors hover:bg-muted/50">
                    <div class="text-3xl font-bold text-foreground mb-1">{{ number_format($stats['total_earnings'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-xs font-bold text-muted-foreground">Gains (XAF)</div>
                </div>
                <div class="p-6 rounded-md bg-muted/30 border border-border/50 transition-colors hover:bg-muted/50">
                    <div class="text-3xl font-bold text-foreground mb-1">{{ number_format($stats['average_rating'], 1) }}</div>
                    <div class="text-xs font-bold text-muted-foreground">Note moyenne</div>
                </div>
                <div class="p-6 rounded-md bg-muted/30 border border-border/50 transition-colors hover:bg-muted/50">
                    <div class="text-3xl font-bold text-foreground mb-1">{{ $stats['total_reviews'] }}</div>
                    <div class="text-xs font-bold text-muted-foreground">Avis certifiés</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        {{-- Left: Skills --}}
        <div class="lg:col-span-1 space-y-12">
            @if(count($skillsWithLevels) > 0)
                <div class="bg-card rounded-md p-8 border border-border shadow-sm">
                    <h2 class="text-xl font-bold text-foreground mb-8">Maîtrise technique</h2>
                    <div class="space-y-6">
                        @foreach($skillsWithLevels as $skill)
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-foreground">{{ $skill['name'] }}</span>
                                    <span class="text-xs font-bold text-primary">{{ $skill['level'] }}/5</span>
                                </div>
                                <div class="w-full bg-muted rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: {{ ($skill['level'] / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Projects & Reviews --}}
        <div class="lg:col-span-2 space-y-12">
            @if($projects->count() > 0)
                <div class="bg-card rounded-md p-8 border border-border shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-bold text-foreground">Projets récents</h2>
                        <a href="{{ route('projects.list') }}" class="text-primary hover:text-primary/80 text-sm font-bold">Voir tout</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($projects as $project)
                            <div class="group border border-border/50 rounded-md p-6 hover:border-primary/20 hover:shadow-md transition-all h-full flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-primary/10 text-primary rounded">
                                        {{ $project->status->label() }}
                                    </span>
                                </div>
                                <p class="text-sm text-muted-foreground font-medium line-clamp-2 mb-6 flex-grow">{{ $project->description }}</p>
                                <div class="flex items-center justify-between pt-4 border-t border-border/50 text-xs mt-auto">
                                    <span class="font-bold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} <span class="text-[9px] opacity-70">XAF</span></span>
                                    <a href="{{ route('projects.detail', $project->slug) }}" class="text-foreground hover:text-primary transition-colors font-bold">Détails</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($reviews->count() > 0)
                <div class="bg-card rounded-md p-8 border border-border shadow-sm">
                    <h2 class="text-xl font-bold text-foreground mb-8">Derniers avis</h2>
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="p-6 rounded-md bg-muted/20 border border-border/50 group">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-card rounded-md flex items-center justify-center border border-border">
                                            <span class="text-sm font-bold text-primary">{{ $review->client->initials() }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-foreground">{{ $review->client->name }}</p>
                                            <div class="flex items-center text-secondary gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-muted/30' }}" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-muted-foreground">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <blockquote class="text-foreground/80 font-medium leading-relaxed italic text-sm">
                                    "{{ $review->comment }}"
                                </blockquote>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
