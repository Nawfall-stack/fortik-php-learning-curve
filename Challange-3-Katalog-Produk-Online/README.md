# Sistem Manajemen Produk - Panduan Pengguna

Website ini adalah **aplikasi manajemen produk sederhana** yang memiliki **Halaman Depan (User)** untuk melihat dan mencari produk.

---

## 🌐 Cara Menggunakan Website sebagai Pengguna

### 1️⃣ Instalasi Awal

1. **Clone atau salin folder project** ke dalam folder `htdocs` di XAMPP/WAMP/Laragon:
   ```
   htdocs/manajemen-produk/
   ```

2. **Buka phpMyAdmin** di browser:
   ```
   http://localhost/phpmyadmin
   ```

3. **Buat database baru** dengan nama:
   ```
   db_produk
   ```

4. **Import file database**:
   - Klik database `db_produk`
   - Pilih tab "Import"
   - Klik "Choose File" dan pilih file `produk.sql` dari folder project
   - Klik "Go" untuk mengimport

### 2️⃣ Akses Halaman Website

Buka browser dan ketik:
```
http://localhost/manajemen-produk/
```

Atau sesuaikan dengan nama folder yang Anda gunakan.

---

## 🔍 Fitur yang Tersedia untuk Pengguna

### 📋 Melihat Daftar Produk
- Saat membuka halaman utama, Anda akan melihat semua produk yang tersedia
- Setiap produk menampilkan:
  - Gambar produk
  - Nama produk
  - Harga
  - Deskripsi singkat

### 🔎 Mencari Produk
1. Temukan **kotak pencarian** di bagian atas halaman
2. Ketik **nama produk** yang ingin dicari
   Contoh: "Laptop", "Mouse", "Keyboard"
3. Hasil pencarian akan langsung muncul secara otomatis

### 📱 Tampilan Responsif
- Website dapat diakses dari berbagai perangkat:
  - Komputer/Laptop
  - Tablet
  - Smartphone

---

## 💡 Tips Penggunaan

- **Pencarian bersifat real-time** - tidak perlu menekan tombol enter
- **Pencarian berdasarkan nama produk** - gunakan kata kunci yang spesifik untuk hasil lebih akurat
- Jika tidak menemukan produk yang dicari, coba kata kunci yang lebih umum
- Untuk melihat semua produk kembali, kosongkan kotak pencarian

---

## ❓ Pertanyaan Umum

**Q: Kenapa produk tidak muncul?**
A: Pastikan database sudah diimport dengan benar dan file `produk.sql` berisi data produk.

**Q: Kenapa gambar tidak tampil?**
A: Pastikan folder `assets/img/` ada dan berisi file gambar yang sesuai.

**Q: Bisa lihat kode sumber?**
A: Ya, website ini open source untuk keperluan pembelajaran.

---

## 📞 Bantuan

Jika mengalami masalah:
1. Pastikan XAMPP/WAMP/Laragon sedang berjalan
2. Database sudah dibuat dan diimport
3. Folder project berada di dalam `htdocs`

---

## ✨ Tentang Website

Website ini cocok untuk:
- Melihat katalog produk toko
- Belajar tentang PHP dan MySQL dasar
- Contoh implementasi sistem pencarian sederhana

Website dibuat dengan:
- PHP Native
- MySQL Database
- Tailwind CSS untuk desain
- JavaScript untuk interaksi

---

Selamat menggunakan website manajemen produk! 🚀
