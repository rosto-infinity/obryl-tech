@if ($count > 0)
    <div class="relative">
        <flux:navlist.item icon="document-text" :href="route('project.requests')"
            :current="request()->routeIs('project.requests')" wire:navigate>
            {{ __('Gestion des demandes') }}
            @if ($count > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $count > 99 ? '99+' : $count }}
                </span>
            @endif
        </flux:navlist.item>
    </div>
@else
    <flux:navlist.item icon="document-text" :href="route('project.requests')"
        :current="request()->routeIs('project.requests')" wire:navigate>
        {{ __('Gestion des demandes') }}
    </flux:navlist.item>
@endif
