<div>
    <!-- Hero Section OBRYL TECH - Professional Design -->
    <section class="relative min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 pt-20 pb-16 md:pt-32 md:pb-24 overflow-hidden">

        <!-- Animated Grid Background -->
        <div class="absolute inset-0 opacity-3">
            <div class="absolute inset-0"
                style="background-image: 
            linear-gradient(0deg, transparent 24%, rgba(53, 154, 105, 0.1) 25%, rgba(53, 154, 105, 0.1) 26%, transparent 27%, transparent 74%, rgba(53, 154, 105, 0.1) 75%, rgba(53, 154, 105, 0.1) 76%, transparent 77%, transparent),
            linear-gradient(90deg, transparent 24%, rgba(53, 154, 105, 0.1) 25%, rgba(53, 154, 105, 0.1) 26%, transparent 27%, transparent 74%, rgba(53, 154, 105, 0.1) 75%, rgba(53, 154, 105, 0.1) 76%, transparent 77%, transparent);
            background-size: 50px 50px;">
            </div>
        </div>

        <!-- Floating Particles Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute animate-float-up"
                style="left: 10%; bottom: -50px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%); border-radius: 50%; filter: blur(40px);">
            </div>
            <div class="absolute animate-float-up"
                style="left: 50%; bottom: -50px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(249, 115, 22, 0.08) 0%, transparent 70%); border-radius: 50%; filter: blur(40px); animation-delay: 1s;">
            </div>
            <div class="absolute animate-float-up"
                style="left: 80%; bottom: -50px; width: 90px; height: 90px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); border-radius: 50%; filter: blur(40px); animation-delay: 2s;">
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <!-- Left Content -->
                <div class="text-left space-y-8">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                        <span class="text-xs md:text-sm font-semibold uppercase tracking-wider text-primary">Bienvenue à OBRYL TECH</span>
                    </div>

                    <!-- Main Title -->
                    <div class="space-y-4">
                        <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight text-slate-900 leading-tight animate-in fade-in slide-in-from-top-6 duration-700 delay-100">
                            <span class="block">OBRYL</span>
                            <span class="relative inline-block text-primary">TECH</span>
                        </h1>

                        <!-- Subtitle -->
                        <p class="text-xl md:text-2xl font-light text-slate-700 animate-in fade-in slide-in-from-top-6 duration-700 delay-200">
                            L'INGÉNIERIE DE L'EXCELLENCE DIGITALE
                        </p>
                    </div>

                    <!-- Description -->
                    <p class="text-base md:text-lg text-slate-600 max-w-2xl leading-relaxed animate-in fade-in slide-in-from-top-6 duration-700 delay-300">
                        Plateforme d'élite où l'innovation rencontre l'expertise technique. Connectez-vous avec les meilleurs développeurs et transformez vos idées en réalité.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 animate-in fade-in slide-in-from-top-6 duration-700 delay-400">
                        <!-- Primary Button -->
                        <a href="{{ route('projects.list') }}" wire:navigate
                            class="inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white bg-primary hover:bg-primary/90 active:bg-primary/80 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Explorer les Projets
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>

                        <!-- Secondary Button -->
                        <a href="{{ route('developers.list') }}" wire:navigate
                            class="inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-primary bg-white border-2 border-primary hover:bg-primary/10 active:bg-primary/20 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Trouver un Expert
                        </a>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-3 gap-8 pt-12 border-t border-slate-200 animate-in fade-in slide-in-from-top-6 duration-700 delay-500">
                        <div class="space-y-2">
                            <div class="text-3xl md:text-4xl font-black text-primary">500+</div>
                            <p class="text-sm text-slate-600">Projets</p>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl md:text-4xl font-black text-secondary">150+</div>
                            <p class="text-sm text-slate-600">Experts</p>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl md:text-4xl font-black text-primary">98%</div>
                            <p class="text-sm text-slate-600">Satisfaction</p>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Elements -->
                <div class="hidden lg:flex items-center justify-center relative h-96">
                    <div class="absolute inset-0 space-y-8">

                        <!-- Card 1 - Innovation -->
                        <div class="absolute top-0 right-0 w-56 bg-white border border-primary/20 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:border-primary transition-all duration-300 group cursor-pointer">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-primary mb-2">Innovation</p>
                                    <p class="text-sm text-slate-700 leading-relaxed">Solutions technologiques avancées</p>
                                </div>
                                <div class="w-2 h-2 rounded-full bg-primary/100 animate-pulse flex-shrink-0"></div>
                            </div>
                        </div>

                        <!-- Card 2 - Excellence -->
                        <div class="absolute bottom-20 left-0 w-56 bg-white border border-orange-200 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:border-orange-400 transition-all duration-300 group cursor-pointer">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-secondary mb-2">Excellence</p>
                                    <p class="text-sm text-slate-700 leading-relaxed">Qualité sans compromis</p>
                                </div>
                                <div class="w-2 h-2 rounded-full bg-orange-500 animate-pulse flex-shrink-0"></div>
                            </div>
                        </div>

                        <!-- Card 3 - Expertise -->
                        <div class="absolute top-1/2 right-1/4 w-56 bg-white border border-primary/20 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:border-primary transition-all duration-300 group cursor-pointer">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-primary mb-2">Expertise</p>
                                    <p class="text-sm text-slate-700 leading-relaxed">Équipe de professionnels</p>
                                </div>
                                <div class="w-2 h-2 rounded-full bg-primary/100 animate-pulse flex-shrink-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-20 md:py-32 ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-16 space-y-4">
                <div class="inline-flex items-center gap-2">
                    <div class="w-1 h-6 bg-primary rounded-full"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Portfolio</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-accent-foreground">RÉALISATIONS D'EXCEPTION</h2>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestProjects as $project)
                    <article class="group bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 hover:-translate-y-1">
                        <!-- Image -->
                        <div class="aspect-video overflow-hidden bg-slate-100">
                            @if ($project->featured_image)
                                <img src="{{ $project->featured_image }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 md:p-8 space-y-4">
                            <!-- Technologies -->
                            <div class="flex flex-wrap gap-2">
                                @foreach (array_slice($project->technologies ?? [], 0, 3) as $tech)
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-primary/90 bg-primary/10 border border-primary/20 rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-2">
                                {{ $project->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">
                                {{ $project->description }}
                            </p>

                            <!-- Link -->
                            <a href="{{ route('projects.detail', $project->slug) }}" wire:navigate
                                class="inline-flex items-center text-sm font-semibold text-primary hover:text-primary/90 group/link transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded px-2 py-1">
                                Découvrir le projet
                                <svg class="ml-2 w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-500 text-base">Aucun projet récent disponible.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Link -->
            <div class="mt-12 text-center">
                <a href="{{ route('projects.list') }}" wire:navigate
                    class="inline-flex items-center text-base font-semibold text-slate-900 hover:text-primary border-b-2 border-primary pb-1 transition-colors">
                    Voir tout le portfolio
                </a>
            </div>
        </div>
    </section>

    <!-- Developers Section -->
    <section class="py-20 md:py-32 bg-slate-900 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-16 text-center space-y-4">
                <div class="inline-flex items-center gap-2">
                    <div class="w-1 h-6 bg-primary/100 rounded-full"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Notre Équipe</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black">EXPERTS TECHNIQUES D'ÉLITE</h2>
            </div>

            <!-- Developers Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredDevelopers as $developer)
                    <div class="text-center group">
                        <!-- Avatar -->
                        <div class="relative mb-6 inline-block">
                            <div class="absolute inset-0 bg-primary rounded-2xl transform translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-300"></div>
                            @php
                                $avatar = $developer->profile?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($developer->name).'&color=10B981&background=F0FDF4';
                            @endphp
                            <img src="{{ $avatar }}" alt="{{ $developer->name }}"
                                class="relative w-48 h-48 object-cover rounded-2xl border-2 border-white transition-transform duration-300 group-hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>

                        <!-- Info -->
                        <h3 class="text-xl font-bold mb-1">{{ $developer->name }}</h3>
                        <p class="text-slate-400 text-sm mb-6">{{ $developer->profile?->title ?? 'Développeur Expert' }}</p>

                        <!-- Button -->
                        <a href="{{ route('developers.profile', $developer->id) }}" wire:navigate
                            class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold uppercase tracking-wider border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all duration-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-slate-900">
                            Voir le profil
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-400 text-base">Aucun expert disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-20 md:py-32 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-16 space-y-4">
                <div class="inline-flex items-center gap-2">
                    <div class="w-1 h-6 bg-primary rounded-full"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Insights</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900">ACTUALITÉS TECH & INNOVATIONS</h2>
                <p class="text-slate-600 text-base max-w-2xl">Analyses pointues, tutoriels experts et dernières tendances technologiques.</p>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($recentArticles as $article)
                    <article class="group flex flex-col h-full">
                        <!-- Image -->
                        <div class="aspect-video overflow-hidden bg-slate-100 mb-6 rounded-lg">
                            @if ($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Meta -->
                        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wider text-slate-500 mb-4 flex-wrap">
                            <span class="text-primary">{{ $article->category?->label() ?? 'Article' }}</span>
                            <span>•</span>
                            <span>{{ $article->published_at?->format('d M Y') }}</span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900 group-hover:text-primary transition-colors mb-3 line-clamp-2 flex-grow">
                            <a href="{{ route('blog.show', $article->slug) }}" wire:navigate
                                class="focus:outline-none focus:ring-2 focus:ring-primary rounded px-1">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <!-- Link -->
                        <a href="{{ route('blog.show', $article->slug) }}" wire:navigate
                            class="inline-flex items-center text-sm font-semibold text-primary hover:text-primary/90 group/more transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded px-2 py-1">
                            Lire l'article
                            <svg class="ml-2 w-4 h-4 transition-transform group-hover/more:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-500 text-base">Aucun article disponible.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Link -->
            <div class="mt-12 text-center">
                <a href="{{ route('blog.index') }}" wire:navigate
                    class="inline-flex items-center text-base font-semibold text-slate-900 hover:text-primary border-b-2 border-primary pb-1 transition-colors">
                    Explorer tout le blog
                </a>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 md:py-32 bg-primary text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-20 w-64 h-64 bg-secondary/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-10 left-20 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        </div>

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Title -->
            <h2 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tight leading-tight">
                PRÊT À <span class="text-secondary">TRANSFORMER</span> <br class="hidden sm:block"/>VOS IDÉES EN RÉALITÉ ?
            </h2>

            <!-- Description -->
            <p class="text-lg md:text-xl text-white/90 mb-12 max-w-2xl mx-auto leading-relaxed">
                Rejoignez la plateforme où l'excellence technique rencontre l'innovation créative. Votre projet mérite le meilleur.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-primary bg-white hover:bg-gray-50 active:bg-gray-100 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary">
                        ACCÉDER AU DASHBOARD
                    </a>
                @else
                    <a href="{{ route('register') }}" wire:navigate
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-primary bg-white hover:bg-gray-50 active:bg-gray-100 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary">
                        REJOINDRE OBRYL TECH
                    </a>
                    <a href="{{ route('login') }}" wire:navigate
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white border-2 border-white hover:bg-white hover:text-primary active:bg-gray-100 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary">
                        SE CONNECTER
                    </a>
                @endauth
            </div>
        </div>
    </section>

</div>
