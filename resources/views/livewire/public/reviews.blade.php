<div class="bg-background min-h-screen pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        {{-- Header --}}
        <div class="text-center mb-24">
            <h1 class="text-4xl md:text-6xl font-bold text-foreground mb-6 tracking-tight">
                écho des <span class="text-primary italic">réalisations</span>
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed font-medium">
                Analyses et témoignages sur nos protocoles de développement et d'ingénierie.
            </p>
            
            {{-- Global Rating Card --}}
            <div class="mt-12 inline-flex flex-col items-center p-8 bg-card rounded-md border border-border shadow-sm">
                <div class="flex items-center gap-6 mb-3">
                    <span class="text-6xl font-bold text-foreground tracking-tight">{{ number_format($stats['avg'], 1) }}</span>
                    <div class="flex flex-col gap-1.5 text-left">
                        <div class="flex text-secondary star-rating">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 {{ $i < round($stats['avg']) ? 'fill-current' : 'text-muted/30' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-[10px] font-bold text-muted-foreground tracking-wide">indice de satisfaction</span>
                    </div>
                </div>
                <div class="text-[10px] font-bold text-foreground pt-4 border-t border-border/50 w-full text-center">
                    sur {{ $stats['count'] }} analyses certifiées
                </div>
            </div>
        </div>

        {{-- Reviews Grid --}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($reviews as $review)
                <div class="group bg-card rounded-md p-8 border border-border hover:border-primary/20 hover:shadow-lg transition-all duration-500 relative overflow-hidden flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-8 relative z-10">
                        <div class="shrink-0">
                            @if($review->client && $review->client->avatar_url)
                                <img class="h-12 w-12 rounded-md object-cover shadow-sm border border-border" src="{{ $review->client->avatar_url }}" alt="{{ $review->client->name }}">
                            @else
                                <div class="h-12 w-12 rounded-md bg-muted border border-border flex items-center justify-center text-primary text-lg font-bold">
                                    {{ substr($review->client->name ?? 'A', 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-foreground leading-tight tracking-tight">
                                {{ $review->client->name ?? 'Partenaire Anonyme' }}
                            </span>
                            <span class="text-[10px] font-bold text-muted-foreground mt-0.5">
                                projet : {{ $review->project->title ?? 'déploiement' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex mb-6 text-secondary">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="h-4 w-4 {{ $i < $review->rating ? 'fill-current' : 'text-muted/30' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>

                    <blockquote class="text-foreground/80 font-medium leading-relaxed italic mb-8 flex-grow relative z-10 text-sm">
                        "{{ $review->comment }}"
                    </blockquote>

                    @if($review->developer)
                    <div class="pt-6 border-t border-border/50 flex items-center justify-between mt-auto relative z-10">
                        <span class="text-[10px] font-bold text-muted-foreground">
                            ingénierie par
                        </span>
                        <span class="text-[10px] font-bold text-primary">
                            {{ $review->developer->name }}
                        </span>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
