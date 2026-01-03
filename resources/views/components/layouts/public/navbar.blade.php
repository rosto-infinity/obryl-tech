<nav class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <h1 class="text-2xl font-bold text-primary">OBRYL TECH</h1>
                    </a>
                </div>
            </div>
            
            <!-- Navigation Desktop -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <!-- Accueil -->
                    <button wire:click="navigateTo('{{ route('home') }}')" 
                            class="text-gray-700 dark:text-gray-300 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary' : '' }}">
                        Accueil
                    </button>
                    
                    <!-- Projets -->
                    <button wire:click="navigateTo('{{ route('projects.list') }}')" 
                            class="text-gray-700 dark:text-gray-300 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('projects.*') ? 'text-primary border-b-2 border-primary' : '' }}">
                        Projets
                    </button>
                    
                    <!-- Développeurs -->
                    <button wire:click="navigateTo('{{ route('developers.list') }}')" 
                            class="text-gray-700 dark:text-gray-300 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('developers.*') ? 'text-primary border-b-2 border-primary' : '' }}">
                        Développeurs
                    </button>
                    
                    <!-- Portfolio -->
                    <button wire:click="navigateTo('{{ route('portfolio.gallery') }}')" 
                            class="text-gray-700 dark:text-gray-300 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('portfolio.*') ? 'text-primary border-b-2 border-primary' : '' }}">
                        Portfolio
                    </button>
                    
                    <!-- Actions utilisateur -->
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/80 transition-colors duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-secondary text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-secondary/80 transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="border border-primary text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/10 transition-colors duration-200 ml-4">
                            Inscription
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" 
                        class="text-gray-700 dark:text-gray-300 hover:text-primary p-2" 
                        id="mobile-menu-button"
                        onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Accueil -->
            <button wire:click="navigateTo('{{ route('home') }}')" 
                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary bg-gray-50 dark:bg-gray-700' : '' }}">
                Accueil
            </button>
            
            <!-- Projets -->
            <button wire:click="navigateTo('{{ route('projects.list') }}')" 
                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('projects.*') ? 'text-primary bg-gray-50 dark:bg-gray-700' : '' }}">
                Projets
            </button>
            
            <!-- Développeurs -->
            <button wire:click="navigateTo('{{ route('developers.list') }}')" 
                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('developers.*') ? 'text-primary bg-gray-50 dark:bg-gray-700' : '' }}">
                Développeurs
            </button>
            
            <!-- Portfolio -->
            <button wire:click="navigateTo('{{ route('portfolio.gallery') }}')" 
                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('portfolio.*') ? 'text-primary bg-gray-50 dark:bg-gray-700' : '' }}">
                Portfolio
            </button>
            
            <!-- Actions utilisateur mobile -->
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium hover:bg-primary/80 transition-colors duration-200">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="block bg-secondary text-gray-900 px-3 py-2 rounded-md text-base font-medium hover:bg-secondary/80 transition-colors duration-200">
                    Connexion
                </a>
                <a href="{{ route('register') }}" 
                   class="block border border-primary text-primary px-3 py-2 rounded-md text-base font-medium hover:bg-primary/10 transition-colors duration-200 mt-2">
                    Inscription
                </a>
            @endif
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}
</script>
