<form method="post" action="{{ route('user_update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')
    <x-text-hidden id="id" :value="$user->id" name="id" required />

    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" :value="$user->name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'user-updated')
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
