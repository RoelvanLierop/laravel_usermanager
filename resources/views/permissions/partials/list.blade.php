<table class="mt-6 w-full table-fixed">
    <thead>
        <tr>
            <th class="p-0 py-2 m-0 text-start">Name</th>
            <th class="p-0 py-2 m-0" colspan="3" style="width:120px">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
        <tr class="border-t">
            <td class="p-0 py-2 m-0 text-start">
                <a href="{{ route('permission_read', ['id' => $permission->id ] ) }}">{{ $permission->name }}</a>
            </td>
            <td class="py-2" style="width:40px">&nbsp;</td>
            <td class="py-2" style="width:40px">
                <a class="rounded-xl bg-orange-400 float-right block" href="{{ route('permission_read', ['id' => $permission->id ] ) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                      </svg>
                </a>
            </td>
            <td class="py-2" style="width:40px">
                <a class="rounded-xl bg-red-400 float-right block" href="{{ route('permission_delete', [ 'id' => $permission->id ] ) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
