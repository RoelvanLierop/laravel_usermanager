<table class="mt-6 w-full table-auto text-gray-900 dark:text-gray-100">
    <thead>
        <tr>
            <th class="p-0 py-2 m-0 text-left">Name</th>
            <th class="p-0 py-2 m-0 text-right" colspan="3" style="width:120px">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr class="border-t">
            <td class="p-0 py-2 m-0 text-left">{{ $role }}</td>
            <td class="py-2" style="40px"></td>
            <td class="py-2" style="40px"></td>
            <td class="py-2" style="40px"></td>
        </tr>
        @endforeach
    </tbody>
</table>
