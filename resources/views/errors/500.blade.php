@extends('components.layouts.public')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-mesh-gradient py-12 px-4">
    <div class="max-w-md w-full">
        <div class="glass rounded-2xl p-8 text-center">
            <div class="mb-6 flex justify-center">
                <div class="relative">
                    <i class="fas fa-exclamation-triangle text-6xl text-secondary"></i>
                </div>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">
                500
            </h1>
            
            <h2 class="text-2xl font-semibold text-secondary mb-4">
                Erreur Serveur
            </h2>
            
            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed text-lg">
                Une erreur interne est survenue. Nos équipes sont informées et travaillent à résoudre le problème.
            </p>
            
            <div class="space-y-3">
                <a href="/" class="inline-flex items-center justify-center w-full px-6 py-3 bg-secondary hover:bg-secondary-light text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
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
