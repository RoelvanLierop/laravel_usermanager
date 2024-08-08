<x-app-layout>
    <x-slot name="header">
        @if( $teamCount === 1 && intval($requestid) > 0 )
            <a class="rounded-xl bg-lime-400 float-right block" href="{{ route('team_read') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
        @else
            <a class="rounded-xl bg-lime-400 float-right block" href="{{ route('team_create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if( $teamCount === 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Team list empty</h3>
                    @elseif ( $teamCount > 0 && intval($requestid) > 0 && $teams->count() === 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">No known team exists for that ID</h3>
                    @elseif ( $teamCount === 1 && intval($requestid) > 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit team</h3>
                        @include('usermanager::teams.partials.read', [ 'team' => $teams[0] ])
                    @else
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Team list</h3>
                        @include('usermanager::teams.partials.list', [ $teams ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
