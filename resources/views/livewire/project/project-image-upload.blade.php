{{-- resources/views/livewire/project/project-image-upload.blade.php --}}

<div class="space-y-6">
    {{-- Upload Image Featured --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
            Image Principale
        </h3>

        {{-- Image actuelle --}}
        @if($project->has_featured_image)
            <div class="mb-4">
                <img src="{{ $project->featured_image_url }}" 
                     alt="Image actuelle" 
                     class="w-full h-64 object-cover rounded-lg">
            </div>
        @endif

        {{-- Zone d'upload --}}
        <div class="space-y-4">
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        @if($featuredImage)
                            <img src="{{ $featuredImage->temporaryUrl() }}" 
                                 class="h-48 object-contain mb-4">
                        @else
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF jusqu'à 10MB
                            </p>
                        @endif
                    </div>
                    <input type="file" 
                           wire:model="featuredImage" 
                           accept="image/*" 
                           class="hidden" />
                </label>
            </div>

            @error('featuredImage')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            @if($featuredImage)
                <button wire:click="uploadFeaturedImage" 
                        wire:loading.attr="disabled"
                        class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 disabled:opacity-50">
                    <span wire:loading.remove wire:target="uploadFeaturedImage">
                        Uploader l'image
                    </span>
                    <span wire:loading wire:target="uploadFeaturedImage">
                        Upload en cours...
                    </span>
                </button>
            @endif
        </div>
    </div>

    {{-- Upload Galerie --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
            Galerie d'Images
        </h3>

        {{-- Images actuelles --}}
        @if($project->has_gallery)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @foreach($project->gallery_images_urls as $index => $imageUrl)
                    <div class="relative group">
                        <img src="{{ $imageUrl }}" 
                             alt="Image {{ $index + 1 }}" 
                             class="w-full h-32 object-cover rounded-lg">
                        <button wire:click="deleteGalleryImage({{ $index }})"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer cette image ?"
                                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Zone d'upload multiple --}}
        <div class="space-y-4">
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Sélectionner plusieurs images ({{ count($galleryImages) }} sélectionnée(s))
                        </p>
                    </div>
                    <input type="file" 
                           wire:model="galleryImages" 
                           accept="image/*" 
                           multiple 
                           class="hidden" />
                </label>
            </div>

            @error('galleryImages.*')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            @if(count($galleryImages) > 0)
                <button wire:click="uploadGalleryImages" 
                        wire:loading.attr="disabled"
                        class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 disabled:opacity-50">
                    <span wire:loading.remove wire:target="uploadGalleryImages">
                        Uploader {{ count($galleryImages) }} image(s)
                    </span>
                    <span wire:loading wire:target="uploadGalleryImages">
                        Upload en cours...
                    </span>
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Scripts pour les notifications --}}
@script
<script>
    $wire.on('imageUploaded', (event) => {
        alert(event.message);
        location.reload();
    });

    $wire.on('imageDeleted', (event) => {
        alert(event.message);
        location.reload();
    });

    $wire.on('uploadError', (event) => {
        alert('Erreur: ' + event.message);
    });
</script>
@endscript