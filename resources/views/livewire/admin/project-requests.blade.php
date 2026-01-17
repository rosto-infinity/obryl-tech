{{-- <x-layouts.app :title="__('Demandes de projets ')"> --}}

      <div class="max-w-7xl mx-auto px-4 py-8">
          <!-- Header -->
          <div class="mb-8">
              <h1 class="text-3xl font-bold text-gray-900 mb-2">
                  📋 Demandes de projets
              </h1>
              <p class="text-gray-600">
                  Gérez les demandes de projets soumises par les clients
              </p>
          </div>

          <!-- Statistiques -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
              <div class="bg-white rounded-lg shadow p-6">
                  <div class="flex items-center">
                      <div class="p-3 bg-blue-100 rounded-lg">
                          <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                          </svg>
                      </div>
                      <div class="ml-4">
                          <p class="text-sm font-medium text-gray-600">Total</p>
                          <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                      </div>
                  </div>
              </div>

              <div class="bg-white rounded-lg shadow p-6">
                  <div class="flex items-center">
                      <div class="p-3 bg-green-100 rounded-lg">
                          <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                      </div>
                      <div class="ml-4">
                          <p class="text-sm font-medium text-gray-600">Aujourd'hui</p>
                          <p class="text-2xl font-semibold text-gray-900">{{ $stats['today'] }}</p>
                      </div>
                  </div>
              </div>

              <div class="bg-white rounded-lg shadow p-6">
                  <div class="flex items-center">
                      <div class="p-3 bg-yellow-100 rounded-lg">
                          <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                      </div>
                      <div class="ml-4">
                          <p class="text-sm font-medium text-gray-600">Cette semaine</p>
                          <p class="text-2xl font-semibold text-gray-900">{{ $stats['this_week'] }}</p>
                      </div>
                  </div>
              </div>

              <div class="bg-white rounded-lg shadow p-6">
                  <div class="flex items-center">
                      <div class="p-3 bg-purple-100 rounded-lg">
                          <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 00-.586 5.656l7 7a4 4 0 005.656 0l4-4a4 4 0 00.586-5.656l-7-7z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16.5l.172.172a4 4 0 010 5.656l4 4a4 4 0 005.656 0l4-4a4 4 0 00.586-5.656l-7-7z" />
                          </svg>
                      </div>
                      <div class="ml-4">
                          <p class="text-sm font-medium text-gray-600">Avec références</p>
                          <p class="text-2xl font-semibold text-gray-900">{{ $stats['with_references'] }}</p>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Filtres -->
          <div class="bg-white rounded-lg shadow p-6 mb-6">
              <div class="flex flex-wrap gap-4 items-center">
                  <div class="flex-1 min-w-64">
                      <input type="text" 
                            wire:model.live="search" 
                            placeholder="Rechercher par titre, description ou code..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                  </div>
                  
                  <select wire:model.live="typeFilter" 
                          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                      <option value="all">Tous les types</option>
                      <option value="web">🌐 Web</option>
                      <option value="mobile">📱 Mobile</option>
                      <option value="desktop">💻 Desktop</option>
                      <option value="api">⚙️ API</option>
                      <option value="consulting">💼 Consulting</option>
                  </select>

                  <select wire:model.live="perPage" 
                          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                      <option value="10">10 par page</option>
                      <option value="25">25 par page</option>
                      <option value="50">50 par page</option>
                  </select>
              </div>
          </div>

          <!-- Tableau des demandes -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                  wire:click="sortBy('created_at')">
                                  Date
                                  @if($sortBy === 'created_at')
                                      <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                  @endif
                              </th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                  wire:click="sortBy('title')">
                                  Projet
                                  @if($sortBy === 'title')
                                      <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                  @endif
                              </th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  Client
                              </th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                  wire:click="sortBy('budget')">
                                  Budget
                                  @if($sortBy === 'budget')
                                      <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                  @endif
                              </th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  Références
                              </th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  Actions
                              </th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @forelse($projects as $project)
                              <tr class="hover:bg-gray-50">
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                      {{ $project->created_at->format('d/m/Y') }}
                                  </td>
                                  <td class="px-6 py-4">
                                      <div>
                                          <div class="text-sm font-medium text-gray-900">{{ $project->title }}</div>
                                          <div class="text-sm text-gray-500">{{ $project->code }}</div>
                                          <div class="mt-1">
                                              <span class="inline-flex px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                  {{ $project->type->label() }}
                                              </span>
                                          </div>
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-900">{{ $project->client->name }}</div>
                                      <div class="text-sm text-gray-500">{{ $project->client->email }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                      {{ number_format($project->budget, 0, ',', ' ') }} {{ $project->currency }}
                                  </td>
                                  <td class="px-6 py-4">
                                      @if($project->references->count() > 0)
                                          <div class="text-sm">
                                              <span class="inline-flex px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                  {{ $project->references->count() }} référence(s)
                                              </span>
                                              <div class="mt-1 text-xs text-gray-500">
                                                  @foreach($project->references->take(2) as $ref)
                                                      <div>• {{ $ref->platform_name }}</div>
                                                  @endforeach
                                                  @if($project->references->count() > 2)
                                                      <div>• +{{ $project->references->count() - 2 }} autre(s)</div>
                                                  @endif
                                              </div>
                                          </div>
                                      @else
                                          <span class="text-sm text-gray-400">Aucune</span>
                                      @endif
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                      <div class="flex space-x-2">
                                          <button wire:click="acceptProject({{ $project->id }})" 
                                                  class="text-green-600 hover:text-green-900 font-medium">
                                              ✅ Accepter
                                          </button>
                                          <button wire:click="rejectProject({{ $project->id }})" 
                                                  class="text-red-600 hover:text-red-900 font-medium">
                                              ❌ Rejeter
                                          </button>
                                          <a href="{{ route('projects.detail', $project->slug) }}" 
                                        wire:navigate
                                            class="text-blue-600 hover:text-blue-900 font-medium">
                                              👁️ Voir
                                          </a>
                                      </div>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                      <div class="flex flex-col items-center">
                                          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                          </svg>
                                          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune demande de projet</h3>
                                          <p class="mt-1 text-sm text-gray-500">
                                              Les nouvelles demandes apparaîtront ici.
                                          </p>
                                      </div>
                                  </td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>

          <!-- Pagination -->
          @if($projects->hasPages())
              <div class="mt-6">
                  {{ $projects->links() }}
              </div>
          @endif
      </div>
{{-- </x-layouts.app> --}}
