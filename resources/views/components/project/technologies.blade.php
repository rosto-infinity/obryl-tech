{{-- Technologies utilisées --}}
@if($project->technologies && count($project->technologies) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Technologies utilisées</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($project->technologies as $tech)
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-primary/10 text-primary border border-primary/20">
                    {{ $tech }}
                </span>
            @endforeach
        </div>
    </div>
@endif
