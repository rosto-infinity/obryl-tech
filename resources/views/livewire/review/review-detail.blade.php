<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Détail de l'avis</h1>
            <div class="flex items-center space-x-4">
                @can('update', $review)
                    @if($review->status === \App\Enums\ReviewStatus::PENDING)
                        <button wire:click="approve" wire:confirm="Êtes-vous sûr de vouloir approuver cet avis ?" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-500">
                            Approuver
                        </button>
                        <button wire:click="reject" wire:confirm="Êtes-vous sûr de vouloir rejeter cet avis ?" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-500">
                            Rejeter
                        </button>
                    @elseif($review->status === \App\Enums\ReviewStatus::APPROVED)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Approuvé
                        </span>
                    @elseif($review->status === \App\Enums\ReviewStatus::REJECTED)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Rejeté
                        </span>
                    @endif
                @endcan
                <a href="{{ route('reviews.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-2 rounded">
                    ← Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Projet</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $this->review->project->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Client</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $this->review->client->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Développeur</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $this->review->developer->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $this->review->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Note Globale</dt>
                        <dd class="mt-1 text-2xl text-yellow-500 font-bold">
                            {{ $this->review->rating }}/5
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Commentaire</h3>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-700 italic border border-gray-100">
                    "{{ $this->review->comment }}"
                </div>

                @if($this->review->criteria && is_array($this->review->criteria))
                    <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Détail de la notation</h3>
                    <div class="space-y-3">
                        @foreach($this->review->criteria as $criteria => $rating)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 capitalize">{{ $criteria }}</span>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 mr-2">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="h-4 w-4 {{ $i < $rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $rating }}/5</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
