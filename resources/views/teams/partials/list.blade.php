<table class="mt-6 w-full table-auto text-gray-900 dark:text-gray-100">
    <thead>
        <tr>
            <th class="p-0 py-2 m-0 text-left">Name</th>
            <th class="p-0 py-2 m-0 text-right" colspan="3" style="width:120px">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teams as $team)
        <tr class="border-t">
            <td class="p-0 py-2 m-0 text-left"><a href="{{ route('team_read', ['id' => $team->id ] ) }}">{{ $team->team_name }}</a></td>
            <td class="py-2" style="40px"></td>
            <td class="py-2" style="40px"></td>
            <td class="py-2" style="40px">
                <!-- @TODO: Impact assessment first! Code below works but gives errors when a team is removed when the permissions are still there!
                    <a class="rounded-xl bg-red-400 float-right block" href="{{ route('team_delete', [ 'id' => $team->id ] ) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </a>
                -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
