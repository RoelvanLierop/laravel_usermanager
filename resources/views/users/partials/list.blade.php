<table class="mt-6 w-full table-fixed">
    <thead>
        <tr>
            <th class="p-0 py-2 m-0 text-start">Name</th>
            <th class="p-0 py-2 m-0" colspan="3" style="width:120px">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class="border-t">
            <td class="p-0 py-2 m-0 text-start">
                <a href="{{ route('user_read', ['id' => $user->id ] ) }}">{{ $user->name }}</a>
            </td>
            <td class="py-2" style="width:40px">
                <a class="rounded-xl bg-orange-400 float-right block" href="{{ route( 'relogin_start', ['id' => $user->id ] ) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>
            </td>
            <td class="py-2" style="width:40px">
                <a class="rounded-xl bg-orange-400 float-right block" href="{{ route('user_read', ['id' => $user->id ] ) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                      </svg>
                </a>
            </td>
            <td class="py-2" style="width:40px">
                @if( $user->id > 1 )
                    <a class="rounded-xl bg-red-400 float-right block" href="{{ route('user_delete', [ 'id' => $user->id ] ) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </a>
                @else
                    &nbsp;
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
