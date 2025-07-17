# Aplikasi Pembayaran Listrik Pascabayar

Aplikasi ini adalah sistem manajemen pembayaran listrik pascabayar berbasis web yang dibangun dengan Laravel 11. Aplikasi ini menyediakan antarmuka bagi Administrator, Petugas, dan Pelanggan untuk mengelola data penggunaan, tagihan, dan pembayaran listrik.

---

## Fitur Utama

-   **Autentikasi & Otorisasi**: Login terpadu untuk Admin/Petugas dan Pelanggan dengan pembagian hak akses (privilege).
-   **Manajemen Master Data**: Pelanggan, Tarif, User (Admin & Petugas).
-   **Manajemen Transaksi**: Penggunaan Listrik per bulan, Tagihan Listrik, Pembayaran (termasuk integrasi Midtrans untuk pembayaran oleh pelanggan).
-   **Dashboard Interaktif**: Ringkasan data untuk Admin, Petugas, dan Pelanggan.
-   **Riwayat & Profil Pelanggan**: Pelanggan dapat melihat riwayat penggunaan, tagihan, pembayaran, dan mengelola profil pribadi.

---

## Persyaratan Sistem

-   PHP >= 8.2
-   Composer
-   Node.js & npm (untuk Tailwind CSS)
-   Database MySQL / MariaDB
-   Web Server (Apache/Nginx) atau menggunakan `php artisan serve`

---

## Instalasi dan Setup Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal Anda.

1.  **Clone Repositori:**

    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd [nama_folder_proyek_anda]
    ```

2.  **Instal Dependensi Composer:**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment (.env):**

    -   Duplikasi file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Edit file `.env` dan sesuaikan pengaturan database dan Midtrans:

        ```env
        APP_NAME="Pembayaran Listrik"
        APP_ENV=local
        APP_KEY= # Akan digenerate di langkah selanjutnya

        DB_CONNECTION=mysql
        DB_HOST=127.00.0.1
        DB_PORT=3306
        DB_DATABASE=pembayaran_listrik # Ganti dengan nama database Anda
        DB_USERNAME=root # Ganti dengan username database Anda
        DB_PASSWORD= # Ganti dengan password database Anda

        MIDTRANS_SERVER_KEY="YOUR_SERVER_KEY_FROM_MIDTRANS_DASHBOARD"
        MIDTRANS_CLIENT_KEY="YOUR_CLIENT_KEY_FROM_MIDTRANS_DASHBOARD"
        MIDTRANS_IS_PRODUCTION=false # Set true jika di production
        ```

4.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5.  **Jalankan Migrasi Database:**

    -   Ini akan membuat semua tabel database yang diperlukan.

    ```bash
    php artisan migrate
    ```

    -   **Catatan:** Jika Anda ingin menghapus semua tabel yang ada dan memulai bersih:
        ```bash
        php artisan migrate:fresh
        ```

6.  **Jalankan Seeder (Opsional, untuk data awal):**

    -   Jika Anda memiliki seeder untuk Level, User, atau data dummy lainnya.

    ```bash
    php artisan db:seed # Ini akan menjalankan DatabaseSeeder
    # Atau jika Anda memiliki seeder spesifik (contoh: LevelSeeder)
    php artisan db:seed --class=LevelSeeder
    # Atau buat user admin pertama secara manual di DB atau seeder Anda
    ```

    _Pastikan Anda punya user Admin (`level_id=1`) dan Petugas (`level_id=2`) untuk pengujian._

7.  **Instal Dependensi Node.js & Compile Assets (Tailwind CSS):**

    ```bash
    npm install
    npm run dev # Untuk pengembangan
    # npm run build # Untuk produksi
    ```

8.  **Jalankan Aplikasi:**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di browser Anda, biasanya di `http://127.0.0.1:8000`.

---

## Pengujian Fitur Dasar

-   **Login Admin:** Gunakan kredensial user dengan `level_id=1`.
-   **Login Petugas:** Gunakan kredensial user dengan `level_id=2`.
-   **Login Pelanggan:** Gunakan kredensial dari tabel `pelanggan`.

---

## Konfigurasi Midtrans

-   Pastikan `MIDTRANS_SERVER_KEY` dan `MIDTRANS_CLIENT_KEY` di `.env` sudah diisi dengan kunci Sandbox (untuk testing).
-   Di Dashboard Sandbox Midtrans Anda, atur **URL Notifikasi (Webhook)** ke:
    `http://[URL_APLIKASI_ANDA]/midtrans/callback`
    (Contoh: `http://localhost:8000/midtrans/callback`). Jika di localhost, gunakan **Ngrok** untuk mendapatkan URL publik.

---
