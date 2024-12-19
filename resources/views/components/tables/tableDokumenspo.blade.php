<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama Dokumen</th>
                <th scope="col" class="px-6 py-3">File</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($dokumen->isEmpty())
            <tr class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                <td colspan="4" class="px-6 py-4 text-center">Tidak ada data</td>
            </tr>
            @endif
            @foreach ($dokumen as $data)
                <tr
                    class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $data->nama_dokumen }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('download.spo', $data->id) }}" class="text-blue-500">
                            Download
                        </a>
                    </td>
                    <td scope="col" class="flex items-center justify-center gap-2 px-6 py-4">
                        <div>
                            <form id="delete-form-{{ $data->id }}"
                                action="{{ route('data-spo.destroy', $data->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $data->id }})"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
