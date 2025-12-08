# Challenge 2: Buku Tamu Digital

Penilaian dan masukan terkait tugas


## Penilaian

1. **FATAL FLAW: Keamanan (SQL Injection & Sanitasi)**
Kamu melakukan kesalahan fatal dalam memahami keamanan database.

- **Kesalahan**: Di fungsi `tambah()`, kamu menggunakan `htmlspecialchars()` untuk membersihkan input sebelum masuk database.

    - **Why it's bad**: htmlspecialchars itu fungsi untuk mencegah XSS (Cross Site Scripting) saat output ke HTML, BUKAN untuk mencegah SQL Injection.

    - **Risk**: Jika input nama berisi karakter ' (kutip satu), query SQL kamu akan pecah (Syntax Error) atau bisa dimanipulasi peretas.

    - **Bad Data**: Kamu menyimpan data "sampah" di database. Jika nama saya O'Neil, kamu menyimpannya sebagai O&#039;Neil. Database harus menyimpan data MURNI/RAW. Sanitasi dilakukan saat data itu ditampilkan (Output), bukan saat disimpan (Input).

- **Solusi**: Gunakan Prepared Statements (PDO atau MySQLi prepare). Jangan pernah menyisipkan variabel langsung ke dalam string SQL `(VALUES ('$nama'...)` .

2. **Isu Arsitektur: "Spaghetti Code"**
Kamu mencampur logika database, logika bisnis, dan tampilan (HTML/CSS) dalam satu file.

- **Masalah**: Untuk proyek kecil seperti ini, mungkin bisa dimaafkan. Tapi kebiasaan ini membuat kode sulit dikembangkan. Jika kamu ingin mengubah desain tabel, kamu harus mengaduk-aduk logika PHP.

- **Variable Scope**: Penggunaan `global $conn` di dalam fungsi adalah bad practice. Ini membuat fungsi kamu bergantung erat pada variabel global di luar, membuatnya sulit di-test dan rawan konflik nama variabel.

3. **Kelemahan HTTP Method (GET vs POST)**
- **Masalah**: Pada fitur hapus, kamu menggunakan method `GET (?id=1&action=delete)`.

- **Risiko**:

    - Mesin pencari (Googlebot) atau plugin browser bisa tidak sengaja "mengunjungi" link tersebut dan menghapus datamu.

    - Serangan CSRF (Cross-Site Request Forgery) sangat mudah dilakukan. Orang bisa membuat link palsu yang jika kamu klik, datamu terhapus.

- **Best Practice**: Aksi yang mengubah data (Insert, Update, Delete) harus selalu menggunakan method POST atau DELETE.


## Feedback

Kalau ada pertanyaan atau masukan, silakan ditanyakan di grup whatsapp.

