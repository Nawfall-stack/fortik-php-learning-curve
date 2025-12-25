# Sistem Manajemen Produk

Website ini adalah **aplikasi manajemen produk berbasis PHP & MySQL** yang memiliki halaman **Admin (CRUD Produk)** dan **Halaman Depan (User)** dengan fitur pencarian produk.

README ini menjelaskan **cara instalasi, penggunaan, dan struktur website** agar dapat digunakan dengan benar.

---

## 🚀 Fitur Utama

### 🔐 Halaman Admin (Wajib Login)

* Login Admin
* Tambah Produk
* Edit Produk
* Hapus Produk
* Upload Gambar Produk

Setiap produk memiliki:

* Nama Produk
* Deskripsi
* Harga
* Gambar (upload file)

### 🛒 Halaman User (Publik)

* Melihat daftar produk
* Mencari produk berdasarkan **nama**

---

## 🧰 Teknologi yang Digunakan

* **PHP Native**
* **MySQL / MariaDB**
* **Tailwind CSS** (UI)
* **JavaScript** (UX)
* **Font Awesome** (Icon)

---

## 📁 Struktur Folder

```
/project-root
│
├── admin/
│   ├── index.php        # Dashboard admin (list produk)
│   ├── tambah.php       # Tambah produk
│   ├── edit.php         # Edit produk
│   ├── hapus.php        # Hapus produk
│   └── login.php        # Login admin
│
├── assets/
│   └── img/             # Folder gambar produk
│
├── config/
│   └── database.php     # Koneksi database
│
├── index.php            # Halaman depan (user)
└── README.md
```

---

## ⚙️ Instalasi

### 1️⃣ Clone Project

Clone repository atau salin folder project, lalu letakkan ke dalam:

```
htdocs/
```

Contoh:

```
htdocs/project-produk
```

---

### 2️⃣ Import Database

1. Buka **phpMyAdmin**
2. Buat database baru (bebas), contoh:

   ```
   db_produk
   ```
3. Import file database:

   ```
   produk.sql
   ```

> File `produk.sql` sudah berisi struktur dan data awal.

---

### 3️⃣ Import Database

1. Buka **phpMyAdmin**
2. Buat database, misalnya:

   ```
   db_produk
   ```
3. Import file SQL (contoh struktur):

```sql
CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  deskripsi TEXT,
  harga INT NOT NULL,
  gambar VARCHAR(255) NOT NULL
);
```

---

### 4️⃣ Konfigurasi Koneksi Database

Edit file:

```
/config/database.php
```

Contoh:

```php
<?php
$conn = mysqli_connect("localhost", "root", "", "db_produk");
if (!$conn) {
    die("Koneksi database gagal");
}
```

---

## 🔑 Login Admin

Akses halaman admin melalui:

```
http://localhost/project-root/admin/login.php
```

> Login menggunakan akun admin yang telah dibuat (sesuai implementasi login).

---

## 🧑‍💻 Cara Menggunakan (Admin)

### ➕ Menambah Produk

1. Login sebagai admin
2. Masuk ke Dashboard Admin
3. Klik **Tambah Produk**
4. Isi nama, deskripsi, harga, dan upload gambar
5. Klik **Simpan**

---

### ✏️ Mengedit Produk

1. Masuk ke Dashboard Admin
2. Klik tombol **Edit** pada produk
3. Ubah data yang diinginkan
4. (Opsional) Upload gambar baru
5. Klik **Simpan Perubahan**

> Jika gambar tidak diupload, gambar lama tetap digunakan.

---

### 🗑️ Menghapus Produk

1. Klik tombol **Hapus Produk**
2. Konfirmasi penghapusan

⚠️ Data produk dan gambar akan dihapus permanen.

---

## 👀 Cara Menggunakan (User)

1. Akses halaman utama:

   ```
   http://localhost/project-root/index.php
   ```
2. Lihat daftar produk
3. Gunakan kolom **Search** untuk mencari produk berdasarkan nama

---

## 🛡️ Keamanan Dasar

* Halaman admin dilindungi oleh **session login**
* Validasi upload gambar:

  * Maksimal 5MB
  * Ekstensi: JPG, PNG, GIF
* ID produk divalidasi untuk mencegah SQL Injection

---

## 📌 Catatan Penting

* Pastikan folder `assets/img/` memiliki permission **write**
* Jangan menghapus file gambar langsung dari folder tanpa menghapus data produk
* Selalu logout setelah selesai menggunakan halaman admin

---

## 📄 Lisensi

Project ini dibuat untuk **pembelajaran dan tugas**.
Bebas digunakan dan dimodifikasi.

---

## ✨ Penutup

Website ini dibuat sebagai **sistem manajemen produk sederhana** namun lengkap, cocok untuk:

* Tugas kuliah
* Latihan CRUD PHP
* Dasar project e-commerce

Jika ingin dikembangkan lebih lanjut:

* Pagination
* Multi user
* Role admin
* MVC Framework

Semoga bermanfaat 🚀
