<button 
    wire:click="toggleLike" 
    class="relative group inline-flex items-center justify-center p-3 rounded-full transition-all duration-300 {{ $isLiked ? 'bg-red-100 text-red-500 hover:bg-red-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}"
    title="{{ $isLiked ? 'Retirer le like' : 'Ajouter un like' }}"
    x-data="{ tooltip: '{{ $isLiked ? 'Retirer le like' : 'Ajouter un like' }}' }"
    x-tooltip="placement=top"
>
    {{-- Heart Icon --}}
    <svg class="w-5 h-5 transition-all duration-300 {{ $isLiked ? 'scale-110 fill-current text-red-500' : 'scale-100 text-gray-400' }}" 
         fill="none" 
         stroke="currentColor" 
         viewBox="0 0 24 24" 
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 scale-75" 
         x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-75">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    
    {{-- Like Count Badge --}}
    @if($likeCount > 0)
        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white text-xs font-bold shadow-lg">
            {{ $likeCount }}
        </span>
    @endif
    
    {{-- Tooltip --}}
    <div x-show="tooltip" 
         class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-xl whitespace-nowrap z-50"
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 scale-75 translate-y-2" 
         x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-150" 
         x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
         x-transition:leave-end="opacity-0 scale-75 translate-y-2">
        {{ $isLiked ? '❤️ Vous aimez ce projet !' : '🤍 Cliquez pour aimer' }}
    </div>
</button>
