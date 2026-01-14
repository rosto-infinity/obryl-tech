<div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <flux:heading size="xl">Ouvrir un Nouveau Ticket</flux:heading>
        <flux:subheading>Décrivez votre problème et nous vous répondrons dès que possible.</flux:subheading>
    </div>

    <form wire:submit="save" class="space-y-6">
        <flux:field>
            <flux:label>Sujet du ticket</flux:label>
            <flux:input wire:model="title" placeholder="Ex: Problème de connexion au dashboard" />
            <flux:error name="title" />
        </flux:field>

        <flux:field>
            <flux:label>Projet concerné (Optionnel)</flux:label>
            <flux:select wire:model="project_id" placeholder="Sélectionnez un projet">
                <flux:select.option value="">Aucun projet spécifique</flux:select.option>
                @foreach($projects as $project)
                    <flux:select.option value="{{ $project->id }}">{{ $project->title }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="project_id" />
        </flux:field>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <flux:field>
                <flux:label>Catégorie</flux:label>
                <flux:select wire:model="category">
                    @foreach(\App\Enums\Support\TicketCategory::cases() as $categoryCase)
                        <flux:select.option value="{{ $categoryCase->value }}">{{ $categoryCase->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="category" />
            </flux:field>

            <flux:field>
                <flux:label>Gravité</flux:label>
                <flux:select wire:model="severity">
                    @foreach(\App\Enums\Support\TicketSeverity::cases() as $severityCase)
                        <flux:select.option value="{{ $severityCase->value }}">{{ $severityCase->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="severity" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Description du problème</flux:label>
            <flux:textarea wire:model="description" rows="6" placeholder="Soyez le plus précis possible..." />
            <flux:error name="description" />
        </flux:field>

        <div class="flex items-center gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                Créer le ticket
            </flux:button>
            <flux:button href="{{ route('support.list') }}" variant="ghost" wire:navigate>
                Annuler
            </flux:button>
        </div>
    </form>
</div>
