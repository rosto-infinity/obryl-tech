@props(['class' => ''])

<button
    x-data="themeToggle()"
    @click="toggleTheme()"
    type="button"
    class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 {{ $class }}"
    :aria-label="isDark ? 'Passer au thème clair' : 'Passer au thème sombre'"
    x-tooltip="isDark ? 'Thème clair' : 'Thème sombre'">
    <!-- Icône Soleil -->
    <svg
        x-show="isDark"
        class="w-5 h-5"
        fill="currentColor"
        viewBox="0 0 20 20">
        <path fill-rule="evenodd"
            d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-2.12-2.12a1 1 0 00-1.414 1.414l2.12 2.12a1 1 0 001.414-1.414zM2.05 2.05a1 1 0 011.414 0l2.12 2.12a1 1 0 00-1.414 1.414L2.05 3.464a1 1 0 010-1.414zM17.95 17.95a1 1 0 011.414-1.414l2.12 2.12a1 1 0 01-1.414 1.414l-2.12-2.12z"
            clip-rule="evenodd" />
    </svg>

    <!-- Icône Lune -->
    <svg
        x-show="!isDark"
        class="w-5 h-5"
        fill="currentColor"
        viewBox="0 0 20 20">
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
    </svg>
</button>

<script>
function themeToggle() {
    return {
        isDark: localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

        init() {
            // Initialiser le thème au chargement
            this.applyTheme();

            // Écouter les changements de préférence système
            window.matchMedia('(prefers-color-scheme: dark)').addListener((e) => {
                if (!localStorage.getItem('theme')) {
                    this.isDark = e.matches;
                    this.applyTheme();
                }
            });
        },

        toggleTheme() {
            this.isDark = !this.isDark;
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            this.applyTheme();
        },

        applyTheme() {
            const html = document.documentElement;
            if (this.isDark) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            // Émettre un événement personnalisé pour d'autres composants
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: this.isDark } }));
        }
    }
}
</script>
