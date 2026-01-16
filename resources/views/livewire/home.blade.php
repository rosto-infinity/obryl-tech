    <div>
    
    <!-- Hero Section - Premium Mesh Gradient Design -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        
        <!-- Decorative Glass Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full  animate-pulse" style="animation-delay: 2s;"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Hero Content -->
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full glass animate-in fade-in slide-in-from-left-8 duration-700">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                        </span>
                        <span class="text-sm font-bold tracking-widest uppercase text-slate-800 dark:text-slate-200">Innovation & Excellence</span>
                    </div>

                    <div class="space-y-6">
                        <h1 class="text-6xl sm:text-7xl md:text-8xl font-black tracking-tighter leading-[0.9] animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-100">
                            <span class="text-primary dark:text-white">OBRYL</span><br/>
                            <span class="text-secondary">TECH</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 font-medium max-w-xl animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-200">
                            Propulsez vos ambitions numériques avec l'ingénierie d'élite.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-5 animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-300">
                         <a href="{{ route('developers.list') }}" wire:navigate
                            class="inline-flex items-center justify-center px-8 py-4 font-bold text-primary dark:text-white border rounded-md transition-all duration-300  dark:hover:bg-primary active:scale-95">
                            Nos Experts
                        </a>
                        <a href="{{ route('projects.list') }}" wire:navigate
                            class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white bg-slate-900 dark:bg-primary rounded-md overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95 shadow-2xl">
                            <span class="relative z-10 flex items-center gap-2">
                                Découvrir le Portfolio
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </a>
                       
                    </div>

                    <!-- Trust Badges -->
                    <div class="pt-8 flex flex-wrap gap-8 items-center border-t border-slate-200/50 dark:border-slate-800/50 animate-in fade-in duration-1000 delay-500">
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-slate-900 dark:text-white">500+</span>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Projets Livrés</span>
                        </div>
                        <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-primary">98%</span>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Satisfaction</span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Visual Section -->
                <div class="hidden lg:block relative">
                    <div class="relative z-10 bg-black/75 rounded-[0.7rem] p-8 shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-700">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="text-xs font-mono text-slate-300">obryl-tech.system</div>
                        </div>
                        <div class="space-y-4 font-mono text-sm leading-relaxed">
                            <p class="text-primary-light">const excellence = {</p>
                            <p class="pl-4 text-slate-300">innovation: <span class="text-secondary">true</span>,</p>
                            <p class="pl-4 text-slate-300">quality: <span class="text-secondary">"uncompromising"</span>,</p>
                            <p class="pl-4 text-slate-300">speed: <span class="text-secondary">"optimized"</span></p>
                            <p class="text-primary-light">};</p>
                            <p class="text-slate-400 mt-4">// Deploying future...</p>
                        </div>
                        
                        <!-- Floating Cards inside Visual -->
                        <div class="absolute -top-15 -right-8 glass p-6 rounded-[0.7rem] shadow-xl animate-float">
                            <div class="text-primary font-black">Performance</div>
                            <div class="text-xs text-slate-500">Lighthouse Score 100</div>
                        </div>
                        <div class="absolute -bottom-15 -left-8 glass p-6 rounded-[0.7rem] shadow-xl animate-float" style="animation-delay: 1.5s;">
                            <div class="text-secondary font-black">Security</div>
                            <div class="text-xs text-slate-500">Enterprise Encrypted</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Projects Section -->
    <section class="py-24 relative overflow-hidden bg-white dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-12 h-[2px] bg-primary"></div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Portfolio</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight">RÉALISATIONS <span class="text-primary">D'EXCEPTION</span></h2>
                </div>
                <a href="{{ route('projects.list') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
                    Explorer tout le portfolio
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($latestProjects as $project)
                    <article class="group relative flex flex-col bg-white dark:bg-gray-900 rounded-[2rem] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                        <!-- Image Container -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            @if ($project->featured_image)
                                <img src="{{ $project->featured_image }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <!-- Overlay Badge -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                @foreach (array_slice($project->technologies ?? [], 0, 1) as $tech)
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest bg-white/90 dark:bg-gray-950/90 text-slate-900 dark:text-white backdrop-blur-md rounded-full shadow-sm">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">
                                {{ $project->title }}
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed line-clamp-2 mb-6 flex-grow">
                                {{ $project->description }}
                            </p>
                            <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate
                                class="inline-flex items-center font-bold text-sm text-slate-900 dark:text-white border-b-2 border-primary/20 hover:border-primary transition-all pb-1 w-fit">
                                Voir les détails
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center glass rounded-3xl">
                        <p class="text-slate-500 font-medium">Aucun projet récent disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Developers Section - Premium Team Display -->
    <section class="py-24 bg-slate-900 dark:bg-black relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary">Le Mindset OBRYL</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white">EXPERTS TECHNIQUES <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-light">D'ÉLITE</span></h2>
                <p class="text-slate-400 text-lg">L'excellence n'est pas un acte, mais une habitude.</p>
            </div>

            <!-- Developers Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
                @forelse($featuredDevelopers as $developer)
                    <div class="group text-center">
                        <div class="relative mb-8 mx-auto w-48 h-48">
                            <!-- Decorative Rings -->
                            <div class="absolute inset-[-8px] rounded-full border-2 border-primary/20 scale-90 group-hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                            <div class="absolute inset-[-15px] rounded-full border border-secondary/10 scale-90 group-hover:scale-105 opacity-0 group-hover:opacity-100 transition-all duration-700 delay-75"></div>
                            
                            <!-- Avatar -->
                            <div class="relative w-full h-full rounded-full overflow-hidden border-4 border-slate-800 shadow-2xl transition-transform duration-500 group-hover:rotate-6">
                                @php
                                    $avatar = $developer->profile?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($developer->name).'&color=10B981&background=0F172A';
                                @endphp
                                <img src="{{ $avatar }}" alt="{{ $developer->name }}" class="w-full h-full object-cover">
                                <!-- Dark Overlay on hover -->
                                <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-white group-hover:text-primary transition-colors">{{ $developer->name }}</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $developer->profile?->title ?? 'Développeur Expert' }}</p>
                            
                            <div class="pt-6">
                                <a href="{{ route('developers.profile', $developer->id) }}" wire:navigate
                                    class="inline-flex items-center justify-center px-6 py-2 text-xs font-bold uppercase tracking-widest text-primary border border-primary/30 rounded-full hover:bg-primary hover:text-white transition-all duration-300">
                                    Portfolio
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-800 rounded-3xl">
                        <p class="text-slate-500">Équipe en cours de déploiement...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Reviews Section - Client Testimonials -->
    <section class="py-24 bg-white dark:bg-gray-950 relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-12 h-[2px] bg-primary"></div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Témoignages</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight">AVIS <span class="text-primary">CLIENTS</span></h2>
                </div>
                <a href="{{ route('reviews.public') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
                    Voir tous les avis
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Reviews Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($topReviews as $review)
                    <div class="bg-slate-50 dark:bg-gray-900 rounded-2xl p-8 border border-slate-100 dark:border-slate-800 hover:shadow-xl transition-all duration-500">
                        <!-- Rating -->
                        <div class="flex items-center gap-1 mb-6">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 {{ $i < $review->rating ? 'text-yellow-400 fill-current' : 'text-slate-300 dark:text-slate-600' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Comment -->
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-8 line-clamp-4">
                            "{{ $review->comment }}"
                        </p>

                        <!-- Author -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-primary font-bold text-lg">{{ substr($review->client->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $review->client->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $review->project->title ?? 'Client' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center glass rounded-3xl">
                        <p class="text-slate-500 font-medium">Aucun avis pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- Blog Section - Premium Insights -->
    <section class="py-24 bg-slate-50 dark:bg-gray-900/50 relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-12 h-[2px] bg-secondary"></div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-secondary">Insights</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight">ACTUALITÉS <span class="text-secondary">TECH</span></h2>
                </div>
                <a href="{{ route('blog.index') }}" wire:navigate
                    class="group inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-secondary transition-colors">
                    Explorer tout le blog
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($recentArticles as $article)
                    <article class="group flex flex-col h-full bg-white dark:bg-gray-900 p-4 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:shadow-xl transition-all duration-500">
                        <!-- Image -->
                        <div class="aspect-video overflow-hidden rounded-[1.5rem] mb-6">
                            @if ($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z" /></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Meta -->
                        <div class="px-2 flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">
                            <span class="px-2 py-1 rounded-md bg-secondary/10 text-secondary">{{ $article->category?->label() ?? 'Article' }}</span>
                            <span>{{ $article->published_at?->format('d M Y') }}</span>
                        </div>

                        <!-- Title -->
                        <div class="px-2 space-y-3 flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-secondary transition-colors line-clamp-2">
                                <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="focus:outline-none">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>
                        </div>

                        <!-- Link -->
                        <div class="p-2 pt-6">
                            <a href="{{ route('blog.show', $article->slug) }}" wire:navigate
                                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white hover:text-secondary transition-colors">
                                Lire plus
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center glass rounded-3xl">
                        <p class="text-slate-500 font-medium">Le blog se prépare...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Final CTA Section - High Impact -->
    <section class="py-32 relative overflow-hidden">
        <!-- Background with Mesh Gradient -->
        <div class="absolute inset-0 bg-slate-900 dark:bg-black">
             <div class="absolute inset-0 bg-mesh-gradient opacity-30"></div>
        </div>

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="glass-dark rounded-[3rem] p-12 md:p-20 text-center space-y-12 border-white/10 shadow-3xl">
                <div class="space-y-6">
                    <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-tight">
                        PRÊT À <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-light to-secondary">TRANSFORMER</span> <br class="hidden sm:block"/>VOS IDÉES ?
                    </h2>
                    <p class="text-xl md:text-2xl text-slate-300 max-w-2xl mx-auto font-medium">
                        Rejoignez l'élite technologique et donnez vie à vos projets les plus ambitieux.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-slate-950 bg-white hover:bg-slate-200 rounded-2xl shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95">
                            ACCÉDER AU DASHBOARD
                        </a>
                    @else
                        <a href="{{ route('register') }}" wire:navigate
                            class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-white bg-primary hover:bg-primary-light rounded-2xl shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95">
                            REJOINDRE L'AVENTURE
                        </a>
                        <a href="{{ route('login') }}" wire:navigate
                            class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-white glass-dark rounded-2xl hover:bg-white/10 transition-all duration-300 hover:scale-105 active:scale-95">
                            SE CONNECTER
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>


</div>
