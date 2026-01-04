{{-- Header du projet --}}
<div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->title }}</h1>
                <div class="flex items-center mt-2 space-x-4">
                    {{-- Type --}}
                    @if($project->type)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                            {{ $project->type->label() }}
                        </span>
                    @endif
                    
                    {{-- Status --}}
                    @if($project->status)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
                            {{ $project->status->label() }}
                        </span>
                    @endif
                    
                    {{-- Created Date --}}
                    <span class="text-sm text-gray-500">
                        Créé le {{ $project->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200">
                    Contacter le développeur
                </button>
                <button class="border border-primary text-primary px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors duration-200">
                    <livewire:portfolio.project-like :project="$project" />
                </button>
            </div>
        </div>
    </div>
</div>
