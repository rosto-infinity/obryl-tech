<div class="bg-white dark:bg-gray-950 min-h-screen pb-20">
    <!-- Hero Section -->
    <div class="relative w-full h-[60vh] overflow-hidden bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <img 
            src="{{ $article->featured_image ?? 'https://via.placeholder.com/1920x1080/F9FAFB/F9FAFB?text=OBRYL+TECH' }}" 
            alt="{{ $article->title }}"
            class="w-full h-full object-cover opacity-90 transition-transform duration-[3s] hover:scale-105"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-gray-950 via-white/40 dark:via-gray-950/40 to-transparent"></div>
        
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 w-full">
                <!-- Back Button -->
                <a href="{{ route('blog.index') }}" wire:navigate class="inline-flex items-center text-gray-400 dark:text-gray-500 hover:text-primary mb-8 transition-all group">
                    <div class="w-10 h-10 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center mr-4 group-hover:border-primary/50 group-hover:bg-primary/5 dark:group-hover:bg-primary/10 transition-all">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em]">Retour aux expertises</span>
                </a>

                <!-- Category -->
                @if($article->category)
                    <div class="mb-6">
                        <span class="inline-flex items-center px-5 py-2 rounded-2xl bg-primary/10 dark:bg-primary/20 backdrop-blur-xl text-primary text-[10px] font-black border border-secondary/20 dark:border-secondary/30 uppercase tracking-[0.2em] shadow-sm">
                            <span class="mr-2 text-lg leading-none">{{ $article->category->icon() }}</span>
                            {{ $article->category->label() }}
                        </span>
                    </div>
                @endif

                <h1 class="text-4xl md:text-7xl font-black text-gray-900 dark:text-white leading-[1.1] mb-8 tracking-tighter max-w-4xl">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-8 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                    <div class="flex items-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center mr-4 overflow-hidden shadow-sm transform group-hover:rotate-6 transition-transform">
                            <span class="text-primary font-black text-lg">{{ substr($article->author->name, 0, 1) }}</span>
                        </div>
                        <span class="group-hover:text-primary transition-colors">{{ $article->author->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $article->published_at?->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $article->reading_time }} min de lecture
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 grid grid-cols-1 lg:grid-cols-4 gap-16">
        
        <!-- Sidebar - Left: Share & Stats -->
        <div class="hidden lg:block lg:col-span-1 space-y-16">
            <div class="sticky top-24 space-y-12">
                <!-- Stats Box -->
                <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-100/50 dark:shadow-gray-900/50 overflow-hidden relative group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 dark:bg-primary/10 rounded-full blur-2xl"></div>
                    
                    <div class="grid grid-cols-1 gap-6 relative z-10">
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-3xl border border-gray-100 dark:border-gray-600 flex flex-col items-center">
                            <div class="text-primary font-black text-3xl mb-1 tracking-tighter">{{ number_format($article->views_count) }}</div>
                            <div class="text-[8px] text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em] font-black">Impact Vues</div>
                        </div>
                        @auth
                            <button 
                                wire:click="toggleLike"
                                class="p-6 rounded-3xl transition-all flex flex-col items-center group/like {{ $hasLiked ? 'bg-primary text-white shadow-2xl shadow-primary/20 border border-primary/30' : 'bg-white dark:bg-gray-700 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 border border-gray-100 dark:border-gray-600' }}"
                            >
                                <div class="font-black text-3xl mb-1 tracking-tighter flex items-center">
                                    <svg class="w-6 h-6 mr-3 {{ $hasLiked ? 'fill-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ number_format($article->likes_count) }}
                                </div>
                                <div class="text-[8px] uppercase tracking-[0.4em] font-black {{ $hasLiked ? 'text-white' : 'text-gray-400 dark:text-gray-500' }}">Propulser</div>
                            </button>
                        @else
                            <div class="p-6 bg-white dark:bg-gray-700 rounded-3xl border border-gray-100 dark:border-gray-600 flex flex-col items-center group/like opacity-60">
                                <div class="font-black text-3xl mb-1 tracking-tighter flex items-center text-gray-300 dark:text-gray-600">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    {{ number_format($article->likes_count) }}
                                </div>
                                <div class="text-[8px] uppercase tracking-[0.4em] font-black text-gray-300 dark:text-gray-600">Connectez-vous</div>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Tags -->
                <div class="space-y-6 px-4">
                    <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em]">Expertises associées</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags ?? [] as $tag)
                            <a href="#" class="px-4 py-2 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 text-[10px] font-bold rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary hover:text-primary dark:hover:text-primary transition-all uppercase tracking-widest">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Body & Comments -->
        <div class="lg:col-span-3 space-y-24">
            <!-- Prose Content -->
            <article class="prose dark:prose-invert prose-2xl max-w-none 
                prose-primary 
                prose-headings:font-black prose-headings:tracking-tighter prose-headings:text-gray-900 dark:prose-headings:text-white
                prose-p:text-gray-600 dark:prose-p:text-gray-300 prose-p:leading-relaxed
                prose-a:text-primary prose-a:font-bold prose-a:no-underline hover:prose-a:underline
                prose-blockquote:border-primary prose-blockquote:bg-gray-50 dark:prose-blockquote:bg-gray-800 prose-blockquote:rounded-3xl prose-blockquote:p-10 dark:prose-blockquote:text-gray-300
                prose-img:rounded-[3rem] prose-img:border prose-img:border-gray-100 dark:prose-img:border-gray-700
                prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-pre:rounded-[2rem] prose-pre:border prose-pre:border-gray-800 dark:prose-pre:border-gray-700
                prose-code:text-gray-900 dark:prose-code:text-gray-100 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:font-mono
                prose-strong:text-gray-900 dark:prose-strong:text-white
                prose-li:text-gray-600 dark:prose-li:text-gray-300
                prose-hr:border-gray-100 dark:prose-hr:border-gray-800">
                {!! \Illuminate\Support\Str::markdown($article->content ?? '') !!}
            </article>

            <div class="lg:hidden flex justify-center py-12">
                @auth
                    <button 
                        wire:click="toggleLike"
                        class="flex items-center space-x-4 px-12 py-6 rounded-[2rem] transition-all transform hover:scale-105 active:scale-95 {{ $hasLiked ? 'bg-primary text-white shadow-2xl shadow-primary/30' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 shadow-xl' }}"
                    >
                        <svg class="w-8 h-8" fill="{{ $hasLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-black text-2xl tracking-tighter">{{ $article->likes_count }}</span>
                    </button>
                @else
                    <div class="flex items-center space-x-4 px-12 py-6 rounded-[2rem] bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-300 dark:text-gray-600 shadow-sm opacity-60">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="font-black text-2xl tracking-tighter">{{ $article->likes_count }}</span>
                    </div>
                @endauth
            </div>

            <hr class="border-gray-100 dark:border-gray-800 h-px w-full">

            <!-- Comments Section -->
            <section id="comments" class="space-y-16">
                <div class="flex items-center justify-between">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter">Réactions <span class="text-primary">({{ count(array_filter($article->comments ?? [], fn($c) => $c['status'] === 'approved')) }})</span></h2>
                </div>

                <!-- Add Comment Form -->
                @auth
                    <div class="bg-gray-50 dark:bg-gray-800 p-10 rounded-[3rem] border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-100/50 dark:shadow-gray-900/50 relative overflow-hidden group">
                        <div class="absolute -right-20 -top-20 w-60 h-60 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
                        
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center tracking-tight">
                            Contribuer à la discussion
                        </h3>

                        @if (session('comment_status'))
                            <div class="mb-8 p-6 bg-primary/10 dark:bg-primary/20 text-primary text-sm font-black rounded-3xl border border-primary/20 dark:border-primary/30 animate-pulse uppercase tracking-widest">
                                {{ session('comment_status') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="addComment" class="space-y-6">
                            <textarea 
                                wire:model="commentContent"
                                placeholder="Votre analyse ou question..." 
                                class="w-full h-40 px-8 py-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 rounded-3xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none text-lg font-medium"
                            ></textarea>
                            @error('commentContent') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest px-4">{{ $message }}</span> @enderror
                            
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-8">
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-[0.2em] max-w-sm">
                                    Votre expertise technique est partagée instantanément avec la communauté.
                                </p>
                                <button 
                                    type="submit" 
                                    class="w-full sm:w-auto px-12 py-5 bg-primary hover:bg-gray-900 dark:hover:bg-gray-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-primary/20 transform hover:-rotate-1 active:scale-95 uppercase tracking-widest text-xs"
                                    wire:loading.attr="disabled"
                                    wire:target="addComment"
                                >
                                    <span wire:loading.remove wire:target="addComment">Soumettre</span>
                                    <span wire:loading wire:target="addComment">Validation...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-gray-800 p-12 rounded-[3rem] border border-gray-100 dark:border-gray-700 text-center relative overflow-hidden group">
                        <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10 space-y-8">
                            <div class="w-20 h-20 bg-white dark:bg-gray-700 rounded-3xl border border-gray-100 dark:border-gray-600 flex items-center justify-center mx-auto shadow-sm">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div class="space-y-4">
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Participez à la conversation</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium max-w-md mx-auto leading-relaxed">
                                    Connectez-vous à votre compte Obryl Tech pour partager votre analyse technique ou poser vos questions sur cette expertise.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <a href="{{ route('login') }}" wire:navigate class="px-10 py-4 bg-primary text-white font-black rounded-2xl transition-all shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 uppercase tracking-widest text-[10px]">
                                    Se connecter
                                </a>
                                <a href="{{ route('register') }}" wire:navigate class="px-10 py-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 font-black rounded-2xl transition-all hover:bg-gray-50 dark:hover:bg-gray-600 hover:scale-105 active:scale-95 uppercase tracking-widest text-[10px]">
                                    Créer un compte
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-8">
                    @forelse(array_filter($article->comments ?? [], fn($c) => $c['status'] === 'approved') as $comment)
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 hover:border-primary/20 transition-all shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-600 flex items-center justify-center mr-4">
                                        <span class="text-primary text-sm font-black uppercase">{{ substr($comment['user_name'], 0, 1) }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-900 dark:text-white font-black text-sm uppercase tracking-wider">{{ $comment['user_name'] }}</span>
                                        <span class="text-[9px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-[0.2em] mt-1">
                                            {{ \Illuminate\Support\Carbon::parse($comment['created_at'])->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed font-medium">
                                {{ $comment['content'] }}
                            </p>
                        </div>
                    @empty
                        <!-- Sans commentaires -->
                    @endforelse
                </div>
            </section>

            <!-- Similar Articles -->
            @if(count($similarArticles) > 0)
                <section class="space-y-12">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter">Continuer <span class="text-primary italic">l'exploration</span></h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($similarArticles as $similar)
                            <a href="{{ route('blog.show', $similar->slug) }}" wire:navigate class="group block bg-gray-50 dark:bg-gray-800 rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/20 hover:bg-white dark:hover:bg-gray-700 transition-all p-6 shadow-sm hover:shadow-xl">
                                <div class="aspect-video relative overflow-hidden rounded-[2rem] mb-6">
                                    <img 
                                        src="{{ $similar->featured_image ?? 'https://via.placeholder.com/600x400/F9FAFB/111827?text=OBRYL+TECH' }}" 
                                        alt="{{ $similar->title }}"
                                        class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                    >
                                </div>
                                <h3 class="text-gray-900 dark:text-white font-bold leading-tight group-hover:text-primary transition-colors line-clamp-2 text-lg tracking-tight">
                                    {{ $similar->title }}
                                </h3>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
