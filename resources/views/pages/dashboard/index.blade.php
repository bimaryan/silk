@extends('index')
@section('content')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            <div class="space-y-4 rounded-lg mt-14">
                <div class="p-4 bg-white rounded-lg shadow-lg flex items-center">
                    <p class="text-lg font-semibold text-green-500">Dashboard</p>
                </div>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
                    <div>
                        <div class="p-4 bg-white rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">Peminjaman</p>
                                    <p class="text-xl font-semibold">{{ $totalPeminjaman }}</p>
                                </div>
                                <div>
                                    <div class="text-3xl font-semibold text-blue-500">
                                        <i class="fa-solid fa-boxes-stacked"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 bg-white rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">Mahasiswa</p>
                                    <p class="text-xl font-semibold">{{ $totalMahasiswa }}</p>
                                </div>
                                <div>
                                    <div class="text-3xl font-semibold text-green-500">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 bg-white rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">Alat</p>
                                    <p class="text-xl font-semibold">{{ $totalAlat }}</p>
                                </div>
                                <div>
                                    <div class="text-3xl font-semibold text-yellow-500">
                                        <i class="fa-solid fa-microscope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 bg-white rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">Bahan</p>
                                    <p class="text-xl font-semibold">{{ $totalBahan }}</p>
                                </div>
                                <div>
                                    <div class="text-3xl font-semibold text-red-500">
                                        <i class="fa-solid fa-pump-medical"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        <div>
                            <canvas id="peminjamanChart" width="400" height="200"></canvas>
                        </div>
                        <div>
                            <canvas id="mahasiswaChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        <div>
                            <canvas id="alatChart" width="400" height="200"></canvas>
                        </div>
                        <div>
                            <canvas id="bahanChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            const peminjamanChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Peminjaman Terakhir 30 Hari', 'Total Peminjaman', 'Peminjaman Dikembalikan'],
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: [{{ $peminjamanTerakhir30Hari }}, {{ $totalPeminjaman }},
                            {{ $totalDikembalikan }}
                        ],
                        backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0'],
                        borderColor: ['#36A2EB', '#FF6384', '#4BC0C0'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Data Peminjaman'
                        }
                    }
                }
            });

            const ctxMahasiswa = document.getElementById('mahasiswaChart').getContext('2d');
            const mahasiswaChart = new Chart(ctxMahasiswa, {
                type: 'bar',
                data: {
                    labels: ['Total Mahasiswa'],
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: [{{ $totalMahasiswa }}],
                        backgroundColor: '#36A2EB',
                        borderColor: '#36A2EB',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxAlat = document.getElementById('alatChart').getContext('2d');
            const alatChart = new Chart(ctxAlat, {
                type: 'bar',
                data: {
                    labels: ['Total Alat'],
                    datasets: [{
                        label: 'Jumlah Alat',
                        data: [{{ $totalAlat }}],
                        backgroundColor: '#36A2EB',
                        borderColor: '#36A2EB',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxBahan = document.getElementById('bahanChart').getContext('2d');
            const bahanChart = new Chart(ctxBahan, {
                type: 'bar',
                data: {
                    labels: ['Total Bahan'],
                    datasets: [{
                        label: 'Jumlah Bahan',
                        data: [{{ $totalBahan }}],
                        backgroundColor: '#FF6384',
                        borderColor: '#FF6384',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endsection
