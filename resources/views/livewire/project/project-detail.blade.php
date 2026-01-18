<div class="min-h-screen bg-background">
    {{-- Header --}}
    <x-project.header :project="$project" />

    <div class="max-w-7xl mx-auto px-6 py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- Informations principales --}}
                <x-project.project-info :project="$project" />

                {{-- Project Image and Gallery --}}
                <x-project.gallery :project="$project" />

                {{-- Description --}}
                <x-project.description :project="$project" />

                {{-- Technologies --}}
                <x-project.technologies :project="$project" />

                {{-- Milestones --}}
                <x-project.milestones :project="$project" />

                {{-- Reviews --}}
                <livewire:project.review-form :project="$project" />
                <x-project.reviews :project="$project" />
            </div>

            {{-- Sidebar --}}
            <aside>
                <x-project.sidebar-info :project="$project" :stats="$stats" />
            </aside>
        </div>
    </div>
    
    {{-- Image Gallery Modal --}}
    <x-project.image-gallery-modal :project="$project" />
</div>
