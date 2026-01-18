<div class="bg-background min-h-screen">
    <div class="max-w-7xl mx-auto px-6 pt-16 md:pt-24 pb-24">
        
        <!-- Header Section -->
        <header class="flex flex-col md:flex-row items-center gap-12 lg:gap-20 mb-20 md:mb-32">
            <div class="w-full md:w-[60%] order-2 md:order-1 flex flex-col justify-center">
                @if($article->category)
                    <div class="mb-8">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-md bg-muted text-foreground text-[11px] font-bold border border-border/50">
                            {{ $article->category->label() }}
                        </span>
                    </div>
                @endif

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground leading-tight mb-12 tracking-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center gap-4">
                    <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}" class="w-12 h-12 rounded-md object-cover shadow-md">
                    <div class="flex flex-col">
                        <span class="text-base font-bold text-foreground leading-none mb-1">
                            {{ $article->author->name }}
                        </span>
                        <div class="flex items-center text-xs text-muted-foreground font-medium gap-3">
                            <span class="flex items-center transition-colors">
                                {{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-border"></span>
                            <span class="flex items-center transition-colors">
                                {{ $article->reading_time }} min de lecture
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-[40%] order-1 md:order-2">
                <div class="relative aspect-[4/3] overflow-hidden rounded-md shadow-lg border border-border/50">
                    <img 
                        src="{{ $article->featured_image_url }}" 
                        alt="{{ $article->title }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
            </div>
        </header>

        <div class="flex flex-col lg:flex-row gap-16 xl:gap-24">
            <!-- Main Content -->
            <main class="flex-1 max-w-[850px]">
                <article class="prose prose-zinc dark:prose-invert prose-lg max-w-none
                    prose-h2:text-3xl prose-h2:font-bold prose-h2:tracking-tight prose-h2:mt-12 prose-h2:mb-6
                    prose-h3:text-2xl prose-h3:font-bold prose-h3:mt-8 prose-h3:mb-4
                    prose-p:text-foreground/80 prose-p:leading-relaxed prose-p:mb-8 font-medium
                    prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:italic prose-blockquote:text-foreground/70 prose-blockquote:pl-6 prose-blockquote:my-12 prose-blockquote:bg-muted/30 prose-blockquote:rounded-r-md
                    prose-img:rounded-md prose-img:shadow-lg prose-img:my-16 prose-img:border border-border/50
                    prose-a:text-primary prose-a:font-bold prose-a:underline prose-a:underline-offset-4 hover:prose-a:opacity-80 transition-all
                    prose-hr:border-border/50 prose-hr:my-20
                    prose-pre:bg-card prose-pre:border prose-pre:border-border prose-pre:rounded-md prose-pre:p-6 shadow-sm
                    prose-code:text-primary prose-code:font-bold prose-code:bg-muted prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded">
                    
                    <x-markdown-renderer>
                        {!! $article->content ?? '' !!}
                    </x-markdown-renderer>
                </article>

                <!-- Footer / Likes -->
                <footer class="mt-20 pt-12 border-t border-border">
                    <div class="py-12 px-8 bg-card rounded-md border border-border text-center">
                        <p class="text-xs font-bold text-muted-foreground mb-8">L'intelligence est faite pour être partagée</p>
                        @auth
                            <button 
                                wire:click="toggleLike"
                                class="inline-flex items-center gap-4 px-10 py-4 rounded-md transition-all duration-300 {{ $hasLiked ? 'bg-primary text-primary-foreground shadow-lg shadow-primary/20 scale-105' : 'bg-background border-2 border-border text-muted-foreground hover:border-primary hover:text-primary' }}"
                            >
                                <svg class="w-6 h-6 {{ $hasLiked ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span class="font-bold text-xl tracking-tight">{{ number_format($article->likes_count) }}</span>
                            </button>
                        @else
                            <div class="inline-flex items-center gap-4 px-10 py-4 rounded-md bg-muted border border-border text-muted-foreground opacity-50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span class="font-bold text-xl tracking-tight">{{ number_format($article->likes_count) }}</span>
                            </div>
                            <p class="mt-6 text-xs text-muted-foreground font-medium">
                                <a href="{{ route('login') }}" class="text-foreground font-bold hover:underline transition-all">Connectez-vous</a> pour réagir.
                            </p>
                        @endauth
                    </div>
                </footer>
            </main>

            <!-- Sidebar -->
            <aside class="w-full lg:w-[320px] shrink-0">
                <div class="sticky top-10 space-y-16">
                    <div class="space-y-6">
                        <h3 class="text-[11px] font-bold text-muted-foreground tracking-wider">diffuser l'expertise</h3>
                        <div class="flex items-center gap-3">
                            <button class="w-12 h-12 flex items-center justify-center rounded-md bg-card border border-border text-foreground hover:bg-primary hover:text-primary-foreground hover:border-primary transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </button>
                            <button class="w-12 h-12 flex items-center justify-center rounded-md bg-card border border-border text-foreground hover:bg-primary hover:text-primary-foreground hover:border-primary transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </button>
                        </div>
                    </div>

                    @if(count($similarArticles) > 0)
                        <div class="space-y-8">
                            <h3 class="text-[11px] font-bold text-muted-foreground tracking-wider">explorations connexes</h3>
                            <div class="space-y-10">
                                @foreach($similarArticles as $similar)
                                    <article class="group">
                                        <a href="{{ route('blog.show', $similar->slug) }}" wire:navigate class="block space-y-4">
                                            <div class="aspect-video overflow-hidden rounded-md bg-muted border border-border/50 transition-all duration-500">
                                                <img 
                                                    src="{{ $similar->featured_image_url }}" 
                                                    alt="{{ $similar->title }}"
                                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                >
                                            </div>
                                            <h4 class="text-lg font-bold text-foreground group-hover:text-primary transition-colors line-clamp-2 leading-tight tracking-tight">
                                                {{ $similar->title }}
                                            </h4>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($article->tags && count($article->tags) > 0)
                        <div class="space-y-6">
                            <h3 class="text-[11px] font-bold text-muted-foreground tracking-wider">mots clés</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($article->tags as $tag)
                                    <span class="px-3 py-1 bg-muted text-foreground text-[10px] font-bold rounded-md border border-border/50 hover:border-primary/30 transition-all cursor-default">
                                        #{{ strtolower($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </aside>
        </div>

        <!-- Comments Section -->
        <section id="comments" class="max-w-4xl mx-auto mt-32 lg:mt-48 pt-16 border-t border-border">
            <div class="flex items-center justify-between mb-16">
                <h2 class="text-3xl font-bold text-foreground tracking-tight">
                    discours technique
                    <span class="ml-4 text-muted-foreground font-medium text-xl">/ {{ count(array_filter($article->comments ?? [], fn($c) => $c['status'] === 'approved')) }}</span>
                </h2>
            </div>

            @auth
                <div class="bg-card p-8 rounded-md border border-border shadow-sm mb-16">
                    <h3 class="text-xs font-bold text-foreground tracking-wider mb-8">contribuer à l'analyse</h3>
                    
                    @if (session('comment_status'))
                        <div class="mb-8 p-4 bg-primary/10 text-primary text-xs font-bold rounded-md tracking-wide">
                            {{ session('comment_status') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="addComment" class="space-y-8">
                        <div class="rounded-md overflow-hidden border border-border focus-within:border-primary/50 transition-all">
                             <livewire:markdown-editor 
                                wire:model="commentContent"
                                placeholder="Partagez votre expertise..." 
                            />
                        </div>
                        @error('commentContent') <p class="text-xs text-destructive font-bold px-2">{{ $message }}</p> @enderror
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                class="px-8 py-3 bg-primary text-primary-foreground text-sm font-bold rounded-md transition-all hover:translate-y-[-2px] shadow-lg shadow-primary/20"
                                wire:loading.attr="disabled"
                                wire:target="addComment"
                            >
                                <span wire:loading.remove wire:target="addComment">publier</span>
                                <span wire:loading wire:target="addComment">compilation...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-12 border-2 border-dashed border-border rounded-md text-center mb-16 bg-muted/10">
                    <p class="text-base text-muted-foreground mb-8 font-bold">Veuillez vous authentifier pour contribuer.</p>
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-primary text-primary-foreground text-sm font-bold rounded-md transition-all hover:translate-y-[-2px] shadow-lg shadow-primary/20">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-background border border-border text-foreground text-sm font-bold rounded-md transition-all hover:border-primary hover:text-primary">
                            S'inscrire
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-16">
                @php
                    $approvedComments = collect($article->comments ?? [])
                        ->filter(fn($c) => ($c['status'] ?? '') === 'approved')
                        ->sortByDesc('created_at');
                @endphp

                @forelse($approvedComments as $comment)
                    <div class="group border-l-2 border-border/50 pl-8 py-2 hover:border-primary transition-all duration-500">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-md bg-muted flex items-center justify-center text-sm font-bold text-muted-foreground border border-border">
                                {{ substr($comment['user_name'] ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-base font-bold text-foreground">{{ $comment['user_name'] ?? 'Anonyme' }}</span>
                                <span class="text-[10px] font-medium text-muted-foreground mt-0.5">
                                    {{ \Illuminate\Support\Carbon::parse($comment['created_at'])->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="pl-14">
                            <div class="prose prose-zinc dark:prose-invert max-w-none text-base text-foreground/80 leading-relaxed font-medium">
                                <x-markdown-renderer>
                                    {!! $comment['content'] !!}
                                </x-markdown-renderer>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center opacity-40">
                        <p class="text-xs font-bold text-muted-foreground tracking-[0.2em] italic">Aucune contribution technique pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
