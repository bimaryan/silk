<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 display dark:text-gray-400" style="100%" id="data-admin-dan-staff">
        <thead class="uppercase text-cen-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Lengkap
                </th>
                <th scope="col" class="px-6 py-3">
                    NIP/NIDN
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $data)
                <tr>
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
                    <td scope="col" class="flex items-center justify-center gap-2 px-6 py-3">
                        <div>
                            <button type="button" data-modal-target="detail{{ $data->id }}"
                                data-modal-toggle="detail{{ $data->id }}"
                                class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
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

                {{-- MODAL DETAIL ADMIN DAN STAFF --}}
                @include('components.modal.modaldetailAdmin')

                {{-- MODAL EDIT BARANG --}}
                @include('components.modal.modaleditAdmin')
            @endforeach
        </tbody>
    </table>
</div>
