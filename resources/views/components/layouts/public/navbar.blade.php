<nav
    class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 mb-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <flux:navlist.item href="{{ route('home') }}" :current="request()->routeIs('home')" wire:navigate>
                        <img src="/Obryl.com.png" alt="Obryl Tech" class="h-8">
                    </flux:navlist.item>
                </div>
            </div>

            <!-- Navigation Desktop -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <!-- Projets -->
                    <flux:navlist.item href="{{ route('projects.list') }}" :current="request()->routeIs('projects.*')"
                        wire:navigate>Projets
                    </flux:navlist.item>


                    <!-- Développeurs -->
                    <flux:navlist.item href="{{ route('developers.list') }}"
                        :current="request()->routeIs('developers.*')" wire:navigate>Développeurs</flux:navlist.item>

                    <!-- Portfolio -->
                    <flux:navlist.item href="{{ route('portfolio.gallery') }}"
                        :current="request()->routeIs('portfolio.*')" wire:navigate>Portfolio
                    </flux:navlist.item>

                    <!-- Avis -->
                    <flux:navlist.item href="{{ route('reviews.public') }}"
                        :current="request()->routeIs('reviews.public')" wire:navigate>Avis
                    </flux:navlist.item>

                    <!-- Blog -->
                    <flux:navlist.item href="{{ route('blog.index') }}"
                        :current="request()->routeIs('blog.*')" wire:navigate>Blog
                    </flux:navlist.item>

               



                    <!-- Actions utilisateur -->
                    @auth
                        <div class="flex items-center gap-4">
                            <livewire:notification.notification-bell mode="link" />
                            <flux:navlist.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard.*')"
                                wire:navigate>
                                <span
                                    class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/80 transition-colors duration-200">Dashboard</span>
                            </flux:navlist.item>
                        </div>
                    @else
                        <flux:navlist.item href="{{ route('login') }}" :current="request()->routeIs('login')" wire:navigate>
                            <span
                                class="bg-secondary text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-secondary/80 transition-colors duration-200">Connexion</span>
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('register') }}" :current="request()->routeIs('register')"
                            wire:navigate>
                            <span
                                class="border border-primary text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/10 transition-colors duration-200">Inscription</span>
                        </flux:navlist.item>
                    @endauth
                </div>
            </div>

            <!-- Appearance & Mobile menu button -->
            <div class="flex items-center gap-4">
                <!-- Appearance Toggle - Modern Design -->
                <div x-data="{ open: false }" class="relative">
                    <!-- Toggle Button -->
                    <button 
                        @click="open = !open" 
                        @click.outside="open = false"
                        type="button"
                        class="relative p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-300 group"
                        :class="open ? 'ring-2 ring-primary/30' : ''"
                    >
                        <!-- Sun Icon (Light) -->
                        <svg 
                            x-show="$flux.appearance === 'light'" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            class="h-5 w-5 text-yellow-500" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.657 5.657l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        
                        <!-- Moon Icon (Dark) -->
                        <svg 
                            x-show="$flux.appearance === 'dark'" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            class="h-5 w-5 text-blue-400" 
                            fill="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        
                        <!-- System Icon -->
                        <svg 
                            x-show="$flux.appearance === 'system'" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-50"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="h-5 w-5 text-gray-500 dark:text-gray-400" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-.75 3M9 20h6m-6 0H5m4 0h4m6-3V3a1 1 0 00-1-1H6a1 1 0 00-1 1v14a1 1 0 001 1h12a1 1 0 001-1zm-3-7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute right-0 mt-3 w-44 bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700 py-2 z-50 overflow-hidden"
                    >
                        <!-- Light Option -->
                        <button 
                            @click="$flux.appearance = 'light'; open = false"
                            class="w-full text-left px-4 py-3 flex items-center gap-3 transition-all duration-200"
                            :class="$flux.appearance === 'light' ? 'bg-primary/10 text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50 text-gray-700 dark:text-gray-300'"
                        >
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="$flux.appearance === 'light' ? 'bg-primary/20' : 'bg-yellow-100 dark:bg-yellow-900/30'">
                                <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.657 5.657l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Clair</span>
                            <svg x-show="$flux.appearance === 'light'" class="w-4 h-4 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <!-- Dark Option -->
                        <button 
                            @click="$flux.appearance = 'dark'; open = false"
                            class="w-full text-left px-4 py-3 flex items-center gap-3 transition-all duration-200"
                            :class="$flux.appearance === 'dark' ? 'bg-primary/10 text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50 text-gray-700 dark:text-gray-300'"
                        >
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="$flux.appearance === 'dark' ? 'bg-primary/20' : 'bg-blue-100 dark:bg-blue-900/30'">
                                <svg class="h-4 w-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Sombre</span>
                            <svg x-show="$flux.appearance === 'dark'" class="w-4 h-4 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <!-- System Option -->
                        <button 
                            @click="$flux.appearance = 'system'; open = false"
                            class="w-full text-left px-4 py-3 flex items-center gap-3 transition-all duration-200"
                            :class="$flux.appearance === 'system' ? 'bg-primary/10 text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50 text-gray-700 dark:text-gray-300'"
                        >
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="$flux.appearance === 'system' ? 'bg-primary/20' : 'bg-gray-100 dark:bg-gray-700'">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-.75 3M9 20h6m-6 0H5m4 0h4m6-3V3a1 1 0 00-1-1H6a1 1 0 00-1 1v14a1 1 0 001 1h12a1 1 0 001-1zm-3-7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Système</span>
                            <svg x-show="$flux.appearance === 'system'" class="w-4 h-4 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button type="button" class="text-gray-700 dark:text-gray-300 hover:text-primary p-2 md:hidden"
                    id="mobile-menu-button" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Accueil -->
                <flux:navlist.item href="{{ route('home') }}" :current="request()->routeIs('home')" wire:navigate>
                    Accueil
                </flux:navlist.item>

                <!-- Projets -->
                <flux:navlist.item href="{{ route('projects.list') }}" :current="request()->routeIs('projects.*')"
                    wire:navigate>Projets</flux:navlist.item>

                <!-- Développeurs -->
                <flux:navlist.item href="{{ route('developers.list') }}" :current="request()->routeIs('developers.*')"
                    wire:navigate>Développeurs</flux:navlist.item>

                <!-- Portfolio -->
                <flux:navlist.item href="{{ route('portfolio.gallery') }}"
                    :current="request()->routeIs('portfolio.*')" wire:navigate>Portfolio</flux:navlist.item>

                <!-- Blog -->
                <flux:navlist.item href="{{ route('blog.index') }}" :current="request()->routeIs('blog.*')"
                    wire:navigate>Blog</flux:navlist.item>

                <!-- Legal Mobile -->
                <div class="px-3 py-2">
                    <div class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider mb-2">
                        Legal</div>
                    <div class="space-y-1">
                        <flux:navlist.item href="{{ route('legal.mentions') }}"
                            :current="request()->routeIs('legal.mentions')" wire:navigate
                            class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                            Mentions Légales
                        </flux:navlist.item>
                        <flux:navlist.item href="{{ route('legal.privacy') }}"
                            :current="request()->routeIs('legal.privacy')" wire:navigate
                            class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                            Politique de Confidentialité
                        </flux:navlist.item>
                        <flux:navlist.item href="{{ route('legal.cgu') }}" :current="request()->routeIs('legal.cgu')"
                            wire:navigate
                            class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                            CGU
                        </flux:navlist.item>
                    </div>
                </div>

               
            

                <!-- Actions utilisateur mobile -->
                @auth
                    <div class="flex items-center justify-between px-3 py-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Notifications</span>
                        <livewire:notification.notification-bell />
                    </div>
                    <flux:navlist.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard.*')"
                        wire:navigate>
                        <span
                            class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium hover:bg-primary/80 transition-colors duration-200">
                            Dashboard
                        </span>
                    </flux:navlist.item>
                @else
                    <flux:navlist.item href="{{ route('login') }}" :current="request()->routeIs('login')" wire:navigate>
                        <span
                            class="block bg-secondary text-gray-900 px-3 py-2 rounded-md text-base font-medium hover:bg-secondary/80 transition-colors duration-200">
                            Connexion
                        </span>
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('register') }}" :current="request()->routeIs('register')"
                        wire:navigate>
                        <span
                            class="block border border-primary text-primary px-3 py-2 rounded-md text-base font-medium hover:bg-primary/10 transition-colors duration-200 mt-2">
                            Inscription
                        </span>
                    </flux:navlist.item>
                @endauth
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
