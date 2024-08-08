<x-app-layout>
    <x-slot name="header">
        <a class="rounded-xl bg-lime-400 float-right block" href="{{ route('team_read') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create team</h3>
                    <form method="post" action="{{ route('team_create_post') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div>
                            <x-input-label for="team_name" :value="__('Name')" />
                            <x-text-input id="team_name" name="team_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="team_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('team_name')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'team-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
