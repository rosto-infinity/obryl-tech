<div class="group relative bg-card rounded-md overflow-hidden border border-border hover:border-primary/20 hover:shadow-lg transition-all duration-500 flex flex-col h-full {{ $showDetails ? 'ring-2 ring-primary/10' : '' }}">
    
    {{-- Header with Image --}}
    <div class="relative aspect-[16/10] bg-muted overflow-hidden">
        @php
            $imageUrl = $project->featured_image_url ?? $project->featured_image;
        @endphp
        
        @if($imageUrl)
            <img src="{{ $imageUrl }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center bg-muted/50">
                <div class="w-16 h-16 bg-muted rounded-md flex items-center justify-center border border-border">
                    <span class="text-2xl font-bold text-primary">{{ $project->title[0] ?? 'p' }}</span>
                </div>
            </div>
        @endif
        
        <!-- Action Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        {{-- Type Badge --}}
        <div class="absolute top-4 left-4">
            <span class="px-2.5 py-1 bg-background/90 backdrop-blur-md rounded-md text-[10px] font-bold text-foreground border border-border shadow-sm">
                {{ $project->type->label() }}
            </span>
        </div>
        
        @if($project->is_featured)
            <div class="absolute top-4 right-4">
                <span class="flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                </span>
            </div>
        @endif
        
        {{-- Floating Action Buttons --}}
        <div class="absolute bottom-4 right-4 flex gap-2 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
            <button wire:click="toggleLike" 
                    class="w-10 h-10 rounded-md bg-background border border-border flex items-center justify-center transition-all duration-300 {{ $isLiked ? 'text-primary border-primary shadow-lg shadow-primary/10' : 'text-foreground hover:border-primary' }}">
                <svg class="w-5 h-5 {{ $isLiked ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
            <button wire:click="toggleDetails" 
                    class="w-10 h-10 rounded-md bg-background border border-border text-foreground flex items-center justify-center hover:border-primary transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-6 flex flex-col flex-grow">
        <h2 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-colors tracking-tight leading-tight">{{ $project->title }}</h2>
        
        <p class="text-muted-foreground text-xs leading-relaxed mb-6 font-medium {{ $showDetails ? '' : 'line-clamp-2' }}">
            {{ $project->description }}
        </p>
        
        {{-- Actor Info --}}
        <div class="flex items-center gap-3 py-6 border-t border-border/50">
            <div class="w-10 h-10 bg-muted rounded-md flex items-center justify-center border border-border shrink-0">
                @if($project->developer)
                    <span class="text-primary font-bold text-xs">{{ $project->developer?->initials() ?? '?' }}</span>
                @else
                    <span class="text-primary font-bold text-xs">{{ $project->client?->initials() ?? '?' }}</span>
                @endif
            </div>
            <div class="flex-grow min-w-0">
                @if($project->developer)
                    <p class="text-[11px] font-bold text-foreground truncate">{{ $project->developer?->name }}</p>
                    <p class="text-[9px] font-bold text-muted-foreground truncate">{{ $project->developer?->profile?->specialization?->label() ?? 'expert' }}</p>
                @else
                    <p class="text-[11px] font-bold text-foreground truncate">{{ $project->client?->name }}</p>
                    <p class="text-[9px] font-bold text-muted-foreground truncate">partenaire client</p>
                @endif
            </div>
        </div>
        
        {{-- Stats --}}
        <div class="flex items-center justify-between pt-4 border-t border-border/50 mt-auto">
            <div class="flex items-center gap-6">
                <span class="flex items-center text-[10px] font-bold text-muted-foreground">
                    <svg class="w-3.5 h-3.5 mr-1.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ $stats['views'] }}
                </span>
                <span class="flex items-center text-[10px] font-bold text-muted-foreground">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-primary opacity-70" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ $stats['likes'] }}
                </span>
            </div>
            
            <div class="flex items-center gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    <div class="w-1 h-1 rounded-full {{ $i <= floor($stats['rating']) ? 'bg-secondary' : 'bg-muted' }}"></div>
                @endfor
            </div>
        </div>
        
        {{-- Expanded Details --}}
        @if($showDetails)
            <div class="mt-6 pt-6 border-t border-border/50 animate-in fade-in slide-in-from-top-4 duration-500">
                {{-- Technologies --}}
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="mb-6">
                        <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-3">architecture</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($project->technologies as $tech)
                                <span class="px-2 py-0.5 bg-muted text-foreground text-[9px] font-bold rounded border border-border">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                {{-- Budget & Deadline --}}
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">budget</h3>
                        <p class="text-lg font-bold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} <span class="text-[9px]">XAF</span></p>
                    </div>
                    @if($project->deadline)
                        <div>
                            <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">livraison</h3>
                            <p class="text-xs font-bold text-foreground">{{ $project->deadline->translatedFormat('M Y') }}</p>
                        </div>
                    @endif
                </div>
                
                {{-- Actions --}}
                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-border/50">
                    <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate
                       class="flex-1 px-4 py-2.5 bg-foreground dark:bg-muted text-background dark:text-foreground text-[10px] font-bold rounded-md hover:bg-primary hover:text-primary-foreground transition-all duration-300 text-center shadow-lg shadow-transparent hover:shadow-primary/20">
                        rapport
                    </a>
                    <button class="flex-1 px-4 py-2.5 border border-border text-foreground text-[10px] font-bold rounded-md hover:border-primary hover:text-primary transition-all duration-300">
                        contact
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
