# Dokumentasi Lengkap Controller Laravel Pembayaran Listrik

---

## 1. **DashboardController**

### Fungsi:

-   `adminDashboard()`
    -   Menampilkan dashboard admin berisi:
        -   Total pelanggan.
        -   Total tagihan belum lunas.
        -   Total pembayaran bulan ini.
        -   5 pembayaran terbaru (beserta relasi pelanggan & tagihan).
        -   View: `admin.dashboard`
-   `petugasDashboard()`
    -   Menampilkan dashboard petugas berisi:
        -   Total pelanggan.
        -   Total tagihan belum lunas.
        -   Total penggunaan listrik bulan ini.
        -   5 penggunaan terbaru (relasi pelanggan).
        -   View: `petugas.dashboard`

---

## 2. **PelangganController**

### Fungsi:

-   `index()`
    -   Daftar pelanggan, tampilkan sesuai role (admin/petugas).
    -   Relasi: Tarif.
    -   View: `admin.pelanggans.index` / `petugas.pelanggans.index`
-   `create()`
    -   Form tambah pelanggan baru.
-   `store(Request $request)`
    -   Validasi & simpan pelanggan baru.
-   `edit(Pelanggan $pelanggan)`
    -   Form edit pelanggan, relasi tarif tersedia.
-   `update(Request $request, Pelanggan $pelanggan)`
    -   Update data pelanggan (validasi username unik, hash password bila baru).
-   `destroy(Pelanggan $pelanggan)`
    -   Hapus pelanggan, hanya untuk admin.

---

## 3. **PelangganDashboardController**

### Fungsi:

-   `index()`
    -   Dashboard pelanggan, tampilkan penggunaan terakhir dan tagihan belum dibayar.
-   `tagihanSaya(Request $request)`
    -   Daftar tagihan pelanggan, fitur search & sort.
-   `riwayatPembayaran(Request $request)`
    -   Riwayat pembayaran pelanggan, search & sort.
-   `profilSaya()`
    -   Halaman profil pelanggan, relasi tarif.
-   `updateProfil(Request $request)`
    -   Update profil dan password pelanggan.
-   `bayarTagihan(Request $request, $id)`
    -   Proses pembayaran tagihan via Midtrans (SnapToken).
-   `riwayatPenggunaan(Request $request)`
    -   Riwayat penggunaan listrik pelanggan.

#### Alur Umum:

-   Autentikasi menggunakan guard `pelanggan`.
-   Akses data hanya milik pelanggan tersebut.
-   Notifikasi pembayaran langsung update status tagihan.

---

## 4. **PenggunaanController**

### Fungsi:

-   `index()`
    -   Daftar penggunaan listrik, paginate, relasi pelanggan.
-   `create()`
    -   Form tambah penggunaan (dropdown pelanggan).
-   `store(Request $request)`
    -   Validasi data unik bulan/tahun/pelanggan, meter akhir > meter awal.
-   `edit(Penggunaan $penggunaan)`
    -   Form edit penggunaan.
-   `update(Request $request, Penggunaan $penggunaan)`
    -   Update data penggunaan (validasi unik, update meter).
-   `destroy(Penggunaan $penggunaan)`
    -   Hapus penggunaan (cek foreign key ke tagihan).
-   `show(Penggunaan $penggunaan)`
    -   Redirect ke list (tidak ada view khusus).

---

## 5. **TagihanController**

### Fungsi:

-   `index()`
    -   Daftar tagihan listrik, relasi pelanggan, tarif, penggunaan.
-   `createFromPenggunaan()`
    -   Buat tagihan dari data penggunaan yang belum ditagih.
-   `store(Request $request)`
    -   Simpan tagihan baru, validasi tarif.
-   `edit(Tagihan $tagihan)`
    -   Form edit tagihan.
-   `update(Request $request, Tagihan $tagihan)`
    -   Update status tagihan (Belum/Sudah Dibayar).
-   `destroy(Tagihan $tagihan)`
    -   Hapus tagihan.
-   `show(Tagihan $tagihan)`
    -   Redirect ke list.

#### Catatan:

