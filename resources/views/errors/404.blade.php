@extends('components.layouts.public')

@section('content')

<div class="min-h-screen flex items-center justify-center  py-12 px-4">
    <div class="max-w-md w-full">
        <div class="glass rounded-2xl p-8 text-center">
            <div class="mb-6 flex justify-center">
                <div class="relative">
                    <i class="fas fa-search text-6xl text-primary"></i>
                </div>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">
                404
            </h1>
            
            <h2 class="text-2xl font-semibold text-primary mb-4">
                Page Non Trouvée
            </h2>
            
            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed text-lg">
                Oups !, la page que vous recherchez n'a pas pu être trouvée. Peut-être a-t-elle été déplacée ou n'existe-t-elle plus
            </p>
            
            <div class="space-y-3">
                <a href="/" class="inline-flex items-center justify-center w-full px-6 py-3 bg-primary hover:bg-green-600 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
                
                <button onclick="history.back()" class="inline-flex items-center justify-center w-full px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Page précédente
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
