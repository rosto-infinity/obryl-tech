{{-- Galerie d'images du projet --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
    {{-- Featured Image --}}
    @if($project->featured_image_url)
        <div class="relative">
            <img src="{{ $project->featured_image_url }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-96 object-cover">
            @if($project->is_featured)
                <div class="absolute top-4 right-4 bg-yellow-400 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center space-x-1">
                    <span>⭐</span>
                    <span>En vedette</span>
                </div>
            @endif
        </div>
    @else
        {{-- Placeholder si pas d'image --}}
        <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586 1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 text-sm">Aucune image disponible</p>
            </div>
        </div>
    @endif
    
    {{-- Gallery --}}
    @if($project->gallery_image_urls && count($project->gallery_image_urls) > 0)
        <div class="border-t border-gray-200 dark:border-gray-700">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Galerie d'images</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($project->gallery_image_urls as $index => $image)
                        <div class="relative group cursor-pointer" onclick="openImageModal('{{ $image }}', '{{ $project->title }} - Image {{ $index + 1 }}')">
                            <img src="{{ $image }}" 
                                 alt="{{ $project->title }} - Image {{ $index + 1 }}" 
                                 class="w-full h-32 object-cover rounded-lg transition-transform duration-200 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-opacity-30 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 18v-3m0 0h3"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
