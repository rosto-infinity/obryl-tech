@extends('components.layouts.public')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-mesh-gradient py-12 px-4">
    <div class="max-w-md w-full">
        <div class="glass rounded-2xl p-8 text-center">
            <div class="mb-6 flex justify-center">
                <div class="relative">
                    <i class="fas fa-lock text-6xl text-primary"></i>
                </div>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">
                403
            </h1>
            
            <h2 class="text-2xl font-semibold text-primary mb-4">
                Accès Refusé
            </h2>
            
            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed text-lg">
                Désolé, vous n'avez pas l'autorisation d'accéder à cette ressource.
            </p>
            
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-8">
                Cette zone est réservée aux administrateurs autorisés.
            </p>
            
            <div class="space-y-3">
                <a href="/" class="inline-flex items-center justify-center w-full px-6 py-3 bg-primary hover:bg-primary-light text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
                
                <a href="mailto:contact@obryl.com" class="inline-flex items-center justify-center w-full px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-envelope mr-2"></i>
                    Contacter l'administrateur
                </a>
                
                <button onclick="history.back()" class="inline-flex items-center justify-center w-full px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Page précédente
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
