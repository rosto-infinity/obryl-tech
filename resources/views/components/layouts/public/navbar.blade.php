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

                    <!-- Blog -->
                    <flux:navlist.item href="{{ route('blog.index') }}"
                        :current="request()->routeIs('blog.*')" wire:navigate>Blog
                    </flux:navlist.item>

               



                    <!-- Actions utilisateur -->
                    @auth
                        <flux:navlist.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard.*')"
                            wire:navigate>
                            <span
                                class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/80 transition-colors duration-200">Dashboard</span>
                        </flux:navlist.item>
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
                <!-- Appearance Selector -->
                <div x-data="{ open: false, appearance: localStorage.getItem('theme') || 'system' }" class="relative">
                    <!-- Button -->
                    <button @click="open = !open" type="button"
                        class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                        <svg x-show="appearance === 'light' || (appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)"
                            class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.657 5.657l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="appearance === 'dark'" class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="appearance === 'system'" class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20m0 0l-.75 3M9 20H5m4 0h4m7-4v6m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM15 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">

                        <!-- Light Option -->
                        <button @click="
                            appearance = 'light';
                            localStorage.setItem('theme', 'light');
                            document.documentElement.classList.remove('dark');
                            open = false;
                        " :class="appearance === 'light' ? 'bg-primary/10' : ''"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex items-center gap-3">
                            <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.657 5.657l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Light</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Bright and clean</p>
                            </div>
                        </button>

                        <!-- Dark Option -->
                        <button @click="
                            appearance = 'dark';
                            localStorage.setItem('theme', 'dark');
                            document.documentElement.classList.add('dark');
                            open = false;
                        " :class="appearance === 'dark' ? 'bg-primary/10' : ''"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex items-center gap-3">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Dark</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Easy on the eyes</p>
                            </div>
                        </button>

                        <!-- System Option -->
                        <button @click="
                            appearance = 'system';
                            localStorage.setItem('theme', 'system');
                            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                            open = false;
                        " :class="appearance === 'system' ? 'bg-primary/10' : ''"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex items-center gap-3">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20m0 0l-.75 3M9 20H5m4 0h4m7-4v6m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM15 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">System</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Follow OS settings</p>
                            </div>
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
