<div class="space-y-6">
    {{-- Header avec statistiques --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900/50 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Avis des Cliens</h2>
            @if(auth()->user()->can('createReview'))
                <a href="{{ route('reviews.create') }}" wire:navigate class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/80 transition-colors duration-200">
                    + Nouvel Avis
                </a>
            @endif
        </div>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg border border-blue-100 dark:border-blue-800">
                <div class="text-2xl font-bold text-primary">{{ $stats['total'] }}</div>
                <div class="text-sm text-primary dark:text-blue-400">Total</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg border border-green-100 dark:border-green-800">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['approved'] }}</div>
                <div class="text-sm text-green-500 dark:text-green-400">Approuvés</div>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/30 p-4 rounded-lg border border-yellow-100 dark:border-yellow-800">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</div>
                <div class="text-sm text-yellow-500 dark:text-yellow-400">En attente</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/30 p-4 rounded-lg border border-red-100 dark:border-red-800">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['rejected'] }}</div>
                <div class="text-sm text-red-500 dark:text-red-400">Rejetés</div>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-lg border border-purple-100 dark:border-purple-800">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                    {{ number_format($stats['average_rating'] ?? 0, 1) }}
                </div>
                <div class="text-sm text-purple-500 dark:text-purple-400">Note moyenne</div>
            </div>
        </div>

        {{-- Distribution des notes --}}
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Distribution des notes</h3>
            <div class="space-y-2">
                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center">
                        <div class="w-16 text-sm text-gray-700 dark:text-gray-300">{{ $i }} ⭐</div>
                        <div class="flex-1 mx-3 bg-gray-200 dark:bg-gray-700 rounded-full h-6">
                            <div class="bg-yellow-400 dark:bg-yellow-500 h-6 rounded-full transition-all" 
                                 style="width: {{ $stats['approved'] > 0 ? ($ratingDistribution[$i] / $stats['approved']) * 100 : 0 }}%"></div>
                        </div>
                        <div class="w-12 text-sm text-right text-gray-700 dark:text-gray-300">{{ $ratingDistribution[$i] ?? 0 }}</div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Filtres --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Rechercher..."
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-primary/50"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-primary/50">
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvés</option>
                    <option value="rejected">Rejetés</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note</label>
                <select wire:model.live="ratingFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-primary/50">
                    <option value="all">Toutes les notes</option>
                    <option value="5">5 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="2">2 étoiles</option>
                    <option value="1">1 étoile</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Par page</label>
                <select wire:model.live="perPage" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-primary/50">
                    <option value="6">6</option>
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Liste des avis --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($reviews as $review)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900/50 hover:shadow-lg dark:hover:shadow-gray-900/70 transition-shadow duration-200">
                {{-- Header --}}
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $review->project->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Par {{ $review->client->name }} → {{ $review->developer->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-yellow-500">
                                {{ str_repeat('⭐', round($review->rating)) }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($review->rating, 1) }}</div>
                        </div>
                    </div>
                    
                    {{-- Statut --}}
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($review->status === \App\Enums\ReviewStatus::APPROVED) 
                                bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                            @elseif($review->status === \App\Enums\ReviewStatus::PENDING) 
                                bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                            @elseif($review->status === \App\Enums\ReviewStatus::REJECTED) 
                                bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                            @else 
                                bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                            @endif">
                            {{ $review->status->label() }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $review->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>

                {{-- Contenu --}}
                <div class="p-4">
                    @if($review->comment)
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ Str::limit($review->comment, 150) }}</p>
                    @endif
                    
                    {{-- Critères --}}
                    @if($review->criteria && is_array($review->criteria))
                        <div class="space-y-1 mb-3">
                            @foreach($review->criteria as $criterion => $score)
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($criterion) }}</span>
                                    <span class="text-gray-900 dark:text-gray-200 font-medium">{{ $score }}/5</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('reviews.show', $review->id) }}" wire:navigate
                           class="text-primary/80 hover:text-primary dark:hover:text-primary/80 text-sm font-medium transition-colors">
                            Voir les détails
                        </a>
                        
                        @if(auth()->user()->can('updateReview'))
                            <div class="flex space-x-2">
                                @if($review->isPending() || $review->isRejected())
                                    <button wire:click="approveReview({{ $review->id }})" 
                                            class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm transition-colors">
                                        ✅ Approuver
                                    </button>
                                @endif

                                @if($review->isPending() || $review->isApproved())
                                    <button wire:click="rejectReview({{ $review->id }})" 
                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm transition-colors">
                                        ❌ Rejeter
                                    </button>
                                @endif
                            </div>
                        @endif
                        
                        @if(auth()->user()->can('deleteReview') && 
                           (auth()->user()->isClient() && $review->client_id === auth()->id() || auth()->user()->hasRole('super_admin')))
                            <button wire:click="deleteReview({{ $review->id }})" 
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer cet avis ?" 
                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm transition-colors">
                                🗑️ Supprimer
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 dark:text-gray-500 text-lg">Aucun avis trouvé</div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Essayez de modifier vos filtres de recherche</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $reviews->links() }}
    </div>
</div>
