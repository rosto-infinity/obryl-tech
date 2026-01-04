<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OBRYL TECH - Plateforme de Développement</title>
        
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Navigation -->
        {{-- resources/views/components/layouts/public/navbar.blade.php --}}
        <!-- Navigation -->
        @include('components.layouts.public.navbar')
        
       
        
        <!-- Hero Section -->
        <main class="flex-1">
            <section class="relative bg-gradient-to-br from-primary/10 to-secondary/10 dark:from-gray-900 dark:to-gray-800 py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            Plateforme de Développement
                            <span class="text-primary">OBRYL TECH</span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            Connectez les meilleurs développeurs avec les projets les plus innovants
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ route('dashboard') }}" class="bg-primary text-white px-8 py-3 rounded-lg text-base font-semibold hover:bg-primary/80 transition-colors duration-200 shadow-lg">
                                    Accéder au Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-secondary text-gray-900 px-8 py-3 rounded-lg text-base font-semibold hover:bg-secondary/80 transition-colors duration-200 shadow-lg">
                                    Commencer Maintenant
                                </a>
                                <a href="{{ route('projects.list') }}" class="border border-primary text-primary px-8 py-3 rounded-lg text-base font-semibold hover:bg-primary/10 transition-colors duration-200 shadow-lg">
                                    Voir les Projets
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Features Section -->
            <section class="py-20 bg-white dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            Pourquoi Choisir OBRYL TECH ?
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                            La plateforme complète pour tous vos besoins de développement
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- Projets -->
                        <div class="text-center">
                            <div class="flex-shrink-0 mx-auto w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.293 1.414 1.414A1 1 0 0117.586 3H7a2 2 0 01-2-2V5z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Projets</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Déposez et gérez vos projets
                            </p>
                        </div>
                        
                        <!-- Développeurs -->
                        <div class="text-center">
                            <div class="flex-shrink-0 mx-auto w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 100 5.646 5.646L17 14l-1.646-1.646A4 4 0 0012 4.354z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18m-9-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Développeurs</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Trouvez les meilleurs talents
                            </p>
                        </div>
                        
                        <!-- Commissions -->
                        <div class="text-center">
                            <div class="flex-shrink-0 mx-auto w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3.953-1.914a4 4 0 00-2.727-.636L4.236 7.732A4 4 0 001 8.418V18a2 2 0 002 2h12a2 2 0 002-2V8.418a4 4 0 00-1.236-.636z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v2h-18V3z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Commissions</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Gérez les paiements simplement
                            </p>
                        </div>
                        
                        <!-- Portfolio -->
                        <div class="text-center">
                            <div class="flex-shrink-0 mx-auto w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 013.657-3.657 3.657h3.414a2 2 0 011.414 1.414L16 16l-4.586 4.586a2 2 0 01-3.657-3.657 3.657H6.414A2 2 0 015 14.586 12L4 16z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Portfolio</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Showcase des réalisations
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- CTA Section -->
            <section class="bg-primary py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Prêt à Commencer ?
                    </h2>
                    <p class="text-xl text-primary/90 mb-8 max-w-3xl mx-auto">
                        Rejoignez des centaines de développeurs et clients déjà actifs
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @guest
                            <a href="{{ route('register') }}" class="bg-white text-primary px-8 py-3 rounded-lg text-base font-semibold hover:bg-gray-50 transition-colors duration-200 shadow-lg">
                                Créer un Compte
                            </a>
                        @endguest
                        <a href="{{ route('projects.list') }}" class="border border-white text-white px-8 py-3 rounded-lg text-base font-semibold hover:bg-white/10 transition-colors duration-200 shadow-lg">
                            Explorer les Projets
                        </a>
                    </div>
                </div>
            </section>
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Plateforme</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('projects.list') }}" class="text-gray-300 hover:text-primary transition-colors duration-200">Projets</a></li>
                            <li><a href="{{ route('developers.list') }}" class="text-gray-300 hover:text-primary transition-colors duration-200">Développeurs</a></li>
                            <li><a href="{{ route('commissions.dashboard') }}" class="text-gray-300 hover:text-primary transition-colors duration-200">Commissions</a></li>
                            <li><a href="{{ route('portfolio.gallery') }}" class="text-gray-300 hover:text-primary transition-colors duration-200">Portfolio</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Support</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">Aide</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">Documentation</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Légal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">Mentions légales</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">Confidentialité</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-200">CGU</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                        <p class="text-gray-300 mb-4">Restez informé des dernières nouveautés</p>
                        <form class="flex">
                            <input type="email" placeholder="Votre email" class="bg-gray-800 border border-gray-700 text-white px-4 py-2 rounded-l-lg flex-1 focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-l-lg hover:bg-primary/80 transition-colors duration-200">
                                S'inscrire
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-800 pt-8 text-center">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} OBRYL TECH. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>
        
        <!-- JavaScript -->
        <script>
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Dark mode functionality
            function updateTheme() {
                const theme = localStorage.getItem('theme') || 'system';
                const html = document.documentElement;
                
                if (theme === 'dark') {
                    html.classList.add('dark');
                } else if (theme === 'light') {
                    html.classList.remove('dark');
                } else {
                    // System preference
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }
                }
            }
            
            // Initialize theme on page load
            updateTheme();
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateTheme);
        </script>
        
        @fluxScripts
    </body>
</html>
