<button 
    wire:click="toggleLike" 
    class="relative group inline-flex items-center justify-center p-2.5 rounded-md transition-all duration-300 {{ $isLiked ? 'bg-primary/10 text-primary border border-primary/20 shadow-sm shadow-primary/10' : 'bg-muted border border-border text-muted-foreground hover:border-primary/50 hover:text-primary' }}"
    title="{{ $isLiked ? 'retirer le like' : 'ajouter un like' }}"
>
    {{-- Heart Icon --}}
    <svg class="w-4 h-4 transition-all duration-300 {{ $isLiked ? 'scale-110 fill-current' : 'scale-100' }}" 
         fill="none" 
         stroke="currentColor" 
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    
    {{-- Like Count Badge --}}
    @if($likeCount > 0)
        <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-md bg-foreground text-background text-[9px] font-bold shadow-sm">
            {{ $likeCount }}
        </span>
    @endif
</button>
