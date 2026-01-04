{{-- resources/views/projects/upload-images.blade.php --}}


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Upload d'Images - {{ $project->title }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Gérez les images de votre projet
            </p>
        </div>

        <livewire:project.project-image-upload :project="$project" />

        <div class="mt-6">
            <a href="{{ route('projects.detail', $project->slug) }}" 
               class="text-primary hover:underline">
                ← Retour au projet
            </a>
        </div>
    </div>
