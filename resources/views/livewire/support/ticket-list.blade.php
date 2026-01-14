<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <flux:heading size="xl">Mes Tickets de Support</flux:heading>
            <flux:subheading>Suivez l'état de vos demandes et communiquez avec notre équipe.</flux:subheading>
        </div>
        <flux:button href="{{ route('support.create') }}" icon="plus" variant="primary" wire:navigate>
            Nouveau Ticket
        </flux:button>
    </div>

    <div class="mb-6 flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-[200px]">
            <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Rechercher un ticket..." />
        </div>
        <div class="w-full sm:w-48">
            <flux:select wire:model.live="status" placeholder="Tous les statuts">
                <flux:select.option value="">Tous les statuts</flux:select.option>
                @foreach(\App\Enums\Support\TicketStatus::cases() as $statusCase)
                    <flux:select.option value="{{ $statusCase->value }}">{{ $statusCase->label() }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/50">
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ticket</th>
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Projet</th>
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Priorité</th>
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Dernière mise à jour</th>
                        <th class="px-6 py-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-zinc-900 dark:text-white">{{ $ticket->title }}</span>
                                    <span class="text-[10px] text-zinc-500 uppercase tracking-tighter">#{{ substr($ticket->id, 0, 8) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $ticket->project?->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <flux:badge :color="$ticket->priority->color()" variant="subtle" size="sm">
                                    {{ $ticket->priority->label() }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4">
                                <flux:badge :color="$ticket->status->color()" size="sm">
                                    {{ $ticket->status->label() }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-zinc-500">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <flux:button href="{{ route('support.chat', $ticket->id) }}" size="xs" variant="ghost" icon="chat-bubble-left-right" wire:navigate>
                                    Voir
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500 text-sm italic">
                                Aucun ticket trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
</div>
