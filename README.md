# SIArsipSurat - Eksekutif Dashboard (PTPN IV) 📁🚀

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**SIArsipSurat** adalah sistem informasi manajemen arsip digital yang dirancang khusus dengan antarmuka Eksekutif Dashboard yang modern, responsif, dan elegan. Aplikasi ini dikembangkan untuk memudahkan instansi dalam mengelola, melacak, dan menyimpan Surat Masuk, Surat Keluar, serta Dokumen Arsip lainnya secara terpusat dan aman.

> **⚠️ PENTING:** Versi yang berada di repositori ini adalah **Edisi Lite / Portofolio (Demo Mode)**. Beberapa fitur krusial telah dikunci untuk melindungi hak cipta dan mencegah penyalahgunaan.

---

## ✨ Fitur Utama

- **📊 Eksekutif Dashboard**: Ringkasan data statistik surat dan dokumen secara real-time.
- **📥 Manajemen Surat Masuk**: Registrasi, pelacakan, dan penyimpanan arsip surat yang diterima.
- **📤 Manajemen Surat Keluar**: Pencatatan dan pengarsipan surat yang dikirim.
- **📂 Manajemen Dokumen Arsip**: Penyimpanan berkas dan dokumen penting instansi (PDF, Word, Excel, dll).
- **🏷️ Kategori Terstruktur**: Pengelompokan surat dan dokumen berdasarkan kategori yang dapat disesuaikan.
- **👥 Manajemen Pengguna & Hak Akses**: Pembagian peran pengguna (Admin, Operator, dll).
- **📧 Notifikasi Email Otomatis**: Pengiriman pemberitahuan instan via email setiap kali ada aktivitas krusial (seperti perubahan kata sandi akun).
- **⚙️ Pengaturan Sistem**: Konfigurasi profil instansi dan parameter aplikasi.
- **🔒 Demo Mode Protection**: Keamanan tingkat lanjut untuk rilis publik/GitHub.

---

## 🔒 Tentang Demo Mode (Edisi GitHub)

Untuk menjaga lisensi eksklusif, repositori publik ini dilengkapi dengan sistem keamanan yang secara otomatis mengunci fitur-fitur sensitif. Fitur yang **DIKUNCI** pada versi ini meliputi:

1. Unduh Dokumen Lampiran Asli (PDF/Word/Excel/Gambar)
2. Manajemen Pengguna (Tambah/Edit/Hapus Akun)
3. Pengaturan Sistem & Parameter Aplikasi
4. Penambahan, Pembaruan & Penghapusan Arsip (Surat & Dokumen)

Fitur-fitur tersebut hanya bisa diakses pada **Versi Penuh (Pro License)**.

---

## 🚀 Panduan Instalasi (Untuk Localhost)

1. **Clone Repositori**
   ```bash
   git clone https://github.com/username-anda/arsip_surat.git
   cd arsip_surat
   ```

2. **Install Dependensi Composer**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database di dalam file `.env`:
   ```env
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *Opsional: Untuk mengaktifkan fitur Notifikasi Email (seperti perubahan kata sandi), pastikan Anda juga mengatur konfigurasi SMTP (MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD) di dalam file `.env`.*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Seeder Database**
   ```bash
   php artisan migrate --seed
   ```
   *(Pastikan database sudah dibuat di MySQL sebelum menjalankan perintah ini)*

6. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui `http://localhost:8000`

---

## 📞 Dapatkan Versi Penuh (Pro License)

Tertarik untuk menggunakan aplikasi ini secara penuh di instansi atau perusahaan Anda? Dapatkan **Full Source Code (100% Terbuka, Tanpa Enkripsi)** beserta panduan instalasi dan dukungan teknis dari pengembang.

Silakan hubungi kami melalui:

- 💬 **WhatsApp**: [+62 823-8870-2178](https://wa.me/6282388702178)
- 📧 **Email**: [zulkiflioccez@gmail.com](mailto:zulkiflioccez@gmail.com)

---

<p align="center">
  Dibuat dengan ❤️ untuk efisiensi administrasi yang lebih baik.
</p>
