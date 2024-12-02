<h1 align="center">APLIKASI PEMINJAMAN BAHAN DAN ALAT LABORATORIUM PROGRAM STUDI KESEHATAN</h1>

## Anggota Team:

-   Bima Ryan Alfarizi (Ketua team)
-   Anwar Musyadad
-   Gustian Prayoga Januar

## Pengertian Aplikasi Peminjaman Bahan dan Alat Laboratorium

Aplikasi peminajaman bahan dan alat laboratorium adalah sebuah sistem berbasis teknologi yang dirancang untuk mempermudah proses peminjaman, pengembalian, serta pengelolaan inventaris laboratorium secara digital. Aplikasi ini memungkinkan pengguna, baik mahasiswa maupun dosen, untuk memesan, meminjam, dan mengembalikan alat serta bahan laboratorium dengan mudah melalui platform yang terhubung secara online. Selain itu, aplikasi ini memungkinkan pihak laboratorium memantau ketersediaan alat dan bahan serta melakukan pencatatan riwayat penggunaan secara otomatis.

## Tujuan Aplikasi Peminjaman Bahan dan Alat Laboratorium

Tujuan utama dari aplikasi ini adalah untuk meningkatkan efisiensi dan akurasi dalam pengelolaan bahan dan alat laboratorium. Secara spesifik, tujuan-tujuan aplikasi ini diantaranya:

1. Mengotomatisasi proses peminjaman dan pengemalian peralatan laboratorium.
2. Mengurangi resiko kehilangan atau kerusakan alat akibat pencatatan manual yang tidak efisien.
3. Memudahkan pelacakan riwayat penggunaan alat dan bahan laboratorium.
4. Meningkatkan keteraturan dalam pemanfaatan sumber daya laboratorium.
5. Mengoptimalkan pengelolaan inventaris dengan sistem monitoring real-time.
6. Memfasilitasi mahasiswa dan dosen untuk merencanakan penggunaan alat secara lebih terstruktur.

## Manfaat Aplikasi Peminjaman Bahan dan Alat Laboratorium

Penggunaan aplikasi ini memberikan berbagai manfaat, di antaranya:

1. Proses peminjaman dan pengembalian menjadi lebih cepat dan terstruktur.
2. Aplikasi mengurangi kesalahan pencatatan manual, sehingga data peminjaman dan pengembalian alat lebih akurat.
3. Riwayat penggunaan alat dapat diakses oleh semua pihak yang berwenang, sehingga menciptakan transparansi dalam peminjaman.
4. Pengelola laboratorium dapat mengetahui seacar real-time bahan dan alat apa yang tersedia, rusak, atau dalam proses peminjaman.
5. Mahasiswa dan dosen dapat meminjam alat sesuai jadwal yang tersedia tanpa adanya benturan waktu.
6. Sistem yang terdokumentasi dengan baik mengurangi kemungkinan kehilangan atau kerusakan alat tanpa catatan.

## Langkah Instalasi

Ini adalah proyek MBKM yang dibuat untuk tujuan pembelajaran. Berikut adalah langkah-langkah untuk menjalankan proyek ini.

1. **Clone Repositori**

    Pertama, lakukan clone repositori dengan perintah berikut:

    `https://github.com/bimaryan/project-mbkm.git`

2. **Install Dependency dan Generate Key**

    Setelah proses clone selesai, buka folder proyek, lalu jalankan perintah berikut untuk menginstall dependency dan membuat key aplikasi pada file `.env`:

    Install Dependency
    `composer install`

    Generate Key
    `php artisan key::generate`

3. **Migrasi Database dan Seeder**

    Setelah itu, lakukan migrasi database beserta seeding data dengan perintah berikut:

    `php artisan migrate --seed`

4. **Jalankan Proyek**

    Untuk menjalankan proyek, gunakan perintah berikut:

    `php artisan serve`

    Akses proyek melalui browser di alamat: `http://localhost:8000`
