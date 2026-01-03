@extends('components.layouts.public')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary to-secondary text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Transformez vos Idées en Réalité
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-primary-light/90 max-w-3xl mx-auto">
                Connectez-vous avec les meilleurs développeurs pour réaliser vos projets digitaux innovants
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('projects.list') }}" 
                   class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                    Explorer les Projets
                </a>
                <a href="{{ route('developers.list') }}" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors duration-200">
                    Trouver un Développeur
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-3xl font-bold text-primary mb-2">150+</div>
                <div class="text-gray-600">Projets Réalisés</div>
            </div>
            <div class="p-6">
                <div class="text-3xl font-bold text-primary mb-2">50+</div>
                <div class="text-gray-600">Développeurs Experts</div>
            </div>
            <div class="p-6">
                <div class="text-3xl font-bold text-primary mb-2">100%</div>
                <div class="text-gray-600">Satisfaction Client</div>
            </div>
            <div class="p-6">
                <div class="text-3xl font-bold text-primary mb-2">24/7</div>
                <div class="text-gray-600">Support Technique</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Nos Services
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Une gamme complète de services pour répondre à tous vos besoins de développement
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Développement Web</h3>
                <p class="text-gray-600 mb-4">
                    Sites web modernes, applications web complexes et solutions e-commerce sur mesure.
                </p>
                <a href="{{ route('projects.list') }}" class="text-primary font-medium hover:text-primary/80">
                    En savoir plus →
                </a>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Applications Mobiles</h3>
                <p class="text-gray-600 mb-4">
                    Applications iOS et Android natives ou cross-platform pour une expérience mobile optimale.
                </p>
                <a href="{{ route('projects.list') }}" class="text-primary font-medium hover:text-primary/80">
                    En savoir plus →
                </a>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Consulting Technique</h3>
                <p class="text-gray-600 mb-4">
                    Expertise technique pour vous accompagner dans vos projets digitaux et optimiser votre infrastructure.
                </p>
                <a href="{{ route('developers.list') }}" class="text-primary font-medium hover:text-primary/80">
                    En savoir plus →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary to-secondary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Prêt à Démarrer Votre Projet ?
        </h2>
        <p class="text-xl mb-8 text-primary-light/90 max-w-2xl mx-auto">
            Rejoignez notre communauté de développeurs talentueux et donnez vie à vos idées
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                    Accéder au Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                    S'inscrire Gratuitement
                </a>
                <a href="{{ route('login') }}" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors duration-200">
                    Se Connecter
                </a>
            @endif
        </div>
    </div>
</section>
@endsection
