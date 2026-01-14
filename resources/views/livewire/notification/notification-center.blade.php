<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <flux:heading size="xl">Centre de Notifications</flux:heading>
            <flux:subheading>Gérez vos alertes et mises à jour système.</flux:subheading>
        </div>
        @if($notifications->whereNull('read_at')->count() > 0)
            <flux:button wire:click="markAllAsRead" size="sm" variant="outline" icon="check-badge">
                Tout marquer comme lu
            </flux:button>
        @endif
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        @forelse($notifications as $notification)
            <div wire:key="{{ $notification->id }}" class="group p-4 sm:p-6 border-b border-zinc-100 dark:border-zinc-800 last:border-0 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ !$notification->read_at ? 'bg-zinc-50/30 dark:bg-zinc-800/20' : '' }}">
                <div class="flex gap-4 sm:gap-6">
                    <div class="shrink-0 mt-1">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 group-hover:bg-primary-50 group-hover:text-primary-600 dark:group-hover:bg-primary-900/30 dark:group-hover:text-primary-400 transition-colors">
                            <flux:icon name="bell" size="md" />
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <h4 class="text-sm sm:text-base font-semibold text-zinc-900 dark:text-white mb-0.5">
                                    {{ $notification->title }}
                                </h4>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-zinc-500">
                                        {{ $notification->created_at->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if(!$notification->read_at)
                                    <flux:button wire:click="markAsRead('{{ $notification->id }}')" size="xs" variant="ghost" icon="check" tooltip="Marquer comme lu" />
                                @endif
                                <flux:button wire:click="deleteNotification('{{ $notification->id }}')" size="xs" variant="ghost" icon="trash" class="text-red-500 hover:text-red-600" tooltip="Supprimer" />
                            </div>
                        </div>
                        
                        <div class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            {{ $notification->message }}
                        </div>
                    </div>
                    
                    @if(!$notification->read_at)
                        <div class="shrink-0 pt-2 text-primary-500">
                            <div class="h-2 w-2 rounded-full bg-current shadow-[0_0_8px_currentColor]"></div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-20 text-center text-zinc-500">
                <p class="text-lg">Vous n'avez pas de notifications</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
