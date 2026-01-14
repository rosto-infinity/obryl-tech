<div class="space-y-6">
    {{-- Header avec statistiques --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Tableau de bord des commissions</h2>
        
        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                <div class="text-blue-600 dark:text-blue-400 text-sm font-medium">Total</div>
                <div class="text-2xl font-bold text-blue-900 dark:text-blue-200">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-4">
                <div class="text-yellow-600 dark:text-yellow-400 text-sm font-medium">En attente</div>
                <div class="text-2xl font-bold text-yellow-900 dark:text-yellow-200">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                <div class="text-blue-600 dark:text-blue-400 text-sm font-medium">Approuvées</div>
                <div class="text-2xl font-bold text-blue-900 dark:text-blue-200">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                <div class="text-green-600 dark:text-green-400 text-sm font-medium">Payées</div>
                <div class="text-2xl font-bold text-green-900 dark:text-green-200">{{ $stats['paid'] }}</div>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4">
                <div class="text-purple-600 dark:text-purple-400 text-sm font-medium">Montant total</div>
                <div class="text-2xl font-bold text-purple-900 dark:text-purple-200">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Rechercher..."
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="all">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvées</option>
                    <option value="paid">Payées</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                <select wire:model.live="typeFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="all">Tous</option>
                    <option value="project_completion">Complément de projet</option>
                    <option value="milestone">Jalon</option>
                    <option value="referral">Parrainage</option>
                    <option value="bonus">Bonus</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Développeur</label>
                <select wire:model.live="developerId" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="0">Tous</option>
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Liste des commissions --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Commissions</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Projet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Développeur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($commissions as $commission)
                        <tr wire:key="commission-{{ $commission->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $commission->project?->title ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $commission->project?->client?->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $commission->developer?->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $commission->developer?->profile?->specialization ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($commission->amount, 0, ',', ' ') }} FCFA</div>
                                @if($commission->percentage)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $commission->percentage }}%</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($commission->status)
                                    @case('pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300">
                                            En attente
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300">
                                            Approuvée
                                        </span>
                                        @break
                                    @case('paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                            Payée
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $commission->type->label() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $commission->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($commission->status === 'pending')
                                    <button wire:click="approveCommission({{ $commission->id }})" class="text-primary hover:text-primary/80 mr-3">
                                        Approuver
                                    </button>
                                @endif
                                
                                @if($commission->canBePaid())
                                    <button wire:click="markAsPaid({{ $commission->id }})" class="text-primary hover:text-primary/80">
                                        Marquer payée
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Aucune commission trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($commissions->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>

    {{-- Messages d'erreur --}}
    @if($errors->has('payment'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-md p-4">
            <div class="text-red-800 dark:text-red-300">{{ $errors->first('payment') }}</div>
        </div>
    @endif
</div>
