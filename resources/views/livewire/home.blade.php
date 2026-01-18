<div class="relative">
    
    <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden bg-background">
        <div class="absolute inset-0 bg-mesh-gradient opacity-40"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md glass text-xs font-medium text-foreground/70">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        innovation & excellence
                    </div>

                    <div class="space-y-4">
                        <h1 class="text-5xl sm:text-6xl md:text-7xl font-bold tracking-tight leading-tight">
                            <span class="text-foreground">obryl</span>
                            <span class="text-primary italic">tech</span>
                        </h1>
                        <p class="text-lg md:text-xl text-muted-foreground font-medium max-w-xl">
                            l'ingénierie d'élite au service de vos ambitions numériques les plus audacieuses.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('projects.list') }}" wire:navigate
                            class="inline-flex items-center justify-center px-8 py-3.5 font-bold text-primary-foreground bg-primary rounded-md hover:translate-y-[-2px] transition-all duration-300 shadow-lg shadow-primary/20">
                            découvrir le portfolio
                        </a>
                        <a href="{{ route('developers.list') }}" wire:navigate
                            class="inline-flex items-center justify-center px-8 py-3.5 font-bold text-foreground border-2 border-border hover:border-primary hover:text-primary rounded-md transition-all duration-300">
                            nos experts
                        </a>
                    </div>

                    <div class="pt-8 flex gap-10 items-center border-t border-border/50">
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold text-foreground">500+</span>
                            <span class="text-xs font-medium text-muted-foreground">projets livrés</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold text-primary">98%</span>
                            <span class="text-xs font-medium text-muted-foreground">satisfaction</span>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block relative">
                    <div class="relative z-10 bg-card/50 backdrop-blur-xl rounded-md p-8 border border-border shadow-xl">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-destructive/50"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-secondary/50"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-primary/50"></div>
                            </div>
                            <div class="text-[10px] font-mono text-muted-foreground">obryl-tech.dev_core</div>
                        </div>
                        <div class="space-y-4 font-mono text-sm leading-relaxed">
                            <p class="text-primary font-bold">const obryl = {</p>
                            <p class="pl-4 text-foreground/80">vision: <span class="text-secondary">"elite"</span>,</p>
                            <p class="pl-4 text-foreground/80">stack: <span class="text-secondary">["laravel", "ai", "cloud"]</span>,</p>
                            <p class="pl-4 text-foreground/80">output: <span class="text-secondary">"excellence"</span></p>
                            <p class="text-primary font-bold">};</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-24 bg-background">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 gap-6">
                <div class="space-y-2">
                    <div class="text-primary font-bold text-sm tracking-wider">portfolio</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-foreground tracking-tight">réalisations d'élite</h2>
                </div>
                <a href="{{ route('projects.list') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold text-muted-foreground hover:text-primary transition-colors">
                    explorer tout l'univers
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestProjects as $project)
                    <article class="group relative flex flex-col bg-card rounded-md overflow-hidden border border-border/50 hover:border-primary/20 transition-all duration-500 hover:shadow-xl">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            @if ($project->featured_image_url)
                                <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-muted text-muted-foreground/30">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586 1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/20 to-transparent">
                                <span class="text-[10px] font-bold text-white bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-md">
                                    {{ $project->type->label() }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                             <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate class="block">
                                <h3 class="text-xl font-bold text-foreground mb-4 group-hover:text-primary transition-colors line-clamp-1 tracking-tight">
                                    {{ $project->title }}
                                </h3>
                            </a>
                            <p class="text-muted-foreground text-sm font-medium line-clamp-3 mb-6 flex-grow leading-relaxed">
                                {{ $project->description }}
                            </p>
                            <div class="flex items-center justify-between pt-6 border-t border-border/50">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Expertise</span>
                                    <span class="text-xs font-bold text-foreground">{{ array_slice($project->technologies ?? [], 0, 2)[0] ?? 'Tech' }}</span>
                                </div>
                                <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate
                                    class="w-8 h-8 rounded-md bg-muted flex items-center justify-center text-foreground hover:bg-primary hover:text-primary-foreground transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center bg-card rounded-md border-2 border-dashed border-border">
                        <p class="text-muted-foreground font-medium">innover pour demain...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Experts Section -->
    <section class="py-24 bg-muted/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 gap-6">
                <div class="space-y-2">
                    <div class="text-secondary font-bold text-sm tracking-wider">talents</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-foreground tracking-tight">nos architectes</h2>
                </div>
                <a href="{{ route('developers.list') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold text-muted-foreground hover:text-secondary transition-colors">
                    voir tous les experts
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredDevelopers as $developer)
                    <div class="group bg-card p-8 rounded-md border border-border/50 hover:border-secondary/20 transition-all hover:shadow-lg">
                        <div class="relative w-16 h-16 mb-6">
                            <div class="w-full h-full bg-muted rounded-md border border-border flex items-center justify-center overflow-hidden transition-transform duration-500 group-hover:scale-105">
                                @if($developer->avatar_url)
                                    <img src="{{ $developer->avatar_url }}" alt="{{ $developer->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-bold text-secondary">{{ $developer->initials() }}</span>
                                @endif
                            </div>
                            @if($developer->profile?->availability === 'available')
                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-primary border-2 border-card rounded-full"></span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-1 leading-tight">{{ $developer->name }}</h3>
                        <p class="text-xs font-bold text-muted-foreground mb-6">{{ $developer->profile?->specialization?->label() ?? 'Ingénieur Fullstack' }}</p>
                        <a href="{{ route('developers.profile', $developer->slug) }}" wire:navigate
                            class="text-xs font-bold text-secondary hover:underline">profil détaillé</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Review Section -->
    <section class="py-24 bg-background">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-4">
                <div class="text-primary font-bold text-sm tracking-wider">témoignages</div>
                <h2 class="text-4xl md:text-5xl font-bold text-foreground tracking-tight">éloge de l'excellence</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($topReviews as $review)
                    <div class="bg-card p-8 rounded-md border border-border/50 relative">
                        <div class="text-primary opacity-20 text-6xl absolute top-6 right-8 font-serif leading-none">"</div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 bg-muted rounded-md border border-border flex items-center justify-center">
                                <span class="text-sm font-bold text-foreground">{{ $review->client?->initials() ?? 'C' }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-foreground">{{ $review->client?->name ?? 'Partenaire' }}</p>
                                <div class="flex text-secondary star-rating">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-3 w-3 {{ $i < $review->rating ? 'fill-current' : 'text-muted/30' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-foreground/80 font-medium text-sm leading-relaxed italic">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('reviews.public') }}" wire:navigate class="text-sm font-bold text-primary hover:underline">voir tous les témoignages</a>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-24 bg-muted/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
             <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 gap-6">
                <div class="space-y-2">
                    <div class="text-primary font-bold text-sm tracking-wider">insights</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-foreground tracking-tight">le journal technique</h2>
                </div>
                <a href="{{ route('blog.index') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold text-muted-foreground hover:text-primary transition-colors">
                    accéder au savoir
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentArticles as $article)
                    <article class="group bg-card rounded-md overflow-hidden border border-border/50 hover:border-primary/20 transition-all hover:shadow-lg">
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="block aspect-video overflow-hidden">
                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                @if($article->category)
                                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">{{ $article->category->label() }}</span>
                                @endif
                                <span class="text-[10px] font-medium text-muted-foreground">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                            <a href="{{ route('blog.show', $article->slug) }}" wire:navigate>
                                <h3 class="text-lg font-bold text-foreground mb-4 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                                    {{ $article->title }}
                                </h3>
                            </a>
                            <p class="text-sm text-muted-foreground font-medium line-clamp-2 leading-relaxed">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-32 relative overflow-hidden bg-foreground">
        <div class="absolute inset-0 bg-mesh-gradient opacity-10"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-4xl md:text-6xl font-bold text-background mb-8 tracking-tight">prêt à concevoir l'exceptionnel ?</h2>
            <p class="text-lg md:text-xl text-background/60 mb-12 max-w-2xl mx-auto font-medium">
                rejoignez l'élite technologique et donnez vie à vos projets les plus audacieux avec obryl tech.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ route('projects.request') }}" wire:navigate
                    class="px-10 py-4 bg-primary text-primary-foreground font-bold rounded-md hover:translate-y-[-2px] transition-all shadow-xl shadow-primary/20">
                    démarrer un projet
                </a>
                <a href="{{ route('register') }}" wire:navigate
                    class="px-10 py-4 border-2 border-background/20 text-background font-bold rounded-md hover:bg-background/10 transition-all">
                    rejoindre le réseau
                </a>
            </div>
        </div>
    </section>
</div>
