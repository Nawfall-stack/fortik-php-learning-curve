
# Challenge 1: Data Mahasiswa

Penilaian dan masukan terkait tugas


## Penilaian

1. **Clean Code & Separation of Concerns (Nilai: 4/10)**
Prinsip utama Clean Code adalah Separation of Concerns (SoC). Kode kamu melanggar ini dengan keras.

- Masalah Utama: Kamu mencampuradukkan Data/Logic (PHP Array), Structure (HTML), dan Styling (CSS) dalam satu file. Ini disebut Spaghetti Code.

- Dampaknya: Jika atasanmu minta data ini dipakai di halaman lain, kamu harus copy-paste array-nya. Jika datanya berubah, kamu harus edit di dua tempat. Itu sumber bug.

- Logic di View: Mendefinisikan variable `$mahasiswa` di dalam `<body>` adalah praktik yang buruk. Logic/Data harus disiapkan sebelum HTML dirender, idealnya di bagian paling atas file atau di file terpisah.

2. **Best Practice & Standar HTML (Nilai: 5/10)**
Ada beberapa standar industri yang terlewat:

- Semantic HTML: Tabel kamu tidak memiliki `<thead>` dan `<tbody>`. Browser modern memang akan memperbaikinya secara otomatis saat rendering, tapi secara kode, itu tidak valid dan menyulitkan pembaca layar (screen readers) atau parsing JavaScript nantinya.

- Accessibility (A11y): Tag `alt=""` pada gambar kosong. Ini dosa besar dalam web development. alt harus diisi, minimal dengan nama mahasiswa, agar jika gambar gagal load atau user tunanetra mengakses, mereka tahu itu gambar apa.

- Internal CSS: Menggunakan `<style>` di head boleh untuk prototipe cepat. Tapi untuk production, biasakan extract ke file .css terpisah agar browser bisa melakukan caching.

3. **Efektivitas & Performa (Nilai: 6/10)**
- Hardcoded Data: Array `$mahasiswa` di-hardcode. Ini tidak efektif. Dalam dunia nyata, data ini diambil dari Database (MySQL). Strukturmu saat ini tidak siap untuk dikoneksikan ke database tanpa merombak total struktur filenya. *(ini hanya masukan dari gemini)*

- Looping: Penggunaan foreach sudah benar dan sintaks alternative syntax `(: ... endforeach;)` yang kamu pakai sudah tepat untuk templating. Ini satu-satunya poin plus yang solid di sini.


## Feedback

Kalau ada pertanyaan atau masukan, silakan ditanyakan di grup whatsapp.

