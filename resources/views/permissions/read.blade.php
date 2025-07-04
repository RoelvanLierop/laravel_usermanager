<x-app-layout>
    <x-slot name="header">
        @if( $permissionCount === 1 && intval($requestid) > 0 )
            <a class="rounded-xl bg-lime-400 float-right block" href="{{ route('permission_read') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
        @else
            <a class="rounded-xl bg-lime-400 float-right block" href="{{ route('permission_create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permission Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if( $permissionCount === 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Permission list empty</h3>
                    @elseif ( $permissionCount > 0 && intval($requestid) > 0 && $permissions->count() === 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">No known permission exists for that ID</h3>
                    @elseif ( $permissionCount === 1 && intval($requestid) > 0 )
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit permission</h3>
                        @include('usermanager::permissions.partials.read', [ 'permission' => $permissions[0] ])
                    @else
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Permission list</h3>
                        @include('usermanager::permissions.partials.list', [ $permissions ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
