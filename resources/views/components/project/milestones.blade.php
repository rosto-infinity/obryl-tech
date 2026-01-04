{{-- Jalons du projet --}}
@if($project->milestones && count($project->milestones) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jalons du projet</h2>
        <div class="space-y-4">
            @foreach($project->milestones as $milestone)
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                        <span class="text-primary font-semibold text-xs">{{ $loop->iteration }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $milestone['title'] ?? 'Jalon ' . $loop->iteration }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $milestone['description'] ?? 'Description du jalon' }}</p>
                        @if(isset($milestone['deadline']))
                            <p class="text-xs text-gray-500 mt-2">Date limite: {{ $milestone['deadline'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
