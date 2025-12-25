<?php
session_start();
require '../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Ambil nama file gambar terlebih dahulu untuk dihapus dari server
    $query = mysqli_query($conn, "SELECT gambar FROM produk WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    $gambar = $data['gambar'];
    
    // Hapus data dari database
    $delete_query = mysqli_query($conn, "DELETE FROM produk WHERE id = '$id'");
    
    if ($delete_query) {
        // Hapus file gambar jika ada (kecuali gambar default)
        if (!empty($gambar) && $gambar != 'default.jpg') {
            $file_path = "../assets/img/" . $gambar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Simpan pesan sukses di session untuk SweetAlert
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Sukses!',
            'message' => 'Produk berhasil dihapus.'
        ];
    } else {
        // Simpan pesan error di session
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Gagal!',
            'message' => 'Terjadi kesalahan saat menghapus produk: ' . mysqli_error($conn)
        ];
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Error!',
        'message' => 'ID produk tidak valid.'
    ];
}

// Redirect kembali ke halaman utama
header("Location: index.php");
exit();
?>