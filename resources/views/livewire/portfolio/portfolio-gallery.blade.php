<div class="max-w-7xl mx-auto px-6 pt-16 pb-24">
    {{-- Header --}}
    <div class="mb-20 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-foreground mb-6 tracking-tight">
            archives <span class="text-primary italic">visuelles</span>
        </h1>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed font-medium">
            une immersion dans nos déploiements technologiques les plus audacieux.
        </p>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
        <div class="bg-card p-6 rounded-md border border-border transition-all hover:border-primary/20 group shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-bold text-muted-foreground group-hover:text-primary transition-colors">réalisations</span>
                <div class="w-8 h-8 bg-primary/5 rounded-md flex items-center justify-center border border-primary/10">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-foreground tracking-tight">{{ $stats['total_projects'] }}</p>
        </div>
        
        <div class="bg-card p-6 rounded-md border border-border transition-all hover:border-secondary/20 group shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-bold text-muted-foreground group-hover:text-secondary transition-colors">architectes</span>
                <div class="w-8 h-8 bg-secondary/5 rounded-md flex items-center justify-center border border-secondary/10">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 100 5.646 5.646L17 14l-1.646-1.646A4 4 0 0012 4.354z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-foreground tracking-tight">{{ $stats['developers'] }}</p>
        </div>
        
        <div class="bg-card p-6 rounded-md border border-border transition-all hover:border-primary/20 group shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-bold text-muted-foreground group-hover:text-primary transition-colors">engagement</span>
                <div class="w-8 h-8 bg-primary/5 rounded-md flex items-center justify-center border border-primary/10">
                    <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-foreground tracking-tight">{{ number_format($stats['total_likes']) }}</p>
        </div>
        
        <div class="bg-card p-6 rounded-md border border-border transition-all hover:border-foreground/20 group shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-bold text-muted-foreground group-hover:text-foreground transition-colors">taxonomies</span>
                <div class="w-8 h-8 bg-muted rounded-md flex items-center justify-center border border-border">
                    <svg class="w-4 h-4 text-foreground/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-foreground tracking-tight">{{ $stats['categories'] }}</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-card rounded-md border border-border p-8 mb-16 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1">
                <label class="block text-[10px] font-bold text-muted-foreground mb-3 px-1">scanner</label>
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="recherche..."
                        class="w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-medium text-foreground"
                    />
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-muted-foreground mb-3 px-1">dimension</label>
                <div class="relative">
                    <select wire:model.live="categoryFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                        <option value="all">toutes</option>
                        @foreach($categories as $category)
                            <option value="{{ $category['value'] }}">{{ $category['label'] }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-muted-foreground mb-3 px-1">stack</label>
                <div class="relative">
                    <select wire:model.live="techFilter" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                        <option value="all">toutes</option>
                        @foreach($technologies as $tech)
                            <option value="{{ $tech }}">{{ $tech }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-muted-foreground mb-3 px-1">ordonner</label>
                <div class="relative">
                    <select wire:model.live="sortBy" class="appearance-none w-full px-4 py-2 bg-muted border border-transparent rounded-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-bold text-foreground">
                        <option value="recent">plus récents</option>
                        <option value="popular">plus visionnés</option>
                        <option value="rating">mieux notés</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-muted-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($projects as $project)
            <livewire:portfolio.project-card :project="$project" :key="'project-'.$project->id" />
        @empty
            <div class="col-span-full py-20 text-center border-2 border-dashed border-border rounded-md">
                <p class="text-muted-foreground font-medium">innover pour demain...</p>
            </div>
        @endforelse
    </div>

    <div class="mt-16">
        {{ $projects->links() }}
    </div>

    {{-- Modal Image --}}
    <div 
        id="imageModal" 
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/90 backdrop-blur-xl animate-in fade-in duration-300"
        onclick="closeImageModal()"
    >
        <button class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors" onclick="closeImageModal()">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        
        <div class="max-w-5xl w-full flex flex-col items-center" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] rounded-md shadow-2xl border border-white/10">
            <p id="modalTitle" class="mt-8 text-white font-bold text-xl tracking-tight"></p>
        </div>
    </div>

    <script>
        function openImageModal(src, title) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            const txt = document.getElementById('modalTitle');
            
            img.src = src;
            txt.textContent = title;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeImageModal();
        });
    </script>
</div>
