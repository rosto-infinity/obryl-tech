<div>
    @if($reviewSubmitted)
        <div class="bg-primary/5 border border-primary/20 rounded-md p-10 text-center animate-in zoom-in duration-700">
            <div class="flex flex-col items-center justify-center">
                <div class="h-16 w-16 bg-primary/10 rounded-md border border-primary/20 flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-foreground mb-3">Merci pour votre retour</h3>
                <p class="text-muted-foreground font-medium text-base max-w-sm mx-auto">Votre analyse a été enregistrée. Elle sera publiée après validation par nos administrateurs.</p>
            </div>
        </div>
    @elseif($canReview)
        <div class="bg-card rounded-md p-8 lg:p-10 border border-border shadow-sm mb-12">
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-foreground mb-1">Votre avis</h3>
                <p class="text-muted-foreground font-medium text-xs">Contribuez à l'évaluation du projet et partagez votre expérience.</p>
            </div>
            
            <form wire:submit="submit" class="space-y-10">
                {{-- Note Globale --}}
                <div class="space-y-4">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Note globale</label>
                    <div class="flex items-center space-x-2 bg-muted/30 p-4 rounded-md w-fit border border-border/50">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-secondary fill-current' : 'text-muted-foreground/30' }}" viewBox="0 0 24 24">
                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                </div>

                {{-- Critères --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($criteria as $key => $value)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center px-1">
                                <label class="text-xs font-bold text-foreground">{{ $key }}</label>
                                <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded">{{ $value }}/5</span>
                            </div>
                            <div class="relative pt-1">
                                <input type="range" min="1" max="5" step="1" 
                                       wire:model.live="criteria.{{ $key }}"
                                       class="w-full h-1 bg-muted rounded-full appearance-none cursor-pointer accent-primary">
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Commentaire --}}
                <div class="space-y-4">
                    <label class="block text-xs font-bold text-muted-foreground px-1">Analyse qualitative</label>
                    <textarea wire:model="comment" rows="5" 
                              class="w-full p-6 rounded-md bg-muted border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/10 transition-all text-foreground font-medium placeholder:text-muted-foreground/50 text-sm"
                              placeholder="Partagez votre retour d'expérience détaillé..."></textarea>
                    @error('comment') <span class="text-xs text-destructive font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="px-10 py-3.5 bg-foreground dark:bg-muted text-background dark:text-foreground text-sm font-bold rounded-md hover:bg-primary hover:text-primary-foreground transition-all duration-300 shadow-lg shadow-transparent hover:shadow-primary/20">
                        Envoyer mon avis
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
