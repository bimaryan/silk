<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-kategori">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Kategori
                </th>
                {{-- <th scope="col" class="px-6 py-3">
                    Aksi
                </th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $data)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td scope="col" class="px-6 py-3">
                        {{ $loop->iteration }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->kategori }}
                    </td>
                    {{-- <td scope="col" class="flex items-center gap-2 px-6 py-3">
                        <div>
                            <form id="delete-form-{{ $data->id }}"
                                action="{{ route('kategori.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $data->id }})"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
