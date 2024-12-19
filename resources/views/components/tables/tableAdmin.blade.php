<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Admin/Staff
                </th>
                <th scope="col" class="px-6 py-3">
                    NIDN/NIP
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if($users->isEmpty())
            <tr class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 text-center">Tidak ada data</td>
            </tr>
            @endif
            @foreach ($users as $data)
                <tr
                class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                    <td scope="col" class="px-6 py-3">
                        {{ $loop->iteration }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->nama }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->nip }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->username }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->role->nama_role }}
                    </td>
                    <td scope="col" class="flex items-center justify-center gap-2 px-6 py-3">
                        <div>
                            <form id="delete-form-{{ $data->id }}"
                                action="{{ route('admin-dan-staff.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $data->id }})"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <div>
                            <button type="button" data-modal-target="edit{{ $data->id }}"
                                data-modal-toggle="edit{{ $data->id }}"
                                class="flex items-center px-2 py-2 text-sm text-white bg-blue-500 rounded">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- MODAL EDIT BARANG --}}
                @include('components.modal.modaleditAdmin')
            @endforeach
        </tbody>
    </table>
</div>
