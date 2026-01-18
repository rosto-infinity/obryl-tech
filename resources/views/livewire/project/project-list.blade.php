<div class="space-y-8">
    {{-- Header with statistics --}}
    <div class="bg-card rounded-md border border-border p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center mb-10 gap-8">
            <div class="space-y-1">
                <h2 class="text-3xl font-bold text-foreground tracking-tight">laboratoire de <span class="text-primary italic">projets</span></h2>
                <p class="text-muted-foreground font-medium text-base">Suivi rigoureux et ingénierie d'excellence.</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-muted/50 px-5 py-3 rounded-md border border-border">
                    <p class="text-[10px] font-bold text-muted-foreground mb-1">total</p>
                    <span class="text-foreground font-bold text-xl">{{ $stats['total'] }}</span>
                </div>
                <div class="bg-primary/5 px-5 py-3 rounded-md border border-primary/10">
                    <p class="text-[10px] font-bold text-primary mb-1">publiés</p>
                    <span class="text-primary font-bold text-xl">{{ $stats['published'] }}</span>
                </div>
                <div class="bg-secondary/5 px-5 py-3 rounded-md border border-secondary/10">
                    <p class="text-[10px] font-bold text-secondary mb-1">vedettes</p>
                    <span class="text-secondary font-bold text-xl">{{ $stats['featured'] }}</span>
                </div>
                <div class="bg-foreground/5 px-5 py-3 rounded-md border border-border">
                    <p class="text-[10px] font-bold text-foreground/40 mb-1">en cours</p>
                    <span class="text-foreground font-bold text-xl">{{ $stats['in_progress'] }}</span>
                </div>
            </div>
        </div>
        
        {{-- Filters --}}
        <div class="space-y-8 pt-8 border-t border-border/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2 space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Identification du projet</label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="Rechercher par titre ou technologie..."
                            class="w-full pl-10 pr-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-medium text-foreground placeholder-muted-foreground"
                        />
                        <svg class="w-4 h-4 text-muted-foreground absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Phase</label>
                    <div class="relative">
                        <select wire:model.live="statusFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="all">Tous les flux</option>
                            @foreach($projectStatuses as $status)
                                <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                         <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Nature</label>
                    <div class="relative">
                        <select wire:model.live="typeFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="all">Toutes natures</option>
                            @foreach($projectTypes as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Séquençage</label>
                    <div class="relative">
                        <select wire:model.live="sortBy" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="created_at">Chronologie</option>
                            <option value="title">Lexique</option>
                            <option value="budget">Investissement</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-8 pt-2">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" wire:model.live="showFeaturedOnly" class="sr-only peer">
                        <div class="w-9 h-5 bg-muted rounded-full peer peer-checked:bg-secondary after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-card after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                    </div>
                    <span class="ml-3 text-xs font-bold text-muted-foreground group-hover:text-foreground transition-colors">Vedettes uniquement</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" wire:model.live="showPublishedOnly" class="sr-only peer">
                        <div class="w-9 h-5 bg-muted rounded-full peer peer-checked:bg-primary after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-card after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                    </div>
                    <span class="ml-3 text-xs font-bold text-muted-foreground group-hover:text-foreground transition-colors">Livrables publiés</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Projet List Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @forelse($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="group bg-card rounded-md overflow-hidden border border-border hover:border-primary/20 transition-all duration-500 flex flex-col md:flex-row h-full hover:shadow-lg">
                
                <div class="w-full md:w-2/5 h-48 md:h-auto bg-muted relative shrink-0 overflow-hidden">
                    <img 
                        src="{{ $project->featured_image_url }}" 
                        alt="{{ $project->title }}" 
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 flex flex-wrap gap-1">
                        @foreach(array_slice($project->technologies ?? [], 0, 2) as $tech)
                            <span class="px-2 py-0.5 bg-background/90 backdrop-blur-md text-[9px] font-bold text-foreground rounded-md border border-border/50">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                             @if($project->is_featured)
                                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            @endif
                            <span class="text-[10px] font-bold text-primary">
                                {{ strtolower($project->status->label()) }}
                            </span>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-foreground mb-4 group-hover:text-primary transition-colors leading-tight tracking-tight">
                        {{ $project->title }}
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4 my-6 pt-6 border-t border-border/50">
                        <div>
                            <p class="text-[10px] font-bold text-muted-foreground mb-1">Partenaire</p>
                            <p class="text-xs font-bold text-foreground truncate">{{ $project->client?->name ?? 'Indépendant' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-muted-foreground mb-1">Budget</p>
                            <p class="text-xs font-bold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} <span class="text-[9px] opacity-70">FCFA</span></p>
                        </div>
                    </div>

                    @if($project->progress_percentage)
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[10px] font-bold text-muted-foreground">Progression</span>
                                <span class="text-[10px] font-bold text-foreground">{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-muted rounded-full h-1 overflow-hidden">
                                <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-border/50">
                        <div class="flex items-center gap-6">
                             @if($project->average_rating > 0)
                                <div class="flex items-center text-xs font-bold text-foreground">
                                    <span class="text-secondary mr-1.5 text-base leading-none">★</span>
                                    {{ number_format($project->average_rating, 1) }}
                                </div>
                            @endif
                            <div class="flex items-center text-[10px] font-bold text-muted-foreground">
                                <span class="text-primary mr-1.5 opacity-50">👁</span> {{ $project->views_count ?? 0 }}
                            </div>
                        </div>

                        <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate class="w-10 h-10 rounded-md bg-foreground text-background flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-all duration-300 shadow-lg shadow-transparent hover:shadow-primary/20">
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center border-2 border-dashed border-border rounded-md opacity-60 bg-muted/10">
                <h3 class="text-xl font-bold text-foreground mb-2">Aucun projet trouvé</h3>
                <p class="text-muted-foreground font-medium text-xs">Innovation en cours.</p>
            </div>
        @endforelse
    </div>

    @if($projects->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $projects->links() }}
        </div>
    @endif
</div>