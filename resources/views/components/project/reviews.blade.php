{{-- Avis des clients --}}
@if($project->reviews && count($project->reviews) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Avis des clients</h2>
        <div class="space-y-4">
            @foreach($project->reviews as $review)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                                <span class="text-primary font-semibold text-sm">{{ $review->client->initials() }}</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $review->client->name }}</h4>
                                <div class="flex items-center mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-500">{{ $review->rating }}/5</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                    </div>
                    <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
