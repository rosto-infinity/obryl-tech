<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- En-tête --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
                Ce que disent nos clients
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500 dark:text-gray-400">
                Découvrez les retours d'expérience de ceux qui nous font confiance pour leurs projets digitaux.
            </p>
            
            {{-- Note Globale --}}
            <div class="mt-8 flex justify-center items-center space-x-4">
                <div class="flex items-center">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white mr-2">{{ number_format($stats['avg'], 1) }}</span>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="h-6 w-6 {{ $i < round($stats['avg']) ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                <div class="text-gray-500 dark:text-gray-400">
                    Basé sur {{ $stats['count'] }} avis vérifiés
                </div>
            </div>
        </div>

        {{-- Grille d'avis --}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($reviews as $review)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden transform hover:-translate-y-1 transition duration-300">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0">
                                @if($review->client && $review->client->avatar)
                                    <img class="h-10 w-10 rounded-full" src="{{ Storage::url($review->client->avatar) }}" alt="{{ $review->client->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                        {{ substr($review->client->name ?? 'A', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $review->client->name ?? 'Client Anonyme' }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Projet : {{ $review->project->title ?? 'Non spécifié' }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex mb-4 text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 {{ $i < $review->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 italic mb-4">
                            "{{ Str::limit($review->comment, 200) }}"
                        </p>

                        @if($review->developer)
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                Développé par
                            </span>
                            <span class="text-xs font-medium text-primary dark:text-primary">
                                {{ $review->developer->name }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
