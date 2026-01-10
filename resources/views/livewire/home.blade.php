<div>
<!-- Hero Section -->
<section class="relative bg-white pt-32 pb-24 overflow-hidden border-b border-zinc-100">
    <!-- Motif de fond technique discret -->
    <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl">
            <h1 class="text-6xl md:text-8xl font-bold tracking-tight text-black mb-8 leading-[0.9]">
                ENGINEERING <br/>
                <span class="text-primary">THE FUTURE</span>
            </h1>
            <p class="text-xl md:text-2xl text-zinc-600 mb-12 max-w-2xl leading-relaxed">
                Plateforme d'élite connectant les visions innovantes aux architectes du code. Précision, performance et excellence technique.
            </p>
            <div class="flex flex-col sm:flex-row gap-6">
                <a href="{{ route('projects.list') }}" wire:navigate
                   class="inline-flex items-center justify-center bg-black text-white px-10 py-5 text-lg font-medium hover:bg-zinc-800 transition-all duration-300 group">
                    Explorer les Projets
                    <svg class="ml-3 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('developers.list') }}" wire:navigate
                   class="inline-flex items-center justify-center border-2 border-black text-black px-10 py-5 text-lg font-medium hover:bg-black hover:text-white transition-all duration-300">
                    Trouver un Développeur
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="py-24 bg-zinc-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-16">
            <div>
                <h2 class="text-xs font-bold tracking-widest text-primary uppercase mb-4">Derniers Projets</h2>
                <h3 class="text-4xl font-bold text-black leading-none">RÉALISATIONS RÉCENTES</h3>
            </div>
            <a href="{{ route('projects.list') }}" wire:navigate class="text-black font-medium border-b-2 border-primary pb-1 hover:text-primary transition-colors">
                Voir tout le portfolio
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @forelse($latestProjects as $project)
                <div class="group bg-white border border-zinc-200 overflow-hidden hover:border-black transition-all duration-500">
                    <div class="aspect-video overflow-hidden bg-zinc-100">
                        @if($project->featured_image)
                            <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 transform group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-8">
                        <div class="flex gap-2 mb-4">
                            @foreach(array_slice($project->technologies ?? [], 0, 3) as $tech)
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 bg-zinc-100 text-zinc-500">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <h4 class="text-xl font-bold mb-4 group-hover:text-primary transition-colors">{{ $project->title }}</h4>
                        <p class="text-zinc-600 text-sm mb-6 line-clamp-2">{{ $project->description }}</p>
                        <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate class="text-xs font-bold uppercase tracking-widest flex items-center group/link">
                            Détails du projet
                            <svg class="ml-2 w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-zinc-500">Aucun projet récent disponible.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Developers Section -->
<section class="py-24 bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-xs font-bold tracking-widest text-primary uppercase mb-4">Expertise</h2>
            <h3 class="text-4xl md:text-5xl font-bold">L'ÉQUIPE TECHNIQUE</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredDevelopers as $developer)
                <div class="text-center group">
                    <div class="relative mb-6 inline-block">
                        <div class="absolute inset-0 bg-primary transform translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-300"></div>
                        @php
                            $avatar = $developer->profile?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($developer->name).'&color=7F9CF5&background=EBF4FF';
                        @endphp
                        <img src="{{ $avatar }}" alt="{{ $developer->name }}" class="relative w-48 h-48 object-cover border-2 border-white grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <h4 class="text-xl font-bold mb-1">{{ $developer->name }}</h4>
                    <p class="text-zinc-400 text-sm mb-4">{{ $developer->profile?->title ?? 'Développeur Expert' }}</p>
                    <a href="{{ route('developers.profile', $developer->id) }}" wire:navigate class="inline-block text-xs font-bold uppercase tracking-widest border border-zinc-800 px-6 py-2 hover:bg-white hover:text-black transition-all">
                        Voir le profil
                    </a>
                </div>
            @empty
                <p class="text-zinc-500 col-span-full text-center">Aucun développeur disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
            <div class="max-w-xl">
                <h2 class="text-xs font-bold tracking-widest text-primary uppercase mb-4">Insights</h2>
                <h3 class="text-4xl font-bold text-black mb-4">DERNIÈRES ACTUALITÉS TECH</h3>
                <p class="text-zinc-500">Analyses, tutoriels et nouveautés sur l'écosystème technologique.</p>
            </div>
            <a href="{{ route('blog.index') }}" wire:navigate class="text-black font-medium border-b-2 border-primary pb-1 hover:text-primary transition-colors">
                Explorer tout le blog
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @forelse($recentArticles as $article)
                <article class="group">
                    <div class="aspect-[16/9] overflow-hidden bg-zinc-100 mb-8 border border-zinc-100">
                        @if($article->featured_image)
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-all duration-700 transform group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14 3v6h6"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-4">
                        <span class="text-primary">{{ $article->category?->label() ?? 'Article' }}</span>
                        <span>•</span>
                        <span>{{ $article->published_at?->format('d M Y') }}</span>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 group-hover:text-primary transition-colors leading-tight">
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate>{{ $article->title }}</a>
                    </h4>
                    <p class="text-zinc-600 mb-6 leading-relaxed line-clamp-3">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <a href="{{ route('blog.show', $article->slug) }}" wire:navigate class="inline-flex items-center text-xs font-bold uppercase tracking-widest group/more">
                        Lire l'article
                        <svg class="ml-2 w-4 h-4 transform group-hover/more:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </article>
            @empty
                <p class="text-zinc-500">Aucun article disponible.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-24 bg-zinc-50 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-5xl md:text-7xl font-bold text-black mb-10 tracking-tight">
            PRÊT À <span class="text-primary">CODER</span> <br/>L'AVENIR ?
        </h2>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="bg-black text-white px-12 py-5 font-bold hover:bg-zinc-800 transition-all">
                    ACCÉDER AU DASHBOARD
                </a>
            @else
                <a href="{{ route('register') }}" wire:navigate
                   class="bg-black text-white px-12 py-5 font-bold hover:bg-zinc-800 transition-all">
                    REJOINDRE LA PLATEFORME
                </a>
                <a href="{{ route('login') }}" wire:navigate
                   class="border-2 border-black text-black px-12 py-5 font-bold hover:bg-black hover:text-white transition-all">
                    SE CONNECTER
                </a>
            @endif
        </div>
    </div>
</section>
</div>
