<flux:dropdown>
    <flux:button variant="ghost" size="sm" icon="bell" class="relative">
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-zinc-900">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </flux:button>

    <flux:menu class="w-[320px] p-0">
        <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
            <h3 class="font-semibold text-sm">Notifications</h3>
            @if($unreadCount > 0)
                <flux:link href="{{ route('notifications') }}" size="xs">Tout voir</flux:link>
            @endif
        </div>

        <div class="max-h-[400px] overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-zinc-50 dark:border-zinc-800/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ !$notification->read_at ? 'bg-zinc-50/50 dark:bg-zinc-800/30' : '' }}">
                    <div class="flex gap-3">
                        <div class="shrink-0 mt-0.5">
                            <flux:icon name="bell" size="sm" class="text-zinc-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">
                                    {{ $notification->title }}
                                </p>
                                <span class="text-[10px] text-zinc-400">
                                    {{ $notification->created_at->diffForHumans(short: true) }}
                                </span>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2">
                                {{ $notification->message }}
                            </p>
                            @if(!$notification->read_at)
                                <button wire:click="markAsRead('{{ $notification->id }}')" class="mt-2 text-[10px] text-primary-600 hover:text-primary-700 font-medium tracking-tight">
                                    Marquer comme lu
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-zinc-500">
                    <p class="text-sm">Aucune notification</p>
                </div>
            @endforelse
        </div>

        <div class="p-2 bg-zinc-50/50 dark:bg-zinc-800/30 text-center border-t border-zinc-100 dark:border-zinc-800">
            <flux:navlist.item icon="bell" :href="route('notifications')" wire:navigate>
                Centre de notifications
            </flux:navlist.item>
        </div>
    </flux:menu>
</flux:dropdown>
