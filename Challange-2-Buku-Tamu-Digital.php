<?php
$conn = mysqli_connect("localhost", "root", "", "tamu");

// functions
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $message = htmlspecialchars($data["message"]);

    $query = "INSERT INTO datatamu (nama, email, message) 
              VALUES ('$nama', '$email', '$message')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    // Validasi: pastikan ID numeric
    if (!is_numeric($id)) {
        return 0;
    }

    // Escape untuk keamanan
    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM datatamu WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

$tamu = query('SELECT * FROM datatamu');

if (isset($_POST["submit"])) {
    if (tambah($_POST) > 0) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $pesan_tambah = "gagal ditambah";
    }
}

// hapus data
if (isset($_GET["id"]) && isset($_GET["action"]) && $_GET["action"] == "delete") {
    $id = $_GET["id"];
    if (hapus($id) > 0) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $pesan_hapus = "gagal dihapus";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background: #ffffff;
            padding: 20px;
            max-width: 450px;
            margin: 0 auto 30px auto;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .wrapper {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        input,
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color .2s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #4c84ff;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 132, 255, 0.3);
        }

        button {
            padding: 12px;
            width: 100%;
            border: none;
            background: #4c84ff;
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background .2s;
        }

        button:hover {
            background: #2c6bff;
        }

        .dashboard {
            max-width: 900px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: #4c84ff;
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f7f9fc;
        }

        tr:hover {
            background: #eef3ff;
        }

        .nomor {
            width: 40px;
            text-align: center;
            font-weight: bold;
        }

        .delete svg {
            cursor: pointer;
            transition: 0.2s;
        }

        .delete svg:hover {
            transform: scale(1.1);
            opacity: 0.8;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="" method="post">
        <h1>BUKU TAMU DIGITAL</h1>
        <div class="wrapper">
            <label for="nama">Nama :</label>
            <input type="text" name="nama" id="nama" required>
        </div>
        <div class="wrapper">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="wrapper">
            <label for="message">Pesan</label>
            <textarea name="message" id="message" required></textarea>
        </div>
        <button type="submit" name="submit">submit</button>
    </form>

    <div class="dashboard">
        <table>
            <tr>
                <th>no</th>
                <th>nama</th>
                <th>email</th>
                <th>pesan</th>
                <th></th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($tamu as $row): ?>
                <tr>
                    <td class="nomor"><?= $i; ?></td>
                    <td class="nama"><?= htmlspecialchars($row["nama"]); ?></td>
                    <td class="email"><?= htmlspecialchars($row["email"]); ?></td>
                    <td class="message"><?= htmlspecialchars($row["message"]); ?></td>
                    <td class="delete">
                        <a href="?id=<?= $row["id"]; ?>&action=delete"
                            onclick="return confirmDelete(<?= $row['id']; ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="24" height="24">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "?id=" + id + "&action=delete";
            }
        });

        return false;
    }
</script>

</body>

</html>