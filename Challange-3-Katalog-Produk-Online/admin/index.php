<?php
session_start();
require '../config/database.php';
if (!isset($_SESSION['login'])) header("Location: login.php");

$data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .card-hover {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Container -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>
                <p class="text-gray-600 mt-2">Kelola semua produk di toko Anda</p>
            </div>

            <!-- Add Product Button -->
            <a href="tambah.php"
                class="btn-primary text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Produk Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <?php
        $total_produk = mysqli_num_rows($data);
        mysqli_data_seek($data, 0); // Reset pointer untuk membaca ulang data
        ?>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $total_produk; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tersedia</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $total_produk; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-tags text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Kategori</p>
                        <p class="text-2xl font-bold text-gray-800">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Penjualan</p>
                        <p class="text-2xl font-bold text-gray-800">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Semua Produk</h2>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text"
                                placeholder="Cari produk..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-cube mr-2"></i> Produk
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2"></i> Harga
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-image mr-2"></i> Gambar
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-2"></i> Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (mysqli_num_rows($data) > 0): ?>
                            <?php while ($p = mysqli_fetch_assoc($data)) : ?>
                                <tr class="table-row-hover transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-box text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($p['nama']); ?></div>
                                                <div class="text-xs text-gray-500 truncate max-w-xs"><?= htmlspecialchars(substr($p['deskripsi'], 0, 60)) . (strlen($p['deskripsi']) > 60 ? '...' : ''); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></div>
                                        <div class="text-xs text-gray-500">ID: <?= $p['id']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="relative group">
                                            <img src="../assets/img/<?= htmlspecialchars($p['gambar']); ?>"
                                                alt="<?= htmlspecialchars($p['nama']); ?>"
                                                class="h-16 w-16 object-cover rounded-lg border border-gray-200 shadow-sm"
                                                onerror="this.src='https://via.placeholder.com/100?text=No+Image'">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                                <a href="../assets/img/<?= htmlspecialchars($p['gambar']); ?>"
                                                    target="_blank"
                                                    class="text-white text-sm">
                                                    <i class="fas fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="edit.php?id=<?= $p['id']; ?>"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $p['id']; ?>"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-box-open text-4xl mb-4 text-gray-300"></i>
                                        <p class="text-lg font-medium mb-2">Belum ada produk</p>
                                        <p class="text-sm mb-6">Tambahkan produk pertama Anda dengan mengklik tombol "Tambah Produk Baru"</p>
                                        <a href="tambah.php" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                                            <i class="fas fa-plus mr-2"></i> Tambah Produk Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?= $total_produk; ?></span> produk
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50 disabled:opacity-50" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <i class="fas fa-lightbulb text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-blue-800">Tips Manajemen Produk</h3>
                    <div class="mt-2 text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Gunakan gambar produk dengan resolusi yang jelas untuk menarik perhatian pelanggan</li>
                            <li>Perbarui harga secara berkala untuk tetap kompetitif di pasar</li>
                            <li>Pastikan deskripsi produk informatif dan menarik</li>
                            <li>Hapus produk yang sudah tidak tersedia atau tidak lagi dijual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for additional functionality -->
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Search functionality
        document.querySelector('input[type="text"]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const productName = row.querySelector('.text-gray-900').textContent.toLowerCase();
                const productDesc = row.querySelector('.text-gray-500').textContent.toLowerCase();

                if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Confirm delete with sweet alert style
        // SweetAlert untuk notifikasi
        <?php if (isset($_SESSION['alert'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['alert']['type']; ?>',
                title: '<?php echo $_SESSION['alert']['title']; ?>',
                text: '<?php echo $_SESSION['alert']['message']; ?>',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        // SweetAlert untuk konfirmasi hapus
        document.querySelectorAll('a[href*="hapus.php"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('href');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('animate__animated', 'animate__fadeInUp');
            });
        });
    </script>
</body>

</html>