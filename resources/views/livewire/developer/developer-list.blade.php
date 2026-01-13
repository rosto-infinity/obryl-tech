<div class="space-y-6">
    {{-- Header avec statistiques --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Développeurs</h2>
            <div class="flex space-x-4 text-sm">
                <div class="bg-secondary/50 px-3 py-1 rounded-full">
                    <span class="text-primary font-medium">{{ $stats['total'] }}</span>
                    <span class="text-blue-500">Total</span>
                </div>
                <div class="bg-green-50 px-3 py-1 rounded-full">
                    <span class="text-green-600 font-medium">{{ $stats['verified'] }}</span>
                    <span class="text-green-500">Vérifiés</span>
                </div>
                <div class="bg-purple-50 px-3 py-1 rounded-full">
                    <span class="text-purple-600 font-medium">{{ $stats['available'] }}</span>
                    <span class="text-purple-500">Disponibles</span>
                </div>
            </div>
        </div>
        
        {{-- Filtres --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Nom, email, bio..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Spécialisation</label>
                <select wire:model.live="specializationFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Toutes</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec['value'] }}">{{ $spec['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilité</label>
                <select wire:model.live="availabilityFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Toutes</option>
                    @foreach($availabilityOptions as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="name">Nom</option>
                    <option value="rating">Note</option>
                    <option value="experience">Expérience</option>
                    <option value="projects">Projets</option>
                    <option value="created_at">Date d'inscription</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" wire:model.live="showVerifiedOnly" class="rounded border-gray-300 text-primary focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Vérifiés seulement</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Liste des développeurs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($developers as $developer)
            <div wire:key="developer-{{ $developer->id }}" class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                {{-- Header --}}
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold">
                                {{ $developer->initials() }}
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">{{ $developer->name }}</h3>
                                @if($developer->profile?->is_verified)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Vérifié
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($developer->profile?->availability)
                            <div class="flex items-center">
                                @switch($developer->profile->availability)
                                    @case('available')
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        <span class="ml-1 text-xs text-green-600">Disponible</span>
                                        @break
                                    @case('busy')
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                                        <span class="ml-1 text-xs text-yellow-600">Occupé</span>
                                        @break
                                    @case('unavailable')
                                        <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                                        <span class="ml-1 text-xs text-red-600">Indisponible</span>
                                        @break
                                @endswitch
                            </div>
                        @endif
                    </div>
                    
                    {{-- Spécialisation et expérience --}}
                    <div class="mb-4">
                        @if($developer->profile?->specialization)
                            <div class="text-sm text-gray-600 mb-1">
                                <span class="font-medium">Spécialisation:</span> {{ $developer->profile->specialization }}
                            </div>
                        @endif
                        
                        @if($developer->profile?->years_experience)
                            <div class="text-sm text-gray-600 mb-1">
                                <span class="font-medium">Expérience:</span> {{ $developer->profile->years_experience }} an(s)
                            </div>
                        @endif
                        
                        @if($developer->profile?->hourly_rate)
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Taux horaire:</span> {{ number_format($developer->profile->hourly_rate, 0, ',', ' ') }} FCFA
                            </div>
                        @endif
                    </div>
                    
                    {{-- Bio --}}
                    @if($developer->profile?->bio)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 line-clamp-3">{{ Str::limit($developer->profile->bio, 150) }}</p>
                        </div>
                    @endif
                    
                    {{-- Statistiques --}}
                    <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            @if($developer->profile?->average_rating > 0)
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★</span>
                                    <span class="ml-1">{{ number_format($developer->profile->average_rating, 1) }}</span>
                                    <span class="text-gray-400 ml-1">({{ $developer->profile->total_reviews_count ?? 0 }})</span>
                                </div>
                            @else
                                <span class="text-gray-400">Pas encore noté</span>
                            @endif
                        </div>
                        
                        <div>
                            <span class="font-medium">{{ $developer->profile->completed_projects_count ?? 0 }}</span> projets
                        </div>
                        
                        <div>
                            <span class="font-medium">{{ number_format($developer->profile->total_earned ?? 0, 0, ',', ' ') }}</span> FCFA
                        </div>
                    </div>
                    
                    {{-- Compétences --}}
                    @if($developer->profile?->skills)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @php
                                    // $skills = json_decode($developer->profile->skills, true) ?? [];
                                    $skills = $developer->profile->skills;
                                    $displayedSkills = array_slice($skills, 0, 3);
                                @endphp
                                @foreach($displayedSkills as $skill)
                                    <span class="inline-block px-2 py-1 text-xs bg-secondary/10 text-black rounded">
                                        {{ $skill['name'] ?? $skill }}
                                    </span>
                                @endforeach
                                @if(count($skills) > 3)
                                    <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                        +{{ count($skills) - 3 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    {{-- Actions --}}
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('developers.profile', $developer->id) }}"  wire:navigate class="flex-1 bg-primary text-white text-center px-4 py-2 rounded-md hover:bg-primary/70 transition-colors duration-200">
                            Voir le profil
                        </a>
                        <a href="#" class="flex-1 border border-primary text-primary text-center px-4 py-2 rounded-md hover:bg-secondary/50 transition-colors duration-200">
                            Contacter
                        </a>
                    </div>


                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-lg mb-2">Aucun développeur trouvé</div>
                <div class="text-gray-500">Essayez d'ajuster vos filtres de recherche</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($developers->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-lg shadow">
            {{ $developers->links() }}
        </div>
    @endif
</div>
