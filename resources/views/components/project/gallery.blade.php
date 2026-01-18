<div class="bg-card rounded-md border border-border overflow-hidden shadow-sm">
    {{-- Featured Image --}}
    @if($project->featured_image_url)
        <div class="relative">
            <img src="{{ $project->featured_image_url }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-96 lg:h-[32rem] object-cover transition-transform duration-1000">
            @if($project->is_featured)
                <div class="absolute top-6 left-6 bg-secondary text-secondary-foreground px-3 py-1 rounded-md text-[10px] font-bold shadow-lg">
                    En vedette
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>
    @else
        <div class="w-full h-80 bg-muted flex items-center justify-center">
            <div class="text-center opacity-40">
                <svg class="w-12 h-12 text-muted-foreground mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586 1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-xs font-bold uppercase tracking-widest">Aucune image disponible</p>
            </div>
        </div>
    @endif
    
    {{-- Gallery --}}
    @if($project->gallery_image_urls && count($project->gallery_image_urls) > 0)
        <div class="border-t border-border/50 bg-muted/10 p-8 lg:p-10">
            <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-6">Galerie de déploiement</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($project->gallery_image_urls as $index => $image)
                    <div class="relative group cursor-pointer aspect-square rounded-md overflow-hidden border border-border/50" onclick="openImageModal('{{ $image }}', '{{ $project->title }} - Image {{ $index + 1 }}')">
                        <img src="{{ $image }}" 
                             alt="{{ $project->title }} - Image {{ $index + 1 }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 18v-3m0 0h3"/>
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
