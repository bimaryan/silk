<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 display dark:text-gray-400" style="100%" id="data-matakuliah">
        <thead class="uppercase text-cen-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Kode Mata Kuliah</th>
                <th scope="col" class="px-6 py-3">Mata Kuliah</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matakuliah as $data)
                <tr
                    class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $data->kode_mata_kuliah }}</td>
                    <td class="px-6 py-4">{{ $data->mata_kuliah }}</td>
                    <td scope="col" class="flex items-center justify-center gap-2 px-6 py-4">
                        <div>
                            <form id="delete-form-{{ $data->id }}"
                                action="{{ route('data-mata-kuliah.destroy', $data->id) }}" method="POST"
                                class="inline">
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

                @include('components.modal.modaleditMatakuliah')
            @endforeach
        </tbody>
    </table>
</div>
