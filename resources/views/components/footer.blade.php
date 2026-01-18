<footer class="bg-foreground text-background py-16 mt-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-mesh-gradient opacity-10"></div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-16">
            
            <!-- Logo et À propos -->
            <div class="space-y-6 md:col-span-1">
                <a href="{{ route('home') }}" wire:navigate class="inline-block transition-transform hover:scale-105">                
                    <img src="/Obryl.com.png" alt="Obryl Tech" class="h-8 ">
                </a>
                <p class="text-background/60 text-sm font-medium leading-relaxed">
                    Ingénierie d'élite & solutions numériques sur mesure. Nous transformons vos visions complexes en réalités technologiques performantes.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-background/40 hover:text-primary transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-background/40 hover:text-primary transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-primary tracking-wider">Expertises</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('projects.list') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Développement</a></li>
                    <li><a href="#" class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Design système</a></li>
                    <li><a href="#" class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Infrastructures</a></li>
                    <li><a href="{{ route('developers.list') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Talents</a></li>
                </ul>
            </div>

            <!-- Navigation -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-primary tracking-wider">Navigation</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Accueil</a></li>
                    <li><a href="{{ route('projects.list') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Portfolio</a></li>
                    <li><a href="{{ route('blog.index') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Blog</a></li>
                    <li><a href="{{ route('portfolio.gallery') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Galerie</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-primary tracking-wider">Protocoles</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('legal.mentions') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Mentions légales</a></li>
                    <li><a href="{{ route('legal.privacy') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Confidentialité</a></li>
                    <li><a href="{{ route('legal.cgu') }}" wire:navigate class="text-sm font-medium text-background/60 hover:text-primary transition-colors">Conditions</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-20 pt-8 border-t border-background/10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-background/40 text-[10px] font-bold">
                    © {{ date('Y') }} Obryl Tech. Élite en génie informatique.
                </p>
                <div class="flex items-center gap-8">
                    <p class="text-background/40 text-[10px] font-bold flex items-center">
                        fait avec <span class="text-primary mx-1.5">♥</span> au Cameroun
                    </p>
                    <a href="{{ route('legal.mentions') }}" wire:navigate class="text-[10px] font-bold text-background/40 hover:text-primary transition-colors">
                        Protocole légal
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
