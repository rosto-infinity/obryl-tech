<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.theme-init')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'obryl tech' }} - génie informatique</title>
        
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @livewireStyles
        @livewireScripts
    </head>
    <body class="bg-background text-foreground transition-colors duration-300 antialiased">
        <!-- Navigation Publique -->
        <x-layouts.public.navbar />
        
        <!-- Contenu Principal -->
        <main class="mx-auto max-w-7xl p-5">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
        
        <!-- Footer -->
        <x-footer />
        
        @stack('scripts')
        @fluxScripts
    </body>
</html>
