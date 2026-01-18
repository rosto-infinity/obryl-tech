<div class="max-w-7xl mx-auto px-6 py-16 lg:py-24" x-data="{ showFilters: false }">
    
    <!-- Header & Search -->
    <div class="mb-20 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-foreground mb-6 tracking-tight">
            insights & <span class="text-primary italic">expertises</span>
        </h1>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed font-medium">
            Plongez dans nos analyses techniques et découvrez les dernières innovations pour vos projets.
        </p>
        
        <div class="mt-12 flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-muted-foreground">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="rechercher une expertise..." 
                    class="block w-full pl-11 pr-4 py-3.5 border border-border bg-card text-foreground placeholder-muted-foreground rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm text-base font-medium"
                >
            </div>
            
            <button 
                @click="showFilters = !showFilters"
                class="flex items-center justify-center px-6 py-3.5 bg-card text-foreground rounded-md hover:bg-muted transition-all border border-border hover:border-primary/20 whitespace-nowrap text-sm font-bold"
            >
                <svg :class="showFilters ? 'rotate-180' : ''" class="h-4 w-4 mr-2 transition-transform text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                filtres
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div 
        x-show="showFilters" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="mb-16 p-8 bg-card rounded-md border border-border shadow-lg"
    >
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="space-y-4 lg:col-span-3">
                <h3 class="text-xs font-bold text-muted-foreground tracking-wider">Catégories</h3>
                <div class="flex flex-wrap gap-2">
                    <button 
                        wire:click="setCategory(null)"
                        class="px-4 py-2 rounded-md text-xs font-bold transition-all {{ is_null($category) ? 'bg-primary text-primary-foreground shadow-lg shadow-primary/20' : 'bg-muted text-muted-foreground hover:bg-border hover:text-foreground' }}"
                    >
                        toutes
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            wire:click="setCategory('{{ $cat->value }}')"
                            class="px-4 py-2 rounded-md text-xs font-bold transition-all {{ $category === $cat->value ? 'bg-primary text-primary-foreground shadow-lg shadow-primary/20' : 'bg-muted text-muted-foreground hover:bg-border hover:text-foreground' }}"
                        >
                            {{ $cat->icon() }} {{ $cat->label() }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xs font-bold text-muted-foreground tracking-wider">trier par</h3>
                <div class="relative">
                    <select 
                        wire:model.live="sort"
                        class="appearance-none block w-full px-4 py-2 bg-muted border border-transparent text-foreground rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold pr-10"
                    >
                        <option value="recent">plus récents</option>
                        <option value="popular">plus populaires</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article wire:key="article-{{ $article->id }}" class="group bg-card rounded-md overflow-hidden border border-border/50 hover:border-primary/20 transition-all duration-500 flex flex-col hover:shadow-xl">
                
                <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="aspect-[16/10] relative overflow-hidden block bg-muted">
                    <img 
                        src="{{ $article->featured_image_url }}" 
                        alt="{{ $article->title }}"
                        class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/20 to-transparent">
                         <span class="text-[10px] text-white font-bold bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-md">
                            {{ $article->reading_time }} min de lecture
                        </span>
                    </div>
                </a>

                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex items-center gap-2 mb-4">
                         @if($article->category)
                            <span class="px-2 py-0.5 bg-primary/10 text-primary rounded text-[10px] font-bold">
                                {{ $article->category->label() }}
                            </span>
                        @endif
                        <span class="text-[10px] font-medium text-muted-foreground">
                            {{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-foreground mb-4 group-hover:text-primary transition-colors line-clamp-2 leading-tight tracking-tight">
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate>
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-muted-foreground text-sm mb-6 line-clamp-3 leading-relaxed font-medium">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                    </p>

                    <div class="mt-auto pt-6 border-t border-border flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}" class="w-6 h-6 rounded-full object-cover">
                            <span class="text-xs font-medium text-muted-foreground">{{ $article->author->name }}</span>
                        </div>
                        
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="text-xs font-bold text-foreground hover:text-primary transition-colors flex items-center gap-1">
                            lire la suite
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center border-2 border-dashed border-border rounded-md">
                <h3 class="text-xl font-bold text-foreground mb-2">aucune expertise trouvée</h3>
                <p class="text-muted-foreground font-medium mb-8">Le savoir est en cours de compilation.</p>
                <button 
                    wire:click="$set('search', ''); $set('category', null)" 
                    class="px-8 py-3 bg-primary text-primary-foreground font-bold rounded-md transition-all hover:translate-y-[-2px] shadow-lg shadow-primary/20 text-sm"
                >
                    réinitialiser les explorateurs
                </button>
            </div>
        @endforelse
    </div>

    <div class="mt-16">
        {{ $articles->links() }}
    </div>
</div>
