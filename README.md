# 🎓 Sistem Pengajuan MBKM

Sistem Pengajuan MBKM adalah aplikasi berbasis web yang dirancang untuk mempermudah proses pengajuan dan manajemen program **Merdeka Belajar Kampus Merdeka (MBKM)** di lingkungan perguruan tinggi. Sistem ini mendukung kolaborasi antara mahasiswa, dosen pembimbing, kaprodi, dan pihak kampus.

---

## 🚀 Fitur Utama

- ✅ **Autentikasi & Hak Akses**
  - Login multi-role: Mahasiswa, Dosen Pembimbing, Kaprodi, Admin
- 📄 **Pengajuan Program MBKM**
  - Mahasiswa dapat mengisi dan mengirimkan pengajuan
  - Upload dokumen pendukung
- 🔄 **Verifikasi Berjenjang**
  - Verifikasi oleh dosen pembimbing
  - Validasi oleh kaprodi
- 📊 **Monitoring Status**
  - Lacak status pengajuan secara real-time
- 📁 **Export Laporan**
  - Unduh data dalam format PDF atau Excel

---

## 🛠️ Teknologi yang Digunakan

| Teknologi         | Keterangan                          |
|------------------|-------------------------------------|
| PHP              | Backend utama                       |
| MySQL            | Database relasional                 |
| HTML, CSS, JS    | Tampilan antarmuka                  |
| Bootstrap        | Framework frontend responsif        |
| XAMPP            | Server lokal untuk pengembangan     |
| Git & GitHub     | Manajemen versi kode                |

---

## 📦 Instalasi Lokal

### 1. Clone Repository
```bash
git clone https://github.com/Freganovic/mbkm-update.git




### 2. Pindah ke direktori project
cd mbkm-update

### 3. import database
Jalankan XAMPP dan aktifkan Apache dan MySQL.

Akses phpMyAdmin melalui browser:

http://localhost/phpmyadmin

Buat database baru, contoh: mbkm

Import file .sql dari folder database/ atau file backup yang tersedia.

Klik Go untuk menyelesaikan proses.

### 4. jalankan di browser
Letakkan folder di dalam direktori htdocs (jika belum), lalu akses:

http://localhost/mbkm-update

Jika konfigurasi database memerlukan penyesuaian, ubah file seperti config.php atau .env sesuai dengan pengaturan lokal Anda.

### 1. Clone Repository

🔑 Login Demo
Role	Username	Password
Mahasiswa	mahasiswa1	123456
Dosen	dosen1	123456
Kaprodi	kaprodi1	123456
Admin	admin	admin

    🔒 Gantilah kredensial default untuk keamanan pada mode produksi.

🧑‍💻 Kontributor

    🧠 Fadli Ramadan (Tuan Muda) – Developer & Analyst

    💼 Dosen Pembimbing – Supervisor MBKM

    🏛️ [Nama Kampus Anda] – Institusi Pendukung

📃 Lisensi

Proyek ini dilisensikan di bawah MIT License.
☕ Dukungan

Jika Anda merasa proyek ini bermanfaat, silakan beri ⭐ di GitHub, atau hubungi kami untuk kolaborasi lebih lanjut.
📬 Kontak

📧 Email: fadli.tuanmuda@example.com
🌐 Website: mbkm.tuanmuda.dev (jika tersedia)
