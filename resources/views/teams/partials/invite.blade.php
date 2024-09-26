<p>Invite a new user to this team!</p>
<form method="post" action="{{ route('team_invite') }}" class="mt-6 space-y-6">
    @csrf
    @method('post')
    <x-text-hidden id="id" :value="$tid" name="id" required />

    <div>
        <x-input-label for="email" :value="__('email')" />
        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" required autofocus autocomplete="email" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div>
        <x-input-label for="role" :value="__('role')" />
        <x-form-select id="role" name="role" type="text" class="mt-1 block w-full" :options="$roles" required autofocus autocomplete="role" />
        <x-input-error class="mt-2" :messages="$errors->get('role')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'invite_generated')
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