-   Tagihan dibuat otomatis dari penggunaan listrik.
-   Status tagihan berubah saat pembayaran tercatat.

---

## 6. **TarifController**

### Fungsi:

-   `index()`
    -   Daftar tarif listrik, tampilkan sesuai role.
-   `create()`
    -   Form tambah tarif (admin).
-   `store(Request $request)`
    -   Simpan tarif baru (validasi daya unik, tarif numeric).
-   `edit(Tarif $tarif)`
    -   Form edit tarif.
-   `update(Request $request, Tarif $tarif)`
    -   Update data tarif.
-   `destroy(Tarif $tarif)`
    -   Hapus tarif.

#### Catatan:

-   Relasi tarif digunakan di model pelanggan dan tagihan.
-   Hanya admin/petugas yang bisa akses.

---

## 7. **UserController**

### Fungsi:

-   `index()`
    -   Daftar user (admin/petugas), relasi level.
-   `create()`
    -   Form tambah user baru.
-   `store(Request $request)`
    -   Simpan user baru (hash password, validasi username).
-   `edit(User $user)`
    -   Form edit user.
-   `update(Request $request, User $user)`
    -   Update user (validasi unik, hash password jika baru).
-   `destroy(User $user)`
    -   Hapus user (tidak bisa hapus diri sendiri, tidak hapus admin terakhir).
-   `show(User $user)`
    -   Redirect ke list user.

#### Catatan:

-   User terdiri dari admin & petugas (level).
-   Fitur keamanan: tidak bisa hapus admin terakhir/diri sendiri.

---

## 8. **PembayaranController**

### Fungsi:

-   `index()`
    -   Daftar pembayaran, relasi tagihan, pelanggan, user.
-   `create()`
    -   Form pembayaran baru (untuk tagihan belum lunas).
-   `store(Request $request)`
    -   Validasi, simpan pembayaran, update status tagihan.
-   `edit(Pembayaran $pembayaran)`
    -   Form edit pembayaran.
-   `update(Request $request, Pembayaran $pembayaran)`
    -   Update pembayaran.
-   `destroy(Pembayaran $pembayaran)`
    -   Hapus pembayaran, status tagihan dikembalikan ke "Belum Dibayar".
-   `show(Pembayaran $pembayaran)`
    -   Redirect ke list pembayaran.

#### Catatan:

-   Setiap pembayaran terkait satu tagihan, satu pelanggan, dan dicatat oleh user (admin/petugas).

---

## 9. **MidtransController**

### Fungsi:

-   `handleNotification(Request $request)`
    -   Endpoint callback dari Midtrans.
    -   Jika transaksi sukses (`settlement`), update status tagihan jadi "Sudah Dibayar".
    -   Jika pembayaran belum tercatat, buat data pembayaran baru (user_id null).
    -   Return HTTP 200 ke Midtrans.

#### Catatan:

-   **Integrasi pembayaran otomatis**: Pelanggan membayar lewat Midtrans, status tagihan dan pembayaran langsung update di database.

---

## **Alur Otentikasi & Role**

-   Admin & Petugas: login via guard `web`, akses penuh ke data.
-   Pelanggan: login via guard `pelanggan`, akses data milik sendiri.
-   Setiap controller dilindungi middleware sesuai peran (lihat routes/web.php).

---

## **Relasi & Alur Utama**

-   **Pelanggan** → punya banyak Tagihan, Penggunaan, Pembayaran.
-   **Tagihan** → dibuat dari Penggunaan, punya satu Pembayaran.
-   **Penggunaan** → dicatat setiap bulan.
-   **Pembayaran** → otomatis update status tagihan.

---

## **Referensi & Sumber**

-   [Kode lengkap controller di repo Anda](https://github.com/Aryo1235/laravel-pembayaran-listrik/tree/main/app/Http/Controllers)
-   [Laravel Resource Controller Docs](https://laravel.com/docs/10.x/controllers#resource-controllers)
-   [Midtrans Docs](https://docs.midtrans.com/)

---

**Dokumentasi ini sudah mencakup seluruh controller utama, penjelasan detail fungsi, alur proses, relasi, dan keamanan aplikasi pembayaran listrik.**
