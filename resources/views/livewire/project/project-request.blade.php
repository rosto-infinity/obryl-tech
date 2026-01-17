<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            📝 Publier votre projet
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Décrivez votre projet et notre équipe vous proposera une solution adaptée à vos besoins.
        </p>
    </div>

    <!-- Messages -->
    @if($successMessage)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ $successMessage }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errorMessage)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ $errorMessage }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="{{ $step >= 1 ? 'bg-green-500' : 'bg-gray-300' }} rounded-full h-8 w-8 flex items-center justify-center text-white text-sm font-medium">
                    1
                </div>
                <div class="ml-2">
                    <p class="text-sm font-medium {{ $step >= 1 ? 'text-green-600' : 'text-gray-500' }}">Informations</p>
                </div>
            </div>
            <div class="flex-1 h-1 bg-gray-200 mx-4">
                <div class="{{ $step >= 2 ? 'bg-green-500' : 'bg-gray-300' }} h-1" style="width: {{ $step >= 2 ? '100' : '0' }}%"></div>
            </div>
            <div class="flex items-center">
                <div class="{{ $step >= 2 ? 'bg-green-500' : 'bg-gray-300' }} rounded-full h-8 w-8 flex items-center justify-center text-white text-sm font-medium">
                    2
                </div>
                <div class="ml-2">
                    <p class="text-sm font-medium {{ $step >= 2 ? 'text-green-600' : 'text-gray-500' }}">Technologies</p>
                </div>
            </div>
            <div class="flex-1 h-1 bg-gray-200 mx-4">
                <div class="{{ $step >= 3 ? 'bg-green-500' : 'bg-gray-300' }} h-1" style="width: {{ $step >= 3 ? '100' : '0' }}%"></div>
            </div>
            <div class="flex items-center">
                <div class="{{ $step >= 3 ? 'bg-green-500' : 'bg-gray-300' }} rounded-full h-8 w-8 flex items-center justify-center text-white text-sm font-medium">
                    3
                </div>
                <div class="ml-2">
                    <p class="text-sm font-medium {{ $step >= 3 ? 'text-green-600' : 'text-gray-500' }}">Références</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <form wire:submit="submitProject">
        <!-- Étape 1: Informations de base -->
        @if($step === 1)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">📋 Informations du projet</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Titre du projet *
                        </label>
                        <input type="text" wire:model="title" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ex: Plateforme e-commerce moderne">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description détaillée *
                        </label>
                        <textarea wire:model="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                  placeholder="Décrivez votre projet en détail..."></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Type de projet *
                        </label>
                        <select wire:model="type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="web">🌐 Application Web</option>
                            <option value="mobile">📱 Application Mobile</option>
                            <option value="desktop">💻 Application Desktop</option>
                            <option value="api">⚙️ API/Backend</option>
                            <option value="consulting">💼 Consulting</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Budget estimé (FCFA) *
                        </label>
                        <input type="number" wire:model="budget" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="100000">
                        @error('budget')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date limite souhaitée *
                        </label>
                        <input type="date" wire:model="deadline" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('deadline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité
                        </label>
                        <select wire:model="priority" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="low">🟢 Basse</option>
                            <option value="medium">🟡 Moyenne</option>
                            <option value="high">🔴 Haute</option>
                            <option value="critical">🚨 Critique</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" wire:click="nextStep" 
                            class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition-colors">
                        Suivant →
                    </button>
                </div>
            </div>
        @endif

        <!-- Étape 2: Technologies et priorité -->
        @if($step === 2)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">🛠️ Technologies et spécifications</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Technologies souhaitées *
                    </label>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($technologies as $key => $tech)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                {{ $tech }}
                                <button type="button" wire:click="removeTechnology({{ $key }})" 
                                        class="ml-2 text-green-600 hover:text-green-800">×</button>
                            </span>
                        @endforeach
                    </div>
                    <div class="flex gap-2">
                        <input type="text" 
                               wire:model.live="newTechnology" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ajouter une technologie...">
                        <button type="button" wire:click="addTechnology($newTechnology)" 
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            + Ajouter
                        </button>
                    </div>
                    @error('technologies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-3">Suggestions populaires :</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Laravel', 'Vue.js', 'React', 'Node.js', 'Python', 'Docker', 'MySQL', 'MongoDB'] as $tech)
                            @if(!in_array($tech, $technologies))
                                <button type="button" wire:click="addTechnology('{{ $tech }}')" 
                                        class="px-3 py-1 text-sm border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                                    {{ $tech }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" wire:click="previousStep" 
                            class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        ← Précédent
                    </button>
                    <button type="button" wire:click="nextStep" 
                            class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition-colors">
                        Suivant →
                    </button>
                </div>
            </div>
        @endif

        <!-- Étape 3: Références -->
        @if($step === 3)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">🔗 Références de plateformes (optionnel)</h2>
                
                <p class="text-gray-600 mb-4">
                    Aidez-nous à mieux comprendre votre projet en ajoutant des exemples de plateformes similaires.
                </p>

                <!-- Références ajoutées -->
                @if(count($references) > 0)
                    <div class="space-y-3 mb-6">
                        @foreach($references as $key => $reference)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $reference['platform_name'] }}</h4>
                                        @if($reference['platform_url'])
                                            <a href="{{ $reference['platform_url'] }}" target="_blank" 
                                               class="text-sm text-blue-600 hover:text-blue-800">{{ $reference['platform_url'] }}</a>
                                        @endif
                                        @if($reference['similarity_score'] >= 80)
                                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
                                                🔥 Très similaire
                                            </span>
                                        @elseif($reference['similarity_score'] >= 50)
                                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                                👍 Similaire
                                            </span>
                                        @endif
                                    </div>
                                    <button type="button" wire:click="removeReference({{ $key }})" 
                                            class="text-red-500 hover:text-red-700">
                                        ×
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Formulaire d'ajout -->
                @if($showReferenceForm)
                    <div class="border border-gray-200 rounded-lg p-4 mb-6 bg-gray-50">
                        <h3 class="font-medium text-gray-900 mb-4">Ajouter une référence</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de la plateforme *</label>
                                <input type="text" wire:model="newReference.platform_name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('newReference.platform_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">URL (optionnel)</label>
                                <input type="url" wire:model="newReference.platform_url" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select wire:model="newReference.platform_type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="reference">📋 Référence</option>
                                    <option value="competitor">⚔️ Concurrent</option>
                                    <option value="inspiration">💡 Inspiration</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                                <textarea wire:model="newReference.description" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" wire:click="addReference" 
                                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                                    Ajouter
                                </button>
                                <button type="button" wire:click="$set('showReferenceForm', false)" 
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <button type="button" wire:click="$set('showReferenceForm', true)" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors mb-6">
                        + Ajouter une référence
                    </button>
                @endif

                <!-- Suggestions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="font-medium text-blue-900 mb-3">💡 Suggestions pour votre projet {{ $type }} :</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($this->getSuggestedPlatforms() as $suggestion)
                            <button type="button" wire:click="$set('newReference.platform_name', '{{ $suggestion['name'] }}'); $set('newReference.platform_url', '{{ $suggestion['url'] }}'); $set('showReferenceForm', true)" 
                                    class="text-left p-3 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                <div class="font-medium text-blue-900">{{ $suggestion['name'] }}</div>
                                <div class="text-sm text-blue-700">{{ $suggestion['description'] }}</div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" wire:click="previousStep" 
                            class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        ← Précédent
                    </button>
                    <button type="submit" 
                            class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition-colors">
                        📤 Publier le projet
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>

