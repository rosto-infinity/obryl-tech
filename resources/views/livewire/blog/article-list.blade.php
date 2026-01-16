<div class="max-w-7xl mx-auto px-3 xs:px-4 sm:px-4 md:px-6 lg:px-8 py-8 xs:py-12 sm:py-14 md:py-16 lg:py-20" x-data="{ showFilters: false }">
    
    <!-- Header & Search -->
    <div class="mb-12 xs:mb-16 sm:mb-18 md:mb-20 lg:mb-24 text-center">
        <h1 class="text-3xl xs:text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 dark:text-white mb-4 xs:mb-5 sm:mb-6 tracking-tighter">
            Insights & <span class="text-primary italic">Expertises</span>
        </h1>
        <p class="text-xs xs:text-sm sm:text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed font-medium px-2 xs:px-0">
            Découvrez nos derniers tutoriels, études de cas et actualités technologiques pour propulser vos projets à la vitesse supérieure.
        </p>
        
        <div class="mt-8 xs:mt-10 sm:mt-12 lg:mt-14 flex flex-col sm:flex-row gap-3 xs:gap-4 sm:gap-4 max-w-3xl mx-auto px-2 xs:px-0">
            <div class="relative flex-grow group">
                <div class="absolute inset-y-0 left-0 pl-3 xs:pl-4 sm:pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                    <svg class="h-4 xs:h-5 w-4 xs:w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Rechercher une expertise..." 
                    class="block w-full pl-10 xs:pl-12 sm:pl-12 pr-3 xs:pr-4 sm:pr-4 py-3 xs:py-4 sm:py-5 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 rounded-2xl xs:rounded-2xl sm:rounded-3xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm text-sm xs:text-base"
                >
            </div>
            
            <button 
                @click="showFilters = !showFilters"
                class="flex items-center justify-center px-4 xs:px-6 sm:px-8 py-3 xs:py-4 sm:py-5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-2xl xs:rounded-2xl sm:rounded-3xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all border border-gray-200 dark:border-gray-700 hover:border-primary/30 group whitespace-nowrap text-sm xs:text-sm sm:text-base"
            >
                <svg :class="showFilters ? 'rotate-180' : ''" class="h-4 xs:h-5 w-4 xs:w-5 mr-2 xs:mr-3 transition-transform text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span class="font-bold tracking-wide uppercase text-[10px] xs:text-xs sm:text-xs">Filtres</span>
            </button>
        </div>
    </div>

    <!-- Filters Section (Collapsible) -->
    <div 
        x-show="showFilters" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="mb-12 xs:mb-14 sm:mb-16 md:mb-20 lg:mb-24 p-4 xs:p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-2xl xs:rounded-2xl sm:rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50"
    >
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xs:gap-8 sm:gap-10 md:gap-12">
            
            <!-- Categories -->
            <div class="space-y-3 xs:space-y-4 sm:space-y-4 lg:col-span-3">
                <h3 class="text-[9px] xs:text-[10px] sm:text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.25em] xs:tracking-[0.3em]">Catégories</h3>
                <div class="flex flex-wrap gap-2 xs:gap-3 sm:gap-3">
                    <button 
                        wire:click="setCategory(null)"
                        class="px-4 xs:px-5 sm:px-5 py-2 xs:py-2.5 sm:py-2.5 rounded-xl xs:rounded-2xl sm:rounded-2xl text-[8px] xs:text-xs sm:text-xs font-bold uppercase tracking-widest transition-all {{ is_null($category) ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-100 xs:scale-105 sm:scale-105' : 'bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-300 border border-gray-100 dark:border-gray-600' }}"
                    >
                        Toutes
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            wire:click="setCategory('{{ $cat->value }}')"
                            class="px-4 xs:px-5 sm:px-5 py-2 xs:py-2.5 sm:py-2.5 rounded-xl xs:rounded-2xl sm:rounded-2xl text-[8px] xs:text-xs sm:text-xs font-bold uppercase tracking-widest transition-all {{ $category === $cat->value ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-100 xs:scale-105 sm:scale-105' : 'bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-300 border border-gray-100 dark:border-gray-600' }}"
                        >
                            {{ $cat->icon() }} {{ $cat->label() }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Sorting -->
            <div class="space-y-3 xs:space-y-4 sm:space-y-4">
                <h3 class="text-[9px] xs:text-[10px] sm:text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.25em] xs:tracking-[0.3em]">Trier par</h3>
                <div class="relative">
                    <select 
                        wire:model.live="sort"
                        class="appearance-none block w-full px-4 xs:px-5 sm:px-5 py-2 xs:py-3 sm:py-3 bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-xl xs:rounded-2xl sm:rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-xs xs:text-sm sm:text-sm font-medium pr-8 xs:pr-10 sm:pr-10"
                    >
                        <option value="recent">Plus récents</option>
                        <option value="popular">Plus populaires</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 xs:px-4 sm:px-4 pointer-events-none text-gray-400 dark:text-gray-500">
                        <svg class="h-3 xs:h-4 w-3 xs:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 xs:gap-6 sm:gap-8 md:gap-10">
        @forelse($articles as $article)
            <div wire:key="article-{{ $article->id }}" class="group relative bg-white dark:bg-gray-800 rounded-xl xs:rounded-2xl sm:rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/20 transition-all duration-700 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] dark:hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)]">
                
                <!-- Image Container -->
                <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="aspect-[16/10] relative overflow-hidden block">
                    <img 
                        src="{{ $article->featured_image ?? 'https://via.placeholder.com/600x400/F9FAFB/111827?text=OBRYL+TECH' }}" 
                        alt="{{ $article->title }}"
                        class="object-cover w-full h-full transition-transform duration-1000 group-hover:scale-105"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    
                    <!-- Category Badge -->
                    @if($article->category)
                        <div class="absolute top-3 xs:top-4 sm:top-6 left-3 xs:left-4 sm:left-6">
                            <span class="px-3 xs:px-4 sm:px-4 py-1.5 xs:py-2 sm:py-2 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-lg xs:rounded-xl sm:rounded-2xl text-[8px] xs:text-[9px] sm:text-[10px] font-black text-gray-900 dark:text-gray-100 border border-secondary/20 dark:border-secondary/30 flex items-center shadow-lg uppercase tracking-[0.05em] xs:tracking-[0.1em]">
                                <span class="mr-1.5 xs:mr-2 sm:mr-2 text-primary text-xs xs:text-sm">{{ $article->category->icon() }}</span>
                                {{ $article->category->label() }}
                            </span>
                        </div>
                    @endif

                    <!-- Reading Time -->
                    <div class="absolute bottom-3 xs:bottom-4 sm:bottom-6 left-3 xs:left-4 sm:left-6 flex items-center text-[8px] xs:text-[9px] sm:text-[10px] text-white font-black uppercase tracking-widest bg-black/40 dark:bg-black/60 backdrop-blur-md px-2.5 xs:px-3 sm:px-3 py-1 xs:py-1.5 sm:py-1.5 rounded-full">
                        <svg class="w-3 xs:w-3.5 sm:w-3.5 h-3 xs:h-3.5 sm:h-3.5 mr-1 xs:mr-2 sm:mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $article->reading_time }} min
                    </div>
                </a>

                <!-- Content -->
                <div class="p-4 xs:p-6 sm:p-8 flex-grow flex flex-col">
                    
                    <!-- Meta Info -->
                    <div class="flex items-center space-x-2 xs:space-x-3 sm:space-x-3 text-[8px] xs:text-[9px] sm:text-[10px] font-bold text-gray-400 dark:text-gray-500 mb-3 xs:mb-4 sm:mb-5 uppercase tracking-[0.05em] xs:tracking-[0.1em]">
                        <span class="text-primary">{{ $article->published_at?->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}</span>
                        <span class="w-0.5 xs:w-1 h-0.5 xs:h-1 rounded-full bg-gray-200 dark:bg-gray-700"></span>
                        <span class="hover:text-primary transition-colors cursor-pointer truncate">{{ $article->author->name }}</span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-lg xs:text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-3 xs:mb-4 sm:mb-4 group-hover:text-primary transition-colors line-clamp-2 leading-tight xs:leading-[1.2] sm:leading-[1.2] tracking-tight">
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate>
                            {{ $article->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-500 dark:text-gray-400 text-xs xs:text-sm sm:text-sm mb-6 xs:mb-8 sm:mb-8 line-clamp-3 leading-relaxed font-medium">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                    </p>

                    <!-- Stats & CTA -->
                    <div class="mt-auto pt-4 xs:pt-6 sm:pt-8 border-t border-gray-50 dark:border-gray-700 flex items-center justify-between">
                        
                        <!-- Stats -->
                        <div class="flex items-center space-x-3 xs:space-x-4 sm:space-x-5">
                            <span class="flex items-center text-[8px] xs:text-[9px] sm:text-[10px] font-bold text-gray-400 dark:text-gray-500 group/stat">
                                <svg class="w-3 xs:w-4 sm:w-4 h-3 xs:h-4 sm:h-4 mr-1 xs:mr-1.5 sm:mr-1.5 text-gray-300 dark:text-gray-600 group-hover/stat:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($article->views_count) }}
                            </span>
                            <span class="flex items-center text-[8px] xs:text-[9px] sm:text-[10px] font-bold text-gray-400 dark:text-gray-500 group/stat">
                                <svg class="w-3 xs:w-4 sm:w-4 h-3 xs:h-4 sm:h-4 mr-1 xs:mr-1.5 sm:mr-1.5 text-gray-300 dark:text-gray-600 group-hover/stat:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                {{ number_format($article->likes_count) }}
                            </span>
                        </div>
                        
                        <!-- CTA Button -->
                        <div class="flex gap-1 xs:gap-2 sm:gap-2">
                            <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="w-8 xs:w-10 sm:w-10 h-8 xs:h-10 sm:h-10 rounded-lg xs:rounded-xl sm:rounded-2xl bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-600 flex items-center justify-center text-gray-400 dark:text-gray-500 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all duration-500">
                                <svg class="w-4 xs:w-5 sm:w-5 h-4 xs:h-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 xs:py-20 sm:py-24 md:py-32 text-center">
                <div class="relative inline-flex items-center justify-center w-20 xs:w-24 sm:w-24 h-20 xs:h-24 sm:h-24 rounded-2xl xs:rounded-[2rem] sm:rounded-[2rem] bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 mb-6 xs:mb-8 sm:mb-8 overflow-hidden group">
                    <svg class="relative w-8 xs:w-10 sm:w-10 h-8 xs:h-10 sm:h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg xs:text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-2 xs:mb-3 sm:mb-3">Aucune expertise trouvée</h3>
                <p class="text-gray-400 dark:text-gray-500 font-medium text-xs xs:text-sm sm:text-base px-4 xs:px-0">Réessayez avec d'autres filtres ou une recherche différente.</p>
                <button 
                    wire:click="$set('search', ''); $set('category', null)" 
                    class="mt-8 xs:mt-10 sm:mt-10 px-6 xs:px-8 sm:px-8 py-3 xs:py-4 sm:py-4 bg-white dark:bg-gray-800 text-primary font-bold rounded-lg xs:rounded-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 hover:bg-primary hover:text-white dark:hover:bg-primary dark:hover:text-white transition-all shadow-sm text-sm xs:text-base sm:text-base"
                >
                    Réinitialiser les explorateurs
                </button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 xs:mt-16 sm:mt-20 md:mt-24 lg:mt-28 px-2 xs:px-0">
        {{ $articles->links() }}
    </div>
</div>
