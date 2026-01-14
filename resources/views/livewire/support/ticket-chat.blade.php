<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 h-[calc(100vh-100px)] flex flex-col">
    <div class="flex justify-between items-center mb-6 shrink-0">
        <div class="flex items-center gap-4">
            <flux:button href="{{ route('support.list') }}" icon="arrow-left" size="sm" variant="ghost" wire:navigate />
            <div>
                <flux:heading size="lg">{{ $ticket->title }}</flux:heading>
                <div class="flex items-center gap-2 mt-1">
                    <flux:badge :color="$ticket->status->color()" size="xs">{{ $ticket->status->label() }}</flux:badge>
                    <span class="text-xs text-zinc-500">Ticket #{{ substr($ticket->id, 0, 8) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col min-h-0">
        {{-- Chat Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6" id="chat-window">
            {{-- Ticket Description (Initial Message) --}}
            <div class="flex justify-start">
                <div class="bg-zinc-100 dark:bg-zinc-800 rounded-lg p-4 max-w-[85%] border border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-between items-center mb-2 gap-4">
                        <span class="font-bold text-xs text-zinc-900 dark:text-white">{{ $ticket->user->name }}</span>
                        <span class="text-[10px] text-zinc-500">{{ $ticket->created_at->translatedFormat('d M H:i') }}</span>
                    </div>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $ticket->description }}</p>
                </div>
            </div>

            {{-- Threaded Messages --}}
            @foreach($ticket->messages ?? [] as $msg)
                <div @class(['flex', 'justify-end' => $msg['user_id'] === auth()->id(), 'justify-start' => $msg['user_id'] !== auth()->id()])>
                    <div @class([
                        'rounded-lg p-4 max-w-[85%] border',
                        'bg-primary-50 dark:bg-primary-900/20 border-primary-100 dark:border-primary-800/50' => $msg['user_id'] === auth()->id(),
                        'bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700' => $msg['user_id'] !== auth()->id() && !$msg['is_admin'],
                        'bg-amber-50 dark:bg-amber-900/20 border-amber-100 dark:border-amber-800/50' => $msg['is_admin'],
                    ])>
                        <div class="flex justify-between items-center mb-2 gap-4">
                            <span class="font-bold text-xs @if($msg['is_admin']) text-amber-700 dark:text-amber-400 @else text-zinc-900 dark:text-white @endif">
                                {{ $msg['user_name'] }} @if($msg['is_admin']) <span class="bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300 text-[10px] px-1 rounded ml-1">Support</span> @endif
                            </span>
                            <span class="text-[10px] text-zinc-500">{{ \Carbon\Carbon::parse($msg['created_at'])->translatedFormat('d M H:i') }}</span>
                        </div>
                        <p class="text-sm leading-relaxed whitespace-pre-wrap @if($msg['user_id'] === auth()->id()) text-primary-900 dark:text-primary-100 @else text-zinc-700 dark:text-zinc-300 @endif">
                            {{ $msg['message'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input Area --}}
        <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20 shrink-0">
            @if($ticket->status->value === 'closed')
                <div class="text-center py-2 text-sm text-zinc-500 italic">
                    Ce ticket est fermé. Vous ne pouvez plus envoyer de messages.
                </div>
            @else
                <form wire:submit="sendMessage" class="flex gap-4">
                    <div class="flex-1">
                        <flux:textarea wire:model="message" rows="1" placeholder="Écrivez votre message..." class="resize-none" />
                        <flux:error name="message" />
                    </div>
                    <flux:button type="submit" variant="primary" icon="paper-airplane" class="self-end" />
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.scrollTop = chatWindow.scrollHeight;

        Livewire.on('message-sent', () => {
            setTimeout(() => {
                chatWindow.scrollTo({ top: chatWindow.scrollHeight, behavior: 'smooth' });
            }, 50);
        });
    });
</script>
