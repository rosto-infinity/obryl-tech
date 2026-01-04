<nav
    class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
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
                    
                   

                    <!-- Actions utilisateur -->
                    @auth
                        <flux:navlist.item href="{{ route('dashboard') }}"
                            :current="request()->routeIs('dashboard.*')" wire:navigate>
                            <span class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/80 transition-colors duration-200">Dashboard</span>
                        </flux:navlist.item>
                    @else
                        <flux:navlist.item href="{{ route('login') }}"
                            :current="request()->routeIs('login')" wire:navigate>
                            <span class="bg-secondary text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-secondary/80 transition-colors duration-200">Connexion</span>
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('register') }}"
                            :current="request()->routeIs('register')" wire:navigate>
                            <span class="border border-primary text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/10 transition-colors duration-200">Inscription</span>
                        </flux:navlist.item>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-700 dark:text-gray-300 hover:text-primary p-2"
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
                <flux:navlist.item href="{{ route('portfolio.gallery') }}" :current="request()->routeIs('portfolio.*')"
                    wire:navigate>Portfolio</flux:navlist.item>
                
                <!-- Dark Mode Toggle Mobile -->
                <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" class="px-3 py-2">
                    <div class="flex rounded-lg bg-zinc-800/5 dark:bg-white/10 p-1 w-full">
                        <button @click="theme = 'light'; localStorage.setItem('theme', 'light'); updateTheme()" 
                                :class="theme === 'light' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                                class="p-2 rounded-md transition-colors duration-200 flex-1">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                        <button @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); updateTheme()" 
                                :class="theme === 'dark' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                                class="p-2 rounded-md transition-colors duration-200 flex-1">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        <button @click="theme = 'system'; localStorage.setItem('theme', 'system'); updateTheme()" 
                                :class="theme === 'system' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                                class="p-2 rounded-md transition-colors duration-200 flex-1">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Actions utilisateur mobile -->
                @auth
                    <flux:navlist.item href="{{ route('dashboard') }}"
                        :current="request()->routeIs('dashboard.*')" wire:navigate>
                        <span class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium hover:bg-primary/80 transition-colors duration-200">
                            Dashboard
                        </span>
                    </flux:navlist.item>
                @else
                    <flux:navlist.item href="{{ route('login') }}"
                        :current="request()->routeIs('login')" wire:navigate>
                        <span class="block bg-secondary text-gray-900 px-3 py-2 rounded-md text-base font-medium hover:bg-secondary/80 transition-colors duration-200">
                            Connexion
                        </span>
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('register') }}"
                        :current="request()->routeIs('register')" wire:navigate>
                        <span class="block border border-primary text-primary px-3 py-2 rounded-md text-base font-medium hover:bg-primary/10 transition-colors duration-200 mt-2">
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
