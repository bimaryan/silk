<div class="relative overflow-x-auto rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="data-peminjaman">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Peminjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal dan Waktu Peminjaman
                </th>
                <th scope="col" class="px-6 py-3">
                    Waktu Pengembalian
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Detail
                </th>
                <th scope="col" class="px-6 py-3">
                    Persetujuan
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($peminjaman->isEmpty())
                <tr>
                    <td colspan="8" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada peminjaman
                    </td>
                </tr>
            @else
                @foreach ($peminjaman as $userId => $loans)
                    @if ($loans->first()->status === 'Menunggu Persetujuan' || $loans->first()->status === 'Dipinjamkan')
                        <!-- Kondisi untuk mengecek status -->
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td cope="col" class="px-6 py-3">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-3">
                                @if ($loans->first()->mahasiswa_id)
                                    {{ $loans->first()->mahasiswa->nama }}
                                @elseif ($loans->first()->dosen_id)
                                    {{ $loans->first()->dosen->nama ?? '-' }}
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->tanggal_waktu_peminjaman ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->waktu_pengembalian ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $status = $loans->first()->status;
                                @endphp
                                <span
                                    class="text-{{ $status === 'Menunggu Persetujuan' ? 'yellow' : ($status === 'Dipinjamkan' ? 'green' : 'red') }}-100 text-{{ $status === 'Menunggu Persetujuan' ? 'yellow' : ($status === 'Dipinjamkan' ? 'green' : 'red') }}-500 text-xs">
                                    {{ $status }}
                                </span>
                            </td>
                            <td scope="col" class="px-6 py-3">
                                <button type="button" data-modal-target="detail{{ $userId }}"
                                    data-modal-toggle="detail{{ $userId }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                @include('components.modal.modaldetailVerifikasipeminjaman')
                            </td>
                            <td scope="col" class="px-6 py-3">
                                <div class="flex items-center space-x-6">
                                    <form action="{{ route('peminjaman.update', $loans->first()->id ?? '') }}"
                                        method="POST" class="flex items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <select name="aprovals" id="aprovals" class="p-1 border rounded-md">
                                                <option value="Belum"
                                                    {{ $loans->first()->aprovals == 'Belum' ? 'selected' : '' }}>
                                                    Belum
                                                </option>
                                                <option value="Ya"
                                                    {{ $loans->first()->aprovals == 'Ya' ? 'selected' : '' }}>
                                                    Ya
                                                </option>
                                                <option value="Tidak"
                                                    {{ $loans->first()->aprovals == 'Tidak' ? 'selected' : '' }}>
                                                    Tidak
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit"
                                                class="p-1 font-medium text-white bg-green-500 rounded-lg">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</div>
