<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Tableau de Bord - Gestion de Charge
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Suivi en temps réel de la charge de travail des développeurs
                </p>
            </div>
            <div class="flex space-x-3">
                <button 
                    wire:click="handleOverload"
                    wire:loading.attr="disabled"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <span class="w-4 h-4 mr-2">🔄</span>
                    Gérer la Surcharge
                </button>
                <button wire:click="$refresh" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                    <span class="w-4 h-4 mr-2">🔄</span>
                    Actualiser
                </button>
            </div>
        </div>
    </div>

    {{-- Statistiques principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <span class="w-6 h-6 flex items-center justify-center text-blue-600 font-bold text-sm">📄</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Projets</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProjects ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <span class="w-6 h-6 flex items-center justify-center text-green-600 font-bold text-sm">✓</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Développeurs Disponibles</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeDevelopers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <span class="w-6 h-6 flex items-center justify-center text-red-600 font-bold text-sm">⚠</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Développeurs Surchargés</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $overloadedDevelopers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <span class="w-6 h-6 flex items-center justify-center text-yellow-600 font-bold text-sm">⏰</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Assignations en Attente</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingAssignments ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <span class="w-6 h-6 flex items-center justify-center text-purple-600 font-bold text-sm">💰</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Commissions Mensuelles</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($monthlyCommissions ?? 0, 0, ',', ' ') }} XAF</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Statistiques de charge --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Statistiques de Charge
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Développeurs</span>
                    <span class="font-bold">{{ $workloadStats['total_developers'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Disponibles</span>
                    <span class="font-bold text-green-600">{{ $workloadStats['available'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Occupés</span>
                    <span class="font-bold text-yellow-600">{{ $workloadStats['busy'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Surchargés</span>
                    <span class="font-bold text-red-600">{{ $workloadStats['overloaded'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Charge Moyenne</span>
                    <span class="font-bold">{{ number_format($workloadStats['avg_workload'] ?? 0, 1) }}%</span>
                </div>
            </div>
        </div>

        {{-- Réassignations récentes --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Réassignations Récentes
            </h3>
            <p class="text-gray-500 text-sm">Aucune réassignation récente</p>
        </div>
    </div>

    {{-- Notifications --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="h-5 w-5 text-red-400">⚠</span>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erreur</h3>
                    <div class="mt-2 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('notification'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="h-5 w-5 text-green-400">✓</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('notification.message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
