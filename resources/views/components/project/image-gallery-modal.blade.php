{{-- Modal pour la galerie d'images --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" onclick="closeImageModal()"></div>

    <!-- Modal content -->
    <div class="relative h-full flex items-center justify-center p-4">
        <!-- Close button -->
        <button onclick="closeImageModal()"
            class="fixed top-4 right-4 z-50 text-white/80 hover:text-white transition-colors duration-200 bg-black/50 backdrop-blur-sm rounded-full p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Image container - centré et responsive -->
        <div class="relative flex items-center justify-center w-full h-full max-w-7xl max-h-[90vh]">
            <img id="modalImage" src="" alt=""
                class="max-w-full max-h-[90vh] object-contain rounded-lg transition-all duration-300 cursor-pointer"
                onclick="closeImageModal()">

            <!-- Image info -->
            <div class="fixed bottom-0 left-0 right-0 bg-black/80 backdrop-blur-sm text-white p-4">
                <div class="max-w-4xl mx-auto flex items-center justify-between">
                    <div>
                        <p id="modalImageTitle" class="text-lg font-medium"></p>
                        <p class="text-sm text-white/70">Cliquez sur l'image pour fermer</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Navigation buttons -->
                        <button onclick="event.stopPropagation(); navigateImage(-1)"
                            class="bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button onclick="event.stopPropagation(); navigateImage(1)"
                            class="bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <script>
        // Variables globales pour la modal
        let currentImageIndex = 0;
        let galleryImages = [];
        let modalElement = null;
        let modalImageElement = null;
        let modalTitleElement = null;

        // Initialisation au chargement du DOM
        document.addEventListener('DOMContentLoaded', function() {
            modalElement = document.getElementById('imageModal');
            modalImageElement = document.getElementById('modalImage');
            modalTitleElement = document.getElementById('modalImageTitle');

            // Récupérer les images de la galerie
            galleryImages = @json($project->gallery_image_urls ?? []);

            // Gestion des touches du clavier
            document.addEventListener('keydown', function(e) {
                if (modalElement && !modalElement.classList.contains('hidden')) {
                    switch (e.key) {
                        case 'Escape':
                            closeImageModal();
                            break;
                        case 'ArrowLeft':
                            navigateImage(-1);
                            break;
                        case 'ArrowRight':
                            navigateImage(1);
                            break;
                    }
                }
            });

            // Gestion du swipe sur mobile
            let touchStartX = 0;
            let touchEndX = 0;

            modalImageElement?.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            modalImageElement?.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) navigateImage(1); // Swipe gauche
                if (touchEndX > touchStartX + 50) navigateImage(-1); // Swipe droite
            }
        });

        /**
         * Ouvre la modal avec une image spécifique
         */
        function openImageModal(imageSrc, imageTitle) {
            if (!modalElement || !modalImageElement || !modalTitleElement) return;

            // Trouver l'index de l'image actuelle
            currentImageIndex = galleryImages.findIndex(img => img === imageSrc);

            // Afficher l'image
            modalImageElement.src = imageSrc;
            modalTitleElement.textContent = imageTitle;

            // Afficher la modal avec animation
            modalElement.classList.remove('hidden');
            modalElement.classList.add('flex');

            // Empêcher le scroll du body
            document.body.style.overflow = 'hidden';

            // Focus sur l'image pour accessibilité
            modalImageElement.focus();

            // Animation d'entrée fluide
            requestAnimationFrame(() => {
                modalElement.classList.add('opacity-100');
            });
        }

        /**
         * Ferme la modal
         */
        function closeImageModal() {
            if (!modalElement) return;

            // Animation de sortie fluide
            modalElement.classList.remove('opacity-100');

            setTimeout(() => {
                modalElement.classList.add('hidden');
                modalElement.classList.remove('flex');

                // Réactiver le scroll du body
                document.body.style.overflow = '';

                // Nettoyer l'image
                modalImageElement.src = '';
                modalTitleElement.textContent = '';
                
                // Réinitialiser le zoom
                modalImageElement.style.scale = 1;
                modalImageElement.style.transform = '';
            }, 300);
        }

        /**
         * Navigation entre les images
         */
        function navigateImage(direction) {
            if (galleryImages.length === 0) return;

            // Calculer le nouvel index
            currentImageIndex = currentImageIndex + direction;

            // Gérer les boucles
            if (currentImageIndex < 0) {
                currentImageIndex = galleryImages.length - 1;
            } else if (currentImageIndex >= galleryImages.length) {
                currentImageIndex = 0;
            }

            // Mettre à jour l'image avec animation fluide
            const newImageSrc = galleryImages[currentImageIndex];
            const newTitle = `{{ $project->title }} - Image ${currentImageIndex + 1}`;

            // Animation de transition fluide
            modalImageElement.style.opacity = '0';
            modalImageElement.style.transform = 'scale(0.95)';

            setTimeout(() => {
                modalImageElement.src = newImageSrc;
                modalTitleElement.textContent = newTitle;
                modalImageElement.style.opacity = '1';
                modalImageElement.style.transform = 'scale(1)';
            }, 150);
        }

        /**
         * Gestion du zoom avec la molette de la souris
         */
        modalImageElement?.addEventListener('wheel', function(e) {
            e.preventDefault();

            const currentScale = parseFloat(modalImageElement.style.scale || 1);
            const delta = e.deltaY > 0 ? -0.1 : 0.1;
            const newScale = Math.max(0.5, Math.min(3, currentScale + delta));

            modalImageElement.style.scale = newScale;
            modalImageElement.style.cursor = newScale > 1 ? 'zoom-out' : 'zoom-in';
        });

        /**
         * Double-clic pour zoomer/dézoomer
         */
        modalImageElement?.addEventListener('dblclick', function(e) {
            e.preventDefault();

            const currentScale = parseFloat(modalImageElement.style.scale || 1);
            const newScale = currentScale === 1 ? 2 : 1;

            modalImageElement.style.scale = newScale;
            modalImageElement.style.transition = 'scale 0.3s ease';

            setTimeout(() => {
                modalImageElement.style.transition = '';
            }, 300);
        });

        /**
         * Gestion du drag pour déplacer l'image zoomée
         */
        let isDragging = false;
        let startX, startY, scrollLeft, scrollTop;

        modalImageElement?.addEventListener('mousedown', function(e) {
            const scale = parseFloat(modalImageElement.style.scale || 1);
            if (scale <= 1) return;

            isDragging = true;
            modalImageElement.style.cursor = 'grabbing';

            startX = e.pageX - modalImageElement.offsetLeft;
            startY = e.pageY - modalImageElement.offsetTop;
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            e.preventDefault();

            const x = e.pageX - modalImageElement.offsetLeft;
            const y = e.pageY - modalImageElement.offsetTop;
            const walkX = (x - startX) * 2;
            const walkY = (y - startY) * 2;

            modalImageElement.style.transform =
                `scale(${modalImageElement.style.scale || 1}) translate(${walkX}px, ${walkY}px)`;
        });

        document.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                modalImageElement.style.cursor = 'zoom-out';
            }
        });
    </script>
</div>


