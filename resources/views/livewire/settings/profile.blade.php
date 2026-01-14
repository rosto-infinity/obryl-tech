<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your personal information and profile details.')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            
            {{-- Avatar --}}
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                <div class="shrink-0">
                    @if ($avatar)
                         <img class="h-16 w-16 object-cover rounded-full" src="{{ $avatar->temporaryUrl() }}" alt="New profile photo preview" />
                    @elseif ($currentAvatar)
                        <img class="h-16 w-16 object-cover rounded-full" src="{{ Storage::url($currentAvatar) }}" alt="Current profile photo" />
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-2xl font-bold">
                            {{ substr($name, 0, 1) }}
                        </div>
                    @endif
                </div>
                </div>
                <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input type="file" wire:model="avatar" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-violet-50 file:text-violet-700
                        hover:file:bg-violet-100
                    "/>
                    @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </label>
            </div>

            <flux:input wire:model="name" :label="__('Name')" type="text" required autocomplete="name" />

            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

            <flux:input wire:model="phone" :label="__('Phone')" type="tel" />

            <flux:textarea wire:model="bio" :label="__('Bio')" rows="4" placeholder="Tell us a little about yourself..." />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="company" :label="__('Company')" type="text" />
                <flux:input wire:model="country" :label="__('Country')" type="text" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="github_url" :label="__('GitHub URL')" type="url" placeholder="https://github.com/username" />
                <flux:input wire:model="linkedin_url" :label="__('LinkedIn URL')" type="url" placeholder="https://linkedin.com/in/username" />
            </div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                <div>
                    <flux:text class="mt-4">
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Changes') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
