<table class="mt-6 w-full table-aut text-gray-900 dark:text-gray-100">
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
                <?php
                    setPermissionsTeamId( $team->id );
                    auth()->user()->unsetRelation('roles')->unsetRelation('permissions');
                ?>
                @foreach( auth()->user()->roles as $role )
                    {{ $role->name }}<br/>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
