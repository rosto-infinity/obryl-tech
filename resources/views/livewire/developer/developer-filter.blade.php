<div>
    <!-- Filtres Section -->
    <div class="bg-gray-50/95 border-b border-gray-200 sticky top-0 z-40 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Search Bar -->
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce="search"
                            placeholder="Rechercher un développeur, compétence, entreprise..."
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                        >
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Filters Row -->
                <div class="flex flex-wrap gap-3">
                    <!-- Specialization -->
                    <select wire:model.live="specialization" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Spécialisation</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->value }}">{{ $spec->label() }}</option>
                        @endforeach
                    </select>

                    <!-- Availability -->
                    <select wire:model.live="availability" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Disponibilité</option>
                        @foreach($availabilities as $avail)
                            <option value="{{ $avail->value }}">{{ $avail->label() }}</option>
                        @endforeach
                    </select>

                    <!-- Experience -->
                    <select wire:model.live="minExperience" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Expérience</option>
                        <option value="0">Débutant</option>
                        <option value="2">2+ ans</option>
                        <option value="5">5+ ans</option>
                        <option value="10">10+ ans</option>
                    </select>

                    <!-- Skills -->
                    <input 
                        type="text" 
                        wire:model.live.debounce="skills"
                        placeholder="Compétences (ex: PHP, React)"
                        class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                    >

                    <!-- Hourly Rate Range -->
                    <div class="flex gap-2 items-center">
                        <input 
                            type="number" 
                            wire:model.live.debounce="minHourlyRate"
                            placeholder="Min €/h"
                            class="w-24 px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                        >
                        <span class="text-gray-500">-</span>
                        <input 
                            type="number" 
                            wire:model.live.debounce="maxHourlyRate"
                            placeholder="Max €/h"
                            class="w-24 px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                        >
                    </div>

                    <!-- Reset Button -->
                    <button 
                        wire:click="resetFilters"
                        class="px-6 py-3 bg-secondary text-white rounded-lg hover:bg-secondary/90 transition-colors"
                    >
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-black">Développeurs Experts</h1>
                <p class="text-gray-600 mt-1">
                    {{ $developers->total() }} développeur{{ $developers->total() > 1 ? 's' : '' }} trouvé{{ $developers->total() > 1 ? 's' : '' }}
                </p>
            </div>

            <!-- Sort Options -->
            <div class="flex gap-3 items-center">
                <span class="text-sm text-gray-500">Trier par:</span>
                <div class="flex gap-2">
                    <button 
                        wire:click="sortBy('created_at')"
                        class="px-4 py-2 text-sm rounded-lg transition-colors {{ $sortBy === 'created_at' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        Récents
                        @if($sortBy === 'created_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                    <button 
                        wire:click="sortBy('hourly_rate')"
                        class="px-4 py-2 text-sm rounded-lg transition-colors {{ $sortBy === 'hourly_rate' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        Taux horaire
                        @if($sortBy === 'hourly_rate')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                    <button 
                        wire:click="sortBy('average_rating')"
                        class="px-4 py-2 text-sm rounded-lg transition-colors {{ $sortBy === 'average_rating' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        Note
                        @if($sortBy === 'average_rating')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </div>

                <!-- Per Page -->
                <select wire:model.live="perPage" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Developers Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @if($developers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($developers as $profile)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                        <!-- Avatar and Basic Info -->
                        <div class="p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="relative">
                                    @php
                                        $avatar = $profile->user->profile?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($profile->user->name).'&color=10B981&background=F0FDF4';
                                    @endphp
                                    <img src="{{ $avatar }}" alt="{{ $profile->user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                    @if($profile->is_verified)
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-primary rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-black group-hover:text-primary transition-colors">
                                        {{ $profile->user->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $profile->specialization?->label() ?? 'Développeur' }}</p>
                                </div>
                            </div>

                            <!-- Bio -->
                            @if($profile->bio)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $profile->bio }}</p>
                            @endif

                            <!-- Stats -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-bold text-primary">
                                        {{ $profile->hourly_rate ? number_format($profile->hourly_rate, 0, ',', ' ') . '€/h' : 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">Taux horaire</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-bold text-primary">
                                        {{ $profile->years_experience ?? '0' }} ans
                                    </div>
                                    <div class="text-xs text-gray-500">Expérience</div>
                                </div>
                            </div>

                            <!-- Skills -->
                            @if($profile->skills && count($profile->skills) > 0)
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($profile->skills, 0, 4) as $skill)
                                            <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                        @if(count($profile->skills) > 4)
                                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                                                +{{ count($profile->skills) - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Availability Badge -->
                            <div class="mb-4">
                                @php
                                    $availabilityClass = match($profile->availability?->value) {
                                        'available' => 'bg-green-100 text-green-800',
                                        'busy' => 'bg-yellow-100 text-yellow-800',
                                        'unavailable' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $availabilityClass }}">
                                    {{ $profile->availability?->label() ?? 'Non spécifié' }}
                                </span>
                            </div>

                            <!-- CTA Button -->
                            <a href="{{ route('developers.profile', $profile->user->id) }}" wire:navigate 
                               class="w-full block text-center px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-colors font-medium">
                                Voir le profil
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $developers->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-black mb-2">Aucun développeur trouvé</h3>
                <p class="text-gray-600 mb-6">Essayez d'ajuster vos filtres pour trouver des développeurs correspondant à vos critères.</p>
                <button wire:click="resetFilters" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                    Réinitialiser les filtres
                </button>
            </div>
        @endif
    </div>
</div>