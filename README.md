# FinTrack — Case 3 Dasar Komputer dan Pemrograman

Aplikasi web pencatatan keuangan pribadi berbasis Laravel 12, Tailwind CSS, Flux, Livewire, dan Alpine.js.

## Fitur
- Register dan login mandiri menggunakan Laravel Auth serta Hash password.
- Dashboard saldo, pemasukan, pengeluaran, grafik 6 bulan, dan transaksi terbaru.
- CRUD transaksi dan kategori.
- Soft-delete untuk transaksi dan kategori; halaman Riwayat menampilkan transaksi terhapus.
- Migration dan Seeder.
- Cache ringkasan dashboard selama 5 menit dan dihapus ulang saat transaksi berubah.
- Alpine.js untuk sidebar mobile, notifikasi, dan konfirmasi hapus.
- Flux terpasang sebagai dependensi dan asset/scripts Flux dipanggil pada layout.
- Queue database dan scheduler disiapkan secara opsional.

## Persyaratan
- PHP 8.2 atau lebih baru
- Composer
- Node.js dan NPM
- Laragon / lingkungan PHP lokal

## Cara menjalankan di Windows (Laragon)
1. Ekstrak folder `fintrack` ke `C:\laragon\www\fintrack`.
2. Buka Terminal Laragon pada folder tersebut.
3. Jalankan `composer install`.
4. Salin `.env.example` menjadi `.env`.
5. Buat file database SQLite: `type nul > database\database.sqlite` (Command Prompt) atau `New-Item database/database.sqlite -ItemType File` (PowerShell).
6. Pastikan `.env` memakai `DB_CONNECTION=sqlite`. Jika perlu tambahkan `DB_DATABASE=database/database.sqlite` atau atur `DB_DATABASE` ke path absolut database SQLite.
7. Jalankan `php artisan key:generate`.
8. Jalankan `php artisan migrate --seed`.
9. Jalankan `npm install`.
10. Jalankan `npm run build`.
11. Jalankan `php artisan serve` lalu buka `http://127.0.0.1:8000`.

Akun demo setelah seeder:
- Email: `demo@fintrack.test`
- Password: `password123`

## Catatan penting untuk tugas
- Login/register dibuat sendiri di `app/Http/Controllers/AuthController.php`; tidak memakai starter kit auth bawaan.
- Hash password dilakukan dengan `Hash::make()` dan verifikasi melalui `Auth::attempt()`.
- Soft-delete ada pada model `Transaction` dan `Category` serta kolom `deleted_at` pada migration.
- Cache dashboard ada di `DashboardController`; invalidasi cache ada di `TransactionController`.
- Tailwind CSS memakai Vite dan Tailwind v4. Flux dipasang sebagai package `livewire/flux`, stylesheet Flux dimuat, dan tombol tambah transaksi memakai komponen `<flux:button>`.
- Livewire digunakan pada tabel transaksi melalui komponen `App\\Livewire\\TransactionTable`: pencarian, filter jenis, pagination, dan soft-delete berjalan secara interaktif.
- Queue dan Schedule bersifat opsional sesuai pengumuman.

## Catatan port forwarding
Untuk pengujian dari perangkat lain pada jaringan yang sama, jalankan:
`php artisan serve --host=0.0.0.0 --port=8000`
Lalu buka alamat IPv4 laptop dengan port `8000` dari perangkat lain. Pastikan firewall Windows mengizinkan koneksi pada jaringan privat. Untuk akses internet publik gunakan tunnel/hosting yang aman, jangan membuka database atau server development secara langsung.
