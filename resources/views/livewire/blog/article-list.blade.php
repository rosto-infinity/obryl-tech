<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ showFilters: false }">
    <!-- Header & Search -->
    <div class="mb-20 text-center">
        <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-6 tracking-tighter">
            Insights & <span class="text-primary italic">Expertises</span>
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed font-medium">
            Découvrez nos derniers tutoriels, études de cas et actualités technologiques pour propulser vos projets à la vitesse supérieure.
        </p>
        
        <div class="mt-12 flex flex-col md:flex-row gap-4 max-w-3xl mx-auto">
            <div class="relative flex-grow group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Rechercher une expertise..." 
                    class="block w-full pl-12 pr-4 py-5 border border-gray-200 bg-white text-gray-900 placeholder-gray-400 rounded-3xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm"
                >
            </div>
            
            <button 
                @click="showFilters = !showFilters"
                class="flex items-center justify-center px-8 py-5 bg-white text-gray-600 rounded-3xl hover:bg-gray-50 transition-all border border-gray-200 hover:border-primary/30 group"
            >
                <svg :class="showFilters ? 'rotate-180' : ''" class="h-5 w-5 mr-3 transition-transform text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span class="font-bold tracking-wide uppercase text-xs">Filtres</span>
            </button>
        </div>
    </div>

    <!-- Filters Section (Collapsible) -->
    <div 
        x-show="showFilters" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="mb-16 p-8 bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Categories -->
            <div class="space-y-4 lg:col-span-3">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Catégories</h3>
                <div class="flex flex-wrap gap-3">
                    <button 
                        wire:click="setCategory(null)"
                        class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all {{ is_null($category) ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-105' : 'bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700 border border-gray-100' }}"
                    >
                        Toutes
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            wire:click="setCategory('{{ $cat->value }}')"
                            class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all {{ $category === $cat->value ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-105' : 'bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700 border border-gray-100' }}"
                        >
                            {{ $cat->icon() }} {{ $cat->label() }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Sorting -->
            <div class="space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Trier par</h3>
                <div class="relative">
                    <select 
                        wire:model.live="sort"
                        class="appearance-none block w-full px-5 py-3 bg-gray-50 border border-gray-100 text-gray-700 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-medium pr-10"
                    >
                        <option value="recent">Plus récents</option>
                        <option value="popular">Plus populaires</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($articles as $article)
            <div wire:key="article-{{ $article->id }}" class="group relative bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 hover:border-primary/20 transition-all duration-700 flex flex-col hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)]">
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
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-2 bg-white/95 backdrop-blur-xl rounded-2xl text-[10px] font-black text-gray-900 border border-secondary/20 flex items-center shadow-lg uppercase tracking-[0.1em]">
                                <span class="mr-2 text-primary">{{ $article->category->icon() }}</span>
                                {{ $article->category->label() }}
                            </span>
                        </div>
                    @endif

                    <!-- Reading Time -->
                    <div class="absolute bottom-6 left-6 flex items-center text-[10px] text-white font-black uppercase tracking-widest bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $article->reading_time }} min
                    </div>
                </a>
                

                <!-- Content -->
                <div class="p-8 flex-grow flex flex-col">
                    <div class="flex items-center space-x-3 text-[10px] font-bold text-gray-400 mb-5 uppercase tracking-[0.1em]">
                        <span class="text-primary">{{ $article->published_at?->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                        <span class="hover:text-primary transition-colors cursor-pointer">{{ $article->author->name }}</span>
                    </div>

                    <h2 class="text-2xl font-black text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-2 leading-[1.2] tracking-tight">
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate>
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed font-medium">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                    </p>

                    <!-- Stats & Tags -->
                    <div class="mt-auto pt-8 border-t border-gray-50 flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <span class="flex items-center text-[10px] font-bold text-gray-400 group/stat">
                                <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover/stat:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($article->views_count) }}
                            </span>
                            <span class="flex items-center text-[10px] font-bold text-gray-400 group/stat">
                                <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover/stat:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                {{ number_format($article->likes_count) }}
                            </span>
                        </div>
                        
                        <div class="flex gap-2">
                             <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="w-10 h-10 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all duration-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center">
                <div class="relative inline-flex items-center justify-center w-24 h-24 rounded-[2rem] bg-gray-50 border border-gray-100 mb-8 overflow-hidden group">
                    <svg class="relative w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Aucune expertise trouvée</h3>
                <p class="text-gray-400 font-medium">Réessayez avec d'autres filtres ou une recherche différente.</p>
                <button 
                    wire:click="$set('search', ''); $set('category', null)" 
                    class="mt-10 px-8 py-4 bg-white text-primary font-bold rounded-2xl border border-gray-200 hover:bg-primary hover:text-white transition-all shadow-sm"
                >
                    Réinitialiser les explorateurs
                </button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-20">
        {{ $articles->links() }}
    </div>
</div>
