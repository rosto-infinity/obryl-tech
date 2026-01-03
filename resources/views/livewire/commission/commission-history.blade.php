<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Historique des Commissions</h1>
        <p class="text-gray-600 dark:text-gray-300">Consultez l'historique complet de vos commissions</p>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Payées</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['paid'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">En attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Gains</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_amount'], 0, ',', ' ') }}</p>
                </div>
                <div class="bg-primary/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3.953-1.914a4 4 0 00-2.727-.636L4.236 7.732A4 4 0 001 8.418V18a2 2 0 002 2h12a2 2 0 002-2V8.418a4 4 0 00-1.236-.636z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                <select wire:model.live="periodFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all">Toutes</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                    <option value="year">Cette année</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvées</option>
                    <option value="paid">Payées</option>
                    <option value="cancelled">Annulées</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select wire:model.live="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all">Tous</option>
                    <option value="project_completion">Complément de projet</option>
                    <option value="milestone">Jalon</option>
                    <option value="referral">Parrainage</option>
                    <option value="bonus">Bonus</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Description..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                />
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
        
        @forelse($commissions as $commission)
            <div wire:key="commission-{{ $commission->id }}" class="relative flex items-start mb-8">
                <!-- Timeline Dot -->
                <div class="flex-shrink-0 w-8 h-8 bg-white border-2 rounded-full flex items-center justify-center z-10
                    @switch($commission->status)
                        @case('paid')
                            border-green-500 bg-green-500
                        @break
                        @case('approved')
                            border-blue-500 bg-blue-500
                        @break
                        @case('pending')
                            border-yellow-500 bg-yellow-500
                        @break
                        @case('cancelled')
                            border-red-500 bg-red-500
                        @break
                        @default
                            border-gray-500 bg-gray-500
                    @endswitch
                ">
                    @switch($commission->status)
                        @case('paid')
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @break
                        @case('approved')
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @break
                        @case('pending')
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @break
                        @case('cancelled')
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @break
                        @default
                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                    @endswitch
                </div>
                
                <!-- Content Card -->
                <div class="ml-6 flex-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ $commission->type->label() }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $commission->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($commission->status)
                                    @case('paid')
                                        bg-green-100 text-green-800
                                    @break
                                    @case('approved')
                                        bg-blue-100 text-blue-800
                                    @break
                                    @case('pending')
                                        bg-yellow-100 text-yellow-800
                                    @break
                                    @case('cancelled')
                                        bg-red-100 text-red-800
                                    @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch
                            ">
                                {{ $commission->status->label() }}
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            {{ $commission->description }}
                        </p>
                        
                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Montant</p>
                                <p class="text-lg font-semibold text-gray-900">{{ number_format($commission->amount, 0, ',', ' ') }} XAF</p>
                            </div>
                            
                            @if($commission->project)
                                <div>
                                    <p class="text-sm text-gray-500">Projet</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $commission->project->title }}</p>
                                </div>
                            @endif
                            
                            @if($commission->developer)
                                <div>
                                    <p class="text-sm text-gray-500">Développeur</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $commission->developer->name }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                @if($commission->approved_by)
                                    <span>Approuvé par: {{ $commission->approvedBy->name }}</span>
                                @endif
                                
                                @if($commission->paid_at)
                                    <span>• Payé le: {{ $commission->paid_at->format('d/m/Y') }}</span>
                                @endif
                            </div>
                            
                            <div class="flex space-x-2">
                                @if($commission->status === 'pending' && auth()->user()->can('approve', $commission))
                                    <button wire:click="approveCommission({{ $commission->id }})" class="text-primary hover:text-primary/80 text-sm font-medium">
                                        Approuver
                                    </button>
                                @endif
                                
                                @if($commission->status === 'approved' && auth()->user()->can('pay', $commission))
                                    <button wire:click="markAsPaid({{ $commission->id }})" class="text-primary hover:text-primary/80 text-sm font-medium">
                                        Marquer payée
                                    </button>
                                @endif
                                
                                <button class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                    Voir détails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="text-gray-400 text-lg mb-2">Aucune commission trouvée</div>
                <div class="text-gray-500">Essayez d'ajuster vos filtres de recherche</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($commissions->hasPages())
        <div class="mt-8">
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-lg shadow">
                {{ $commissions->links() }}
            </div>
        </div>
    @endif
</div>
