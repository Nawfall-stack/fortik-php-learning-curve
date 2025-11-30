<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Mahasiswa</title>
    <style>
        .wrapper {
            border-radius: 1rem;
            border: 1px solid black;
            padding: 2rem;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }

        img {
            width: 50px;
        }

        th,
        td {
            text-align: center;
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: #D6EEEE;
        }
    </style>
</head>

<body>
    <?php
    $mahasiswa = [
        [
            "nama" => "Anisa Noventi",
            "nim" => "052648461",
            "jurusan" => "Statistika",
            "email" => "anisa.noventi@example.com",
            "gambar" => "mahasiswa1.jpg"
        ],
        [
            "nama" => "Budi Cahyo Pratama",
            "nim" => "051239004",
            "jurusan" => "Informatika",
            "email" => "budicpratama@example.com",
            "gambar" => "mahasiswa2.jpg"
        ],
        [
            "nama" => "Citra Adelia",
            "nim" => "053771220",
            "jurusan" => "Sistem Informasi",
            "email" => "citradelia@example.com",
            "gambar" => "mahasiswa3.jpg"
        ],
        [
            "nama" => "Dika Aryansyah",
            "nim" => "052512783",
            "jurusan" => "Teknik Industri",
            "email" => "dika.aryansyah@example.com",
            "gambar" => "mahasiswa4.jpg"
        ],
        [
            "nama" => "Farah Meilani",
            "nim" => "052140907",
            "jurusan" => "Matematika Terapan",
            "email" => "farah.meilani@example.com",
            "gambar" => "mahasiswa5.jpg"
        ]
    ];
    ?>
    <div class="wrapper">

        <table>

            <tr>
                <th></th>
                <th>Nama</th>
                <th>Nim </th>
                <th>Jurusan</th>
                <th>Email</th>
            </tr>
            <?php foreach ($mahasiswa as $m): ?>
                <tr>
                    <td><img src="./assets/<?= $m["gambar"] ?>" alt=""></td>
                    <td><?= $m["nama"] ?></td>
                    <td><?= $m["nim"] ?></td>
                    <td><?= $m["jurusan"] ?></td>
                    <td><?= $m["email"] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>