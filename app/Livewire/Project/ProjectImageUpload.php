<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectImageUpload extends Component
{
    use WithFileUploads;

    public Project $project;

    public $featuredImage;

    public $galleryImages = [];

    public bool $isUploading = false;

    protected $rules = [
        'featuredImage' => 'nullable|image|max:10240', // 10MB max
        'galleryImages.*' => 'nullable|image|max:5120', // 5MB max par image
    ];

    protected $messages = [
        'featuredImage.image' => 'Le fichier doit être une image.',
        'featuredImage.max' => 'L\'image ne doit pas dépasser 10 MB.',
        'galleryImages.*.image' => 'Chaque fichier doit être une image.',
        'galleryImages.*.max' => 'Chaque image ne doit pas dépasser 5 MB.',
    ];

    /**
     * Upload de l'image featured
     */
    public function uploadFeaturedImage(): void
    {
        $this->validate(['featuredImage' => 'required|image|max:10240']);

        $this->isUploading = true;

        try {
            // Supprimer l'ancienne image si elle existe
            if ($this->project->featured_image && ! str_starts_with($this->project->featured_image, 'http')) {
                Storage::disk('public')->delete($this->project->featured_image);
            }

            // Upload de la nouvelle image
            $path = $this->featuredImage->store('projects/featured', 'public');

            // Mettre à jour le projet
            $this->project->update(['featured_image' => $path]);

            $this->dispatch('imageUploaded', [
                'type' => 'featured',
                'message' => 'Image principale uploadée avec succès!',
            ]);

            $this->reset('featuredImage');
        } catch (\Exception $e) {
            $this->dispatch('uploadError', [
                'message' => 'Erreur lors de l\'upload: '.$e->getMessage(),
            ]);
        } finally {
            $this->isUploading = false;
        }
    }

    /**
     * Upload des images de galerie
     */
    public function uploadGalleryImages(): void
    {
        $this->validate(['galleryImages.*' => 'required|image|max:5120']);

        $this->isUploading = true;

        try {
            $existingImages = $this->project->gallery_images ?? [];
            $newImages = [];

            foreach ($this->galleryImages as $image) {
                $path = $image->store('projects/gallery', 'public');
                $newImages[] = $path;
            }

            // Fusionner avec les images existantes
            $allImages = array_merge($existingImages, $newImages);

            // Mettre à jour le projet
            $this->project->update(['gallery_images' => $allImages]);

            $this->dispatch('imageUploaded', [
                'type' => 'gallery',
                'message' => count($newImages).' image(s) ajoutée(s) à la galerie!',
            ]);

            $this->reset('galleryImages');
        } catch (\Exception $e) {
            $this->dispatch('uploadError', [
                'message' => 'Erreur lors de l\'upload: '.$e->getMessage(),
            ]);
        } finally {
            $this->isUploading = false;
        }
    }

    /**
     * Supprimer une image de la galerie
     */
    public function deleteGalleryImage($index): void
    {
        try {
            $images = $this->project->gallery_images ?? [];

            if (isset($images[$index])) {
                $imagePath = $images[$index];

                // Supprimer du storage si ce n'est pas une URL externe
                if (! str_starts_with($imagePath, 'http')) {
                    Storage::disk('public')->delete($imagePath);
                }

                // Retirer de l'array
                unset($images[$index]);
                $images = array_values($images); // Réindexer

                // Mettre à jour le projet
                $this->project->update(['gallery_images' => $images]);

                $this->dispatch('imageDeleted', [
                    'message' => 'Image supprimée avec succès!',
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('deleteError', [
                'message' => 'Erreur lors de la suppression: '.$e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.project.project-image-upload');
    }
}
