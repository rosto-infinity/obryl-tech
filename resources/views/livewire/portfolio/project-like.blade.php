<button 
    wire:click="toggleLike" 
    class="relative group inline-flex items-center justify-center p-2 rounded-full transition-all duration-200 {{ $isLiked ? 'bg-red-100 text-red-500' : 'bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500' }}"
    title="{{ $isLiked ? 'Retirer le like' : 'Ajouter un like' }}"
>
    <svg class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    
    {{-- Badge avec nombre de likes --}}
    @if($showCount && $likesCount > 0)
        <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
            {{ $likesCount }}
        </span>
    @endif
    
    {{-- Animation de like --}}
    @if($isLiked)
        <div class="absolute inset-0 rounded-full bg-red-500 animate-ping opacity-75"></div>
    @endif
</button>

{{-- Tooltip --}}
@if($showTooltip)
    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
        {{ $isLiked ? 'Vous aimez ce projet' : 'Aimer ce projet' }}
        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
            <div class="border-4 border-transparent border-t-gray-900"></div>
        </div>
    </div>
@endif
