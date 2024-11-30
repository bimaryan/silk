<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Dosen
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail{{ $data->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-2">
                <div class="flex flex-col items-center gap-5 p-4 md:flex-row">
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="{{ asset($data->foto ?? 'image/icon_profile.png') }}" alt="{{ $data->foto }}"
                            class="object-cover" style="width: 150px; height: 150px;">
                    </div>
                    <div class="relative grid grid-cols-2 gap-2 overflow-x-auto">
                        <div class="space-y-2">
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>NIP</span>
                                <span>:</span>
                            </p>
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>Nama</span>
                                <span>:</span>
                            </p>
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>Username</span>
                                <span>:</span>
                            </p>
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>Email</span>
                                <span>:</span>
                            </p>
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>Nomor Telepon</span>
                                <span>:</span>
                            </p>
                            <p class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                <span>Jenis Kelamin</span>
                                <span>:</span>
                            </p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->nip ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->nama ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->username ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->email ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->telepon ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $data->jenis_kelamin ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
