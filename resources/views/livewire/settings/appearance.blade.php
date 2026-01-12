<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Customize how Obryl Tech looks to you')">
        <div class="space-y-6">
            <!-- Theme Selection -->
            <div class="space-y-3">
                <flux:label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    {{ __('Theme') }}
                </flux:label>
                
                <flux:radio.group 
                    x-data 
                    variant="segmented" 
                    x-model="$flux.appearance"
                    @change="localStorage.setItem('theme', $el.value)"
                    class="w-full"
                >
                    <!-- Light Theme -->
                    <flux:radio 
                        value="light" 
                        icon="sun"
                        class="flex-1 text-center"
                    >
                        <span class="font-medium">{{ __('Light') }}</span>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('Bright and clean') }}</p>
                    </flux:radio>

                    <!-- Dark Theme -->
                    <flux:radio 
                        value="dark" 
                        icon="moon"
                        class="flex-1 text-center"
                    >
                        <span class="font-medium">{{ __('Dark') }}</span>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('Easy on the eyes') }}</p>
                    </flux:radio>

                    <!-- System Theme -->
                    <flux:radio 
                        value="system" 
                        icon="computer-desktop"
                        class="flex-1 text-center"
                    >
                        <span class="font-medium">{{ __('System') }}</span>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('Follow OS settings') }}</p>
                    </flux:radio>
                </flux:radio.group>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    {{ __('Your preference is saved automatically.') }}
                </p>
            </div>

            <!-- Preview Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <flux:label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                    {{ __('Preview') }}
                </flux:label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Light Preview -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                        <div class="aspect-square bg-gradient-to-br from-slate-50 via-white to-slate-50 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 text-center">{{ __('Light Theme') }}</p>
                    </div>

                    <!-- Dark Preview -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-900 dark:bg-gray-900">
                        <div class="aspect-square bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 text-center">{{ __('Dark Theme') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-settings.layout>
</section>
