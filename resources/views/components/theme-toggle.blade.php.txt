@props(['class' => ''])

<button
    x-data="themeToggle()"
    @click="toggleTheme()"
    type="button"
    class="relative inline-flex items-center justify-center w-12 h-12 rounded-md bg-muted/50 text-foreground border-2 border-border/50 hover:border-primary/50 transition-all duration-300 {{ $class }} group overflow-hidden"
    :aria-label="isDark ? 'Mode Lumineux' : 'Mode Sombre'">
    
    <!-- Sun Icon -->
    <div x-show="isDark" x-transition.duration.500ms class="flex items-center justify-center">
        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.657 5.657l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </div>

    <!-- Moon Icon -->
    <div x-show="!isDark" x-transition.duration.500ms class="flex items-center justify-center">
        <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </div>
</button>

<script>
function themeToggle() {
    return {
        isDark: document.documentElement.classList.contains('dark'),

        init() {
            this.isDark = document.documentElement.classList.contains('dark');
        },

        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: this.isDark } }));
        }
    }
}
</script>
