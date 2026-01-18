<nav
    class="bg-background/80 backdrop-blur-xl border-b border-border sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center group">
                    <img src="/Obryl.com.png" alt="Obryl Tech" class="h-8 transition-transform duration-500 group-hover:scale-105">
                </a>
            </div>

            <!-- Navigation Desktop -->
            <div class="hidden lg:block">
                <div class="flex items-center space-x-1">
                    <a href="{{ route('projects.list') }}" 
                        class="px-4 py-2 text-sm font-medium {{ request()->routeIs('projects.*') ? 'text-primary' : 'text-foreground/60 hover:text-primary' }} transition-colors"
                        wire:navigate>Projets</a>

                    <a href="{{ route('developers.list') }}"
                        class="px-4 py-2 text-sm font-medium {{ request()->routeIs('developers.*') ? 'text-primary' : 'text-foreground/60 hover:text-primary' }} transition-colors"
                        wire:navigate>Maestros</a>

                    <a href="{{ route('portfolio.gallery') }}"
                        class="px-4 py-2 text-sm font-medium {{ request()->routeIs('portfolio.*') ? 'text-primary' : 'text-foreground/60 hover:text-primary' }} transition-colors"
                        wire:navigate>Galerie</a>

                    <a href="{{ route('reviews.public') }}"
                        class="px-4 py-2 text-sm font-medium {{ request()->routeIs('reviews.public') ? 'text-primary' : 'text-foreground/60 hover:text-primary' }} transition-colors"
                        wire:navigate>Avis</a>

                    <a href="{{ route('blog.index') }}"
                        class="px-4 py-2 text-sm font-medium {{ request()->routeIs('blog.*') ? 'text-primary' : 'text-foreground/60 hover:text-primary' }} transition-colors"
                        wire:navigate>Blog</a>
                </div>
            </div>

            <!-- Actions Desktop -->
            <div class="hidden lg:flex items-center gap-4">
                 @auth
                    <div class="flex items-center gap-4">
                        <livewire:notification.notification-bell mode="link" />
                        
                        <a href="{{ route('dashboard') }}" 
                            class="px-4 py-2 bg-foreground dark:bg-muted text-background dark:text-foreground text-sm font-medium rounded-md hover:bg-primary hover:text-primary-foreground transition-all duration-300"
                            wire:navigate>Dashboard</a>

                        <a href="{{ route('projects.request') }}"
                            class="px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md hover:scale-105 transition-all duration-300"
                            wire:navigate>Lancer un projet</a>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" 
                            class="px-4 py-2 text-sm font-medium text-foreground hover:text-primary transition-colors"
                            wire:navigate>connexion</a>

                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md hover:scale-105 transition-all duration-300 shadow-lg shadow-primary/20"
                            wire:navigate>rejoindre</a>
                    </div>
                @endauth

                <div class="w-[1px] h-6 bg-border mx-2"></div>

                <!-- Appearance Toggle -->
                 <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="sun"></flux:radio>
                    <flux:radio value="dark" icon="moon"></flux:radio>
                 </flux:radio.group>         
            </div>

            <!-- Mobile Button -->
            <div class="lg:hidden flex items-center gap-4">
               <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="sun"></flux:radio>
                    <flux:radio value="dark" icon="moon"></flux:radio>
                </flux:radio.group>
                <button type="button" class="text-foreground p-2" id="mobile-menu-button" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden animate-in fade-in slide-in-from-top-4" id="mobile-menu">
            <div class="py-6 space-y-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('projects.list') }}" class="text-base font-medium {{ request()->routeIs('projects.*') ? 'text-primary' : 'text-foreground' }}" wire:navigate>Projets</a>
                    <a href="{{ route('developers.list') }}" class="text-base font-medium {{ request()->routeIs('developers.*') ? 'text-primary' : 'text-foreground' }}" wire:navigate>Maestros</a>
                    <a href="{{ route('portfolio.gallery') }}" class="text-base font-medium {{ request()->routeIs('portfolio.*') ? 'text-primary' : 'text-foreground' }}" wire:navigate>Galerie</a>
                    <a href="{{ route('blog.index') }}" class="text-base font-medium {{ request()->routeIs('blog.*') ? 'text-primary' : 'text-foreground' }}" wire:navigate>Blog</a>
                </div>

                <div class="pt-6 border-t border-border flex flex-col gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full py-3 text-center bg-foreground dark:bg-muted text-background dark:text-foreground font-medium rounded-md">Dashboard</a>
                        <a href="{{ route('projects.request') }}" class="w-full py-3 text-center bg-primary text-primary-foreground font-medium rounded-md">Lancer un projet</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-3 text-center border-2 border-border text-foreground font-medium rounded-md">Connexion</a>
                        <a href="{{ route('register') }}" class="w-full py-3 text-center bg-primary text-primary-foreground font-medium rounded-md">Rejoindre</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>
