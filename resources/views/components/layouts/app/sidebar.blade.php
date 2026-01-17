<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.theme-init')
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="flex items-center justify-between me-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <livewire:notification.notification-bell />
        </div>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                {{-- Projets --}}
                @can('ViewAny:Project')
                <flux:navlist.item icon="folder-open" :href="route('projects.list')"
                    :current="request()->routeIs('projects.*')" wire:navigate>{{ __('Projets') }}</flux:navlist.item>
                @endcan

                {{-- Développeurs --}}
                @can('ViewAny:User')
                <flux:navlist.item icon="users" :href="route('developers.list')"
                    :current="request()->routeIs('developers.*')" wire:navigate>{{ __('Développeurs') }}
                </flux:navlist.item>
                 <flux:navlist.item icon="chart-bar" :href="route('projects.request')"
                    :current="request()->routeIs('projects.request')" wire:navigate>{{ __('Pulier un projet') }}
                </flux:navlist.item>
                @endcan

                {{-- Commissions --}}
                @can('ViewAny:Commission')
                <flux:navlist.item icon="users" :href="route('commissions.dashboard')"
                    :current="request()->routeIs('commissions.*')" wire:navigate>{{ __('Commissions') }}
                </flux:navlist.item>
                @endcan

                {{-- Portfolio --}}
                <flux:navlist.item icon="photo" :href="route('portfolio.gallery')"
                    :current="request()->routeIs('portfolio.*')" wire:navigate>{{ __('Portfolio') }}
                </flux:navlist.item>

                {{-- Avis (Reviews) --}}
                @can('ViewAny:Review')
                <flux:navlist.item icon="star" :href="route('reviews.index')"
                    :current="request()->routeIs('reviews.*')" wire:navigate>
                    {{ __('Avis Clients') }}
                    @if(auth()->user()->can('Update:Review') && \App\Models\Review::pending()->count() > 0)
                        <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                            {{ \App\Models\Review::pending()->count() }}
                        </span>
                    @endif
                </flux:navlist.item>
                @endcan

                {{-- Blog (Articles) --}}
                @can('ViewAny:Article')
                <flux:navlist.item icon="document-text" :href="route('blog.index')"
                    :current="request()->routeIs('blog.*')" wire:navigate>{{ __('Blog') }}
                </flux:navlist.item>
                @endcan

            </flux:navlist.group>

            <flux:navlist.group :heading="__('Support & Communication')" class="grid">
                @can('ViewAny:SupportTicket')
                <flux:navlist.item icon="chat-bubble-left-right" :href="route('support.list')"
                    :current="request()->routeIs('support.*')" wire:navigate>{{ __('Support Client') }}
                </flux:navlist.item>
                @endcan
                <flux:navlist.item icon="bell" :href="route('notifications')"
                    :current="request()->routeIs('notifications')" wire:navigate>{{ __('Centre de Notifications') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Administration')" class="grid">
                @can('ViewAny:WorkloadManagement')
                <livewire:notification.project-request-notification />
                <flux:navlist.item icon="chart-bar" :href="route('workload.dashboard')"
                    :current="request()->routeIs('workload.*')" wire:navigate>{{ __('Gestion de Charge') }}
                </flux:navlist.item>
                
                @endcan
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Compte')" class="grid">
                <flux:navlist.item icon="user-circle" :href="route('profile.edit')"
                    :current="request()->routeIs('profile.edit')" wire:navigate>{{ __('Mon Profil') }}
                </flux:navlist.item>
                <flux:navlist.item icon="cog-6-tooth" :href="route('profile.edit')"
                    :current="request()->routeIs('settings.*')" wire:navigate>{{ __('Paramètres') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/rosto-infinity/obryl-tech"
                target="_blank">
                {{ __('Repositorie') }}
            </flux:navlist.item>

           
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="h-full w-full object-cover" alt="{{ auth()->user()->name }}" />
                                @else
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                @endif
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="h-full w-full object-cover" alt="{{ auth()->user()->name }}" />
                                @else
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                @endif
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
