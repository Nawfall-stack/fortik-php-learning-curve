<?php
require 'config/database.php';

$keyword = "";
$produk = [];

if (isset($_GET['search']) && !empty(trim($_GET['keyword']))) {
    $keyword = mysqli_real_escape_string($conn, trim($_GET['keyword']));
    $result = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$keyword%'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM produk");
}

// Convert result to array for easier handling
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
}

// Check if no results found
$hasResults = !empty($produk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pencarian Produk</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .search-highlight {
            background-color: #fef3c7;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Sistem Pencarian Produk</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan produk terbaik dengan sistem pencarian yang cepat dan efisien</p>
        </header>

        <!-- Search Form -->
        <div class="max-w-3xl mx-auto mb-12">
            <form method="get" class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="keyword" 
                                value="<?= htmlspecialchars($keyword) ?>"
                                placeholder="Ketik nama produk yang ingin dicari..." 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                autocomplete="off"
                            >
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button 
                            name="search" 
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-search"></i>
                            <span>Cari Produk</span>
                        </button>
                        <a 
                            href="?" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-redo"></i>
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
                
                <?php if (!empty($keyword)): ?>
                    <div class="mt-4 text-sm text-gray-600">
                        <p>Menampilkan hasil pencarian untuk: <span class="font-semibold text-gray-800">"<?= htmlspecialchars($keyword) ?>"</span></p>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Results Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <?php if (!empty($keyword)): ?>
                        Hasil Pencarian
                    <?php else: ?>
                        Daftar Produk
                    <?php endif; ?>
                </h2>
                
                <div class="text-gray-600">
                    <span class="font-medium"><?= count($produk) ?></span> produk ditemukan
                </div>
            </div>

            <?php if ($hasResults): ?>
                <!-- Product Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($produk as $p): 
                        // Highlight search term in product name
                        $highlighted_nama = $keyword ? preg_replace(
                            "/(" . preg_quote($keyword, '/') . ")/i", 
                            '<span class="search-highlight">$1</span>', 
                            htmlspecialchars($p['nama'])
                        ) : htmlspecialchars($p['nama']);
                    ?>
                        <div class="product-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg">
                            <!-- Product Image -->
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                <?php if (!empty($p['gambar']) && file_exists("assets/img/{$p['gambar']}")): ?>
                                    <img 
                                        src="assets/img/<?= htmlspecialchars($p['gambar']) ?>" 
                                        alt="<?= htmlspecialchars($p['nama']) ?>" 
                                        class="w-full h-full object-cover transition duration-500 hover:scale-105"
                                    >
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Price Tag -->
                                <div class="absolute top-4 right-4 bg-blue-600 text-white font-bold py-1 px-3 rounded-lg shadow">
                                    Rp<?= number_format($p['harga'], 0, ',', '.') ?>
                                </div>
                            </div>
                            
                            <!-- Product Details -->
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <?= $highlighted_nama ?>
                                </h3>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    <?= nl2br(htmlspecialchars($p['deskripsi'])) ?>
                                </p>
                                
                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-tag mr-1"></i> Kode: <?= htmlspecialchars($p['kode'] ?? 'PRD-001') ?>
                                    </span>
                                    <button class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-2 px-4 rounded-lg transition duration-300 text-sm">
                                        <i class="fas fa-cart-plus mr-1"></i> Tambahkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- No Results Message -->
                <div class="bg-white rounded-xl shadow p-10 text-center">
                    <div class="mb-6">
                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">
                            <?php if (!empty($keyword)): ?>
                                Produk tidak ditemukan
                            <?php else: ?>
                                Tidak ada produk tersedia
                            <?php endif; ?>
                        </h3>
                        <p class="text-gray-600 max-w-md mx-auto mb-6">
                            <?php if (!empty($keyword)): ?>
                                Tidak ada produk yang cocok dengan pencarian "<span class="font-semibold"><?= htmlspecialchars($keyword) ?></span>". Coba kata kunci lain atau lihat semua produk.
                            <?php else: ?>
                                Belum ada produk yang tersedia di sistem.
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <?php if (!empty($keyword)): ?>
                        <a 
                            href="?" 
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300"
                        >
                            <i class="fas fa-list mr-2"></i> Lihat Semua Produk
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <footer class="mt-12 pt-8 border-t border-gray-200 text-center text-gray-600 text-sm">
            <p>Sistem Pencarian Produk &copy; <?= date('Y') ?> - Dibuat dengan <i class="fas fa-heart text-red-500"></i></p>
            <p class="mt-1">Total produk dalam database: <span class="font-medium"><?= count($produk) ?></span></p>
        </footer>
    </div>

    <!-- JavaScript untuk konfirmasi reset -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format harga di semua elemen dengan kelas 'harga'
            document.querySelectorAll('.harga').forEach(function(el) {
                const harga = parseInt(el.textContent.replace(/[^0-9]/g, ''));
                if (!isNaN(harga)) {
                    el.textContent = 'Rp' + harga.toLocaleString('id-ID');
                }
            });
            
            // Konfirmasi reset pencarian
            const resetBtn = document.querySelector('a[href="?"]');
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    if (window.location.search.includes('keyword') || window.location.search.includes('search')) {
                        if (!confirm('Yakin ingin mereset pencarian?')) {
                            e.preventDefault();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>