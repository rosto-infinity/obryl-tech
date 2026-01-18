<div class="space-y-8">
    {{-- Header with statistics --}}
    <div class="bg-card rounded-md border border-border p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center mb-10 gap-8">
            <div class="space-y-1">
                <h2 class="text-3xl font-bold text-foreground tracking-tight">réseau d'<span class="text-primary italic">excellence</span></h2>
                <p class="text-muted-foreground font-medium text-base">Sélection rigoureuse des meilleurs talents en ingénierie.</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="bg-muted/50 px-5 py-3 rounded-md border border-border">
                    <p class="text-[10px] font-bold text-muted-foreground mb-1">architectes</p>
                    <span class="text-foreground font-bold text-xl">{{ $stats['total'] }}</span>
                </div>
                <div class="bg-primary/5 px-5 py-3 rounded-md border border-primary/10">
                    <p class="text-[10px] font-bold text-primary mb-1">vérifiés</p>
                    <span class="text-primary font-bold text-xl">{{ $stats['verified'] }}</span>
                </div>
                <div class="bg-secondary/5 px-5 py-3 rounded-md border border-secondary/10">
                    <p class="text-[10px] font-bold text-secondary mb-1">actifs</p>
                    <span class="text-secondary font-bold text-xl">{{ $stats['available'] }}</span>
                </div>
            </div>
        </div>
        
        {{-- Filters --}}
        <div class="space-y-8 pt-8 border-t border-border/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2 space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Identification</label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="Nom, technologie, expertise..."
                            class="w-full pl-10 pr-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-medium text-foreground placeholder-muted-foreground"
                        />
                        <svg class="w-4 h-4 text-muted-foreground absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Spécialisation</label>
                    <div class="relative">
                        <select wire:model.live="specializationFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="all">Toutes disciplines</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec['value'] }}">{{ $spec['label'] ?? $spec['value'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Flux d'Activité</label>
                    <div class="relative">
                        <select wire:model.live="availabilityFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="all">Tous statuts</option>
                            @foreach($availabilityOptions as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Classement</label>
                    <div class="relative">
                        <select wire:model.live="sortBy" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                            <option value="name">Lexique</option>
                            <option value="rating">Évaluation</option>
                            <option value="experience">Ancienneté</option>
                            <option value="projects">Volume de projets</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-2">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" wire:model.live="showVerifiedOnly" class="sr-only peer">
                        <div class="w-9 h-5 bg-muted rounded-full peer peer-checked:bg-primary after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-card after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                    </div>
                    <span class="ml-3 text-xs font-bold text-muted-foreground group-hover:text-foreground transition-colors">Développeurs certifiés</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Maestro Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($developers as $developer)
            <div wire:key="developer-{{ $developer->id }}" class="group bg-card rounded-md p-8 border border-border hover:border-primary/20 hover:shadow-lg transition-all duration-500 flex flex-col h-full">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-16 h-16 bg-muted rounded-md flex items-center justify-center border border-border overflow-hidden transition-transform duration-500 group-hover:scale-105">
                                @if($developer->avatar_url)
                                    <img src="{{ $developer->avatar_url }}" alt="{{ $developer->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-bold text-primary">{{ $developer->initials() }}</span>
                                @endif
                            </div>
                            @if($developer->profile?->availability === 'available')
                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-primary border-2 border-card rounded-full shadow-sm"></span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-lg font-bold text-foreground leading-tight tracking-tight">{{ $developer->name }}</h3>
                            @if($developer->profile?->is_verified)
                                <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded border border-primary/10">
                                    Certifié
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6 flex-grow">
                    <div class="grid grid-cols-2 gap-4 pb-6 border-b border-border/50">
                        <div>
                            <p class="text-[10px] font-bold text-muted-foreground mb-1">Expertise</p>
                            <p class="text-xs font-bold text-foreground truncate">{{ $developer->profile?->specialization ?? 'Ingénieur Fullstack' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-muted-foreground mb-1">Expérience</p>
                            <p class="text-xs font-bold text-foreground">{{ $developer->profile?->years_experience ?? 0 }} an(s)</p>
                        </div>
                    </div>
                    
                    @if($developer->profile?->bio)
                        <p class="text-muted-foreground text-sm leading-relaxed font-medium line-clamp-3 italic">
                            "{{ $developer->profile->bio }}"
                        </p>
                    @endif

                    @if($developer->profile?->skills)
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($developer->profile->skills, 0, 4) as $skill)
                                <span class="px-2.5 py-1 bg-muted text-foreground text-[10px] font-bold rounded border border-border">
                                    {{ $skill['name'] ?? $skill }}
                                </span>
                            @endforeach
                            @if(count($developer->profile->skills) > 4)
                                <span class="px-2.5 py-1 bg-muted text-muted-foreground text-[10px] font-bold rounded border border-border">
                                    +{{ count($developer->profile->skills) - 4 }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
                
                <div class="mt-8 pt-6 border-t border-border/50 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        @if($developer->profile?->average_rating > 0)
                            <div class="flex items-center text-xs font-bold text-foreground">
                                <span class="text-secondary mr-1.5 text-base leading-none">★</span>
                                {{ number_format($developer->profile->average_rating, 1) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-muted-foreground">Livrables</span>
                            <span class="text-xs font-bold text-foreground">{{ $developer->profile?->completed_projects_count ?? 0 }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                         <a href="{{ route('developers.profile', $developer->slug) }}" wire:navigate class="px-4 py-2 bg-foreground dark:bg-muted text-background dark:text-foreground text-[11px] font-bold rounded-md hover:bg-primary hover:text-primary-foreground transition-all duration-300">
                            Profil
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-md bg-muted border border-border text-foreground hover:border-primary hover:text-primary transition-all duration-300">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center border-2 border-dashed border-border rounded-md opacity-60 bg-muted/10">
                <h3 class="text-xl font-bold text-foreground mb-1">Aucun maestro trouvé</h3>
                <p class="text-muted-foreground text-xs font-medium">Le talent est en cours d'indexation.</p>
            </div>
        @endforelse
    </div>

    @if($developers->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $developers->links() }}
        </div>
    @endif
</div>
