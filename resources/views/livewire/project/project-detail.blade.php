<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    {{-- Header --}}
    <x-project.header :project="$project" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Project Image and Gallery --}}
                <x-project.gallery :project="$project" />

                {{-- Description --}}
                <x-project.description :project="$project" />

                {{-- Technologies --}}
                <x-project.technologies :project="$project" />

                {{-- Milestones --}}
                <x-project.milestones :project="$project" />

                {{-- Reviews --}}
                <x-project.reviews :project="$project" />
            </div>

            {{-- Sidebar --}}
            <div>
                <x-project.sidebar-info :project="$project" :stats="$stats" />
            </div>
        </div>
    </div>
    
    {{-- Image Gallery Modal --}}
    <x-project.image-gallery-modal :project="$project" />
</div>
