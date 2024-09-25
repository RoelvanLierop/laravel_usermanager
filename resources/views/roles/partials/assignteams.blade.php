<table class="mt-6 w-full table-fixed">
    <thead>
        <tr>
            <th class="p-0 py-2 m-0 text-start">Name</th>
            <th class="p-0 py-2 m-0" colspan="3" style="width:120px">Assign</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teams as $team)
        <tr class="border-t">
            <td class="p-0 py-2 m-0 text-start">
                <a href="{{ route('team_assign', ['id' => $team->id ] ) }}">{{ $team->team_name }}</a>
            </td>
            <td class="py-2" style="width:40px">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
