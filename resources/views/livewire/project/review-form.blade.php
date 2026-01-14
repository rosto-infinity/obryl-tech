<div>
    @if($reviewSubmitted)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="h-12 w-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center mb-3">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-green-900 dark:text-green-100">Merci pour votre avis !</h3>
                <p class="mt-1 text-sm text-green-600 dark:text-green-400">Il sera publié dès qu'il aura été validé par notre équipe.</p>
            </div>
        </div>
    @elseif($canReview)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-100 dark:border-gray-700 mb-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Laisser un avis sur ce projet</h3>
            
            <form wire:submit="submit">
                {{-- Note Globale --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note globale</label>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 24 24">
                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-1.838-.197-1.538 1.118l1.518-4.674a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                </div>

                {{-- Critères --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach($criteria as $key => $value)
                        <div>
                            <div class="flex justify-between mb-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $key }}</label>
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-bold">{{ $value }}/5</span>
                            </div>
                            <input type="range" min="1" max="5" step="1" 
                                   wire:model.live="criteria.{{ $key }}"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-primary">
                        </div>
                    @endforeach
                </div>

                {{-- Commentaire --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Votre commentaire</label>
                    <textarea wire:model="comment" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                              placeholder="Partagez votre expérience sur ce projet..."></textarea>
                    @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary/90 transition-colors duration-200 font-medium shadow-lg shadow-primary/30">
                        Soumettre mon avis
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
