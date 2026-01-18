@if($project->reviews && count($project->reviews) > 0)
    <div class="bg-card rounded-md border border-border p-8 shadow-sm">
        <h2 class="text-xl font-bold text-foreground mb-8">Expertises client</h2>
        <div class="space-y-8">
            @foreach($project->reviews as $review)
                <div class="border-b border-border/30 pb-8 last:border-0 last:pb-0 group">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-muted rounded-md border border-border flex items-center justify-center shrink-0">
                                <span class="text-primary font-bold text-sm">{{ $review->client?->initials() ?? '?' }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-foreground text-sm uppercase leading-tight">{{ $review->client?->name }}</h4>
                                <div class="flex items-center mt-1.5 text-secondary gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-muted/30' }}" viewBox="0 0 24 24">
                                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">{{ $review->created_at->format('d/m/Y') }}</span>
                    </div>
                    <blockquote class="mt-6 text-foreground/80 font-medium leading-relaxed italic text-sm">
                        "{{ $review->comment }}"
                    </blockquote>
                </div>
            @endforeach
        </div>
    </div>
@endif
