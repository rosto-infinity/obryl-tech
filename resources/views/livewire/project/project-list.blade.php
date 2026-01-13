<div class="space-y-8">
    {{-- Header avec statistiques --}}
    <div class="bg-white dark:bg-zinc-900/40 backdrop-blur-sm rounded-2xl shadow-xs border border-zinc-200/60 dark:border-zinc-800/50 p-6 transition-all duration-300">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center mb-8 gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Projets</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mt-1 font-medium">Gérez et suivez vos développements avec précision</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-zinc-50 dark:bg-zinc-800/40 px-4 py-3 rounded-xl border border-zinc-100 dark:border-zinc-700/50 transition-colors">
                    <p class="text-[10px] uppercase font-bold text-zinc-400 dark:text-zinc-500 tracking-wider mb-1">Total</p>
                    <span class="text-zinc-900 dark:text-white font-bold text-xl">{{ $stats['total'] }}</span>
                </div>
                <div class="bg-emerald-50/50 dark:bg-emerald-500/5 px-4 py-3 rounded-xl border border-emerald-100 dark:border-emerald-500/10 transition-colors">
                    <p class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400/70 tracking-wider mb-1">Publiés</p>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-xl">{{ $stats['published'] }}</span>
                </div>
                <div class="bg-amber-50/50 dark:bg-amber-500/5 px-4 py-3 rounded-xl border border-amber-100 dark:border-amber-500/10 transition-colors">
                    <p class="text-[10px] uppercase font-bold text-amber-600 dark:text-amber-400/70 tracking-wider mb-1">Vedette</p>
                    <span class="text-warning dark:text-warning/90 font-bold text-xl">{{ $stats['featured'] }}</span>
                </div>
                <div class="bg-blue-50/50 dark:bg-blue-500/5 px-4 py-3 rounded-xl border border-blue-100 dark:border-blue-500/10 transition-colors">
                    <p class="text-[10px] uppercase font-bold text-blue-600 dark:text-blue-400/70 tracking-wider mb-1">En cours</p>
                    <span class="text-blue-600 dark:text-blue-400 font-bold text-xl">{{ $stats['in_progress'] }}</span>
                </div>
            </div>
        </div>
        
        {{-- Filtres --}}
        <div class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">Recherche</label>
                    <div class="relative group">
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="Titre, description..."
                            class="w-full pl-10 pr-4 py-2.5 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-primary/50 transition-all text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600"
                        />
                        <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 absolute left-3.5 top-3.5 transition-colors group-focus-within:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">Statut</label>
                    <select wire:model.live="statusFilter" class="w-full px-3 py-2.5 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-primary/50 transition-all text-sm text-zinc-900 dark:text-zinc-100">
                        <option value="all">Tous les statuts</option>
                        @foreach($projectStatuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">Type</label>
                    <select wire:model.live="typeFilter" class="w-full px-3 py-2.5 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-primary/50 transition-all text-sm text-zinc-900 dark:text-zinc-100">
                        <option value="all">Tous les types</option>
                        @foreach($projectTypes as $type)
                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">Trier</label>
                    <select wire:model.live="sortBy" class="w-full px-3 py-2.5 bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-primary/50 transition-all text-sm text-zinc-900 dark:text-zinc-100">
                        <option value="created_at">Plus récents</option>
                        <option value="title">Alphabétique</option>
                        <option value="budget">Budget</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-6 pt-2 border-t border-zinc-100 dark:border-zinc-800/50">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" wire:model.live="showFeaturedOnly" class="sr-only peer">
                        <div class="w-9 h-5 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-focus:ring-2 peer-focus:ring-secondary/30 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-secondary"></div>
                    </div>
                    <span class="ml-3 text-xs font-bold text-zinc-500 dark:text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-zinc-200 uppercase tracking-wider transition-colors">En vedette</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" wire:model.live="showPublishedOnly" class="sr-only peer">
                        <div class="w-9 h-5 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-focus:ring-2 peer-focus:ring-primary/30 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                    </div>
                    <span class="ml-3 text-xs font-bold text-zinc-500 dark:text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-zinc-200 uppercase tracking-wider transition-colors">Publiés uniquement</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Liste des projets : Grid 2 Colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @forelse($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="group bg-white dark:bg-zinc-900/40 rounded-2xl shadow-xs hover:shadow-xl hover:shadow-zinc-200/50 dark:hover:shadow-black/20 transition-all duration-500 border border-zinc-200/60 dark:border-zinc-800/50 overflow-hidden flex flex-col sm:flex-row h-full">
                
                {{-- Section Image --}}
                <div class="w-full sm:w-2/5 h-52 sm:h-auto bg-zinc-100 dark:bg-zinc-800 relative shrink-0 overflow-hidden">
                    @if($project->featured_image)
                        <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    {{-- Overlay Badge Featured --}}
                    @if($project->is_featured)
                        <div class="absolute top-4 left-4 bg-secondary/90 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-lg flex items-center uppercase tracking-widest">
                            <span class="mr-1.5">★</span> Vedette
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-4">
                        <span class="text-white text-[10px] font-bold uppercase tracking-widest">Voir les détails</span>
                    </div>
                </div>

                {{-- Section Contenu --}}
                <div class="p-6 flex flex-col flex-1">
                    
                    {{-- Header du Projet --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                @switch($project->status)
                                    @case('pending')
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400/80">En attente</span>
                                        @break
                                    @case('in_progress')
                                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400/80">En cours</span>
                                        @break
                                    @case('completed')
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400/80">Terminé</span>
                                        @break
                                    @case('published')
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400/80">Publié</span>
                                        @break
                                @endswitch
                            </div>
                            <span class="text-[10px] text-zinc-400 dark:text-zinc-600 font-mono tracking-tighter">{{ $project->code }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white leading-tight mb-2 group-hover:text-primary transition-colors duration-300">{{ $project->title }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 font-medium leading-relaxed">{{ Str::limit($project->description, 90) }}</p>
                    </div>
                    
                    {{-- Détails --}}
                    <div class="grid grid-cols-2 gap-4 mb-6 pt-4 border-t border-zinc-100 dark:border-zinc-800/50">
                        <div>
                            <p class="text-[9px] uppercase font-bold text-zinc-400 dark:text-zinc-500 tracking-widest mb-1">Client</p>
                            <p class="text-xs font-bold text-zinc-800 dark:text-zinc-200 truncate">{{ $project->client?->name ?? 'Indépendant' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] uppercase font-bold text-zinc-400 dark:text-zinc-500 tracking-widest mb-1">Budget</p>
                            <p class="text-xs font-extrabold text-primary">{{ number_format($project->budget, 0, ',', ' ') }} <span class="text-[10px] opacity-70">FCFA</span></p>
                        </div>
                    </div>
                    
                    {{-- Barre de progression --}}
                    @if($project->progress_percentage)
                        <div class="mb-6">
                            <div class="flex justify-between items-center text-[10px] font-bold mb-2">
                                <span class="text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Progression</span>
                                <span class="text-primary">{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800/50 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary to-emerald-400 h-full rounded-full transition-all duration-1000 ease-out shadow-[0_0_8px_rgba(53,154,105,0.4)]" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Footer --}}
                    <div class="mt-auto flex items-center justify-between gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center group/stat" title="Note moyenne">
                                <span class="text-secondary text-xs mr-1 transition-transform group-hover/stat:scale-125">★</span>
                                <span class="text-[11px] font-bold text-zinc-600 dark:text-zinc-400">{{ number_format($project->average_rating, 1) }}</span>
                            </div>
                            <div class="flex items-center group/stat" title="Vues">
                                <svg class="w-3.5 h-3.5 text-blue-400 mr-1 transition-transform group-hover/stat:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span class="text-[11px] font-bold text-zinc-600 dark:text-zinc-400">{{ $project->views_count ?? 0 }}</span>
                            </div>
                        </div>

                        <a href="{{ route('projects.detail', $project->slug) }}"  wire:navigate class="inline-flex items-center justify-center bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-[10px] font-bold uppercase tracking-widest px-5 py-2.5 rounded-xl hover:bg-primary dark:hover:bg-primary hover:text-white dark:hover:text-white transition-all duration-300 shadow-sm">
                            Explorer
                            <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-zinc-50 dark:bg-zinc-900/20 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                <div class="bg-white dark:bg-zinc-800 p-5 rounded-2xl shadow-sm mb-6">
                    <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucun projet trouvé</h3>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm max-w-xs mx-auto font-medium">Nous n'avons trouvé aucun projet correspondant à vos critères actuels.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
        <div class="bg-white dark:bg-zinc-900/40 px-8 py-5 flex items-center justify-between border border-zinc-200/60 dark:border-zinc-800/50 rounded-2xl shadow-sm backdrop-blur-sm">
            {{ $projects->links() }}
        </div>
    @endif
</div>