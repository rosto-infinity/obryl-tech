<x-filament-panels::page>
    <div class="filament-layout">
        @livewire('filament.core.notifications')
        
        <main>
            {{ $slot }}
        </main>
    </div>
</x-filament-panels::page>