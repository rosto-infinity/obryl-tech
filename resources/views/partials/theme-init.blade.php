<script>
    // Script bloquant pour appliquer le thème AVANT le rendu
    (function() {
        // Désactiver les transitions pendant l'application initiale
        document.documentElement.classList.add('no-transitions');
        
        // Lire le thème depuis localStorage (compatible avec Flux)
        const theme = localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system';
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Appliquer le thème
        if (theme === 'dark' || (theme === 'system' && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Réactiver les transitions après un court délai (après le rendu initial)
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                document.documentElement.classList.remove('no-transitions');
            });
        });
    })();
</script>
