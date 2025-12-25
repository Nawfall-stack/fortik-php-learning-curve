<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
$p = mysqli_fetch_assoc($result);

if (!$p) {
    die("Produk tidak ditemukan");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambarLama = $_POST['gambarLama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("Format gambar tidak valid");
        }

        if ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
            die("Ukuran gambar terlalu besar");
        }

        $gambar = uniqid() . '.' . $ext;
        $tmp = $_FILES['gambar']['tmp_name'];

        if ($gambarLama && file_exists("../assets/img/" . $gambarLama)) {
            unlink("../assets/img/" . $gambarLama);
        }

        move_uploaded_file($tmp, "../assets/img/" . $gambar);
    }

    mysqli_query($conn, "UPDATE produk SET
        nama='$nama',
        deskripsi='$deskripsi',
        harga='$harga',
        gambar='$gambar'
        WHERE id=$id
    ");

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Container -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="index.php" class="inline-flex items-center text-gray-600 hover:text-indigo-600 mb-4">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Produk
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
                    <p class="text-gray-600 mt-2">Memperbarui informasi produk #<?= $id; ?></p>
                </div>
                <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="bg-white p-3 rounded-lg mr-3">
                            <i class="fas fa-edit text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-bold text-gray-800">Sedang Diedit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto">
            <!-- Success Alert (bisa di-custom jika ada session message) -->
            <div id="successAlert" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="font-medium text-green-800">Produk berhasil diperbarui!</p>
                        <p class="text-sm text-green-600">Produk telah disimpan ke database.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl card-shadow overflow-hidden">
                        <!-- Form Header -->
                        <div class="px-8 py-6 bg-gradient-to-r from-indigo-500 to-purple-600">
                            <div class="flex items-center">
                                <i class="fas fa-edit text-white text-2xl mr-3"></i>
                                <h2 class="text-xl font-semibold text-white">Form Edit Produk</h2>
                            </div>
                            <p class="text-indigo-100 mt-1">Perbarui informasi produk sesuai kebutuhan</p>
                        </div>

                        <!-- Form Content -->
                        <div class="p-8">
                            <form method="post" enctype="multipart/form-data" class="space-y-6" id="editForm">
                                <input type="hidden" name="gambarLama" value="<?= htmlspecialchars($p['gambar']); ?>">

                                <!-- Nama Produk -->
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tag mr-1"></i> Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-cube text-gray-400"></i>
                                        </div>
                                        <input
                                            type="text"
                                            id="nama"
                                            name="nama"
                                            value="<?= htmlspecialchars($p['nama']); ?>"
                                            required
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                            placeholder="Masukkan nama produk"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div>
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-align-left mr-1"></i> Deskripsi Produk
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-3 pointer-events-none">
                                            <i class="fas fa-file-alt text-gray-400"></i>
                                        </div>
                                        <textarea
                                            id="deskripsi"
                                            name="deskripsi"
                                            rows="5"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                            placeholder="Deskripsikan produk secara detail..."><?= htmlspecialchars($p['deskripsi']); ?></textarea>
                                    </div>
                                    <div class="flex justify-between mt-1">
                                        <p class="text-gray-500 text-xs">Opsional. Maksimal 500 karakter.</p>
                                        <p id="charCount" class="text-gray-500 text-xs">0/500</p>
                                    </div>
                                </div>

                                <!-- Harga -->
                                <div>
                                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Harga <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            id="harga"
                                            name="harga"
                                            value="<?= $p['harga']; ?>"
                                            required
                                            min="0"
                                            step="100"
                                            class="pl-12 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                            placeholder="0">
                                    </div>
                                    <p id="hargaFormat" class="text-sm font-medium text-gray-800 mt-2">
                                        Format: Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Image & Actions -->
                <div class="space-y-8">
                    <!-- Image Card -->
                    <div class="bg-white rounded-xl card-shadow overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-800">
                                <i class="fas fa-image mr-2"></i> Gambar Produk
                            </h3>
                        </div>
                        <div class="p-6">
                            <!-- Current Image -->
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-3">Gambar Saat Ini:</p>
                                <div class="relative group">
                                    <img src="../assets/img/<?= htmlspecialchars($p['gambar']); ?>"
                                        id="currentImage"
                                        alt="<?= htmlspecialchars($p['nama']); ?>"
                                        class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm"
                                        onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <a href="../assets/img/<?= htmlspecialchars($p['gambar']); ?>"
                                            target="_blank"
                                            class="text-white bg-black bg-opacity-70 p-2 rounded-full">
                                            <i class="fas fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2 text-center"><?= htmlspecialchars($p['gambar']); ?></p>
                            </div>

                            <!-- Upload New Image -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-3">
                                    Upload Gambar Baru:
                                </label>

                                <!-- File Upload Box -->
                                <div id="fileUploadBox" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition duration-200 cursor-pointer"
                                    onclick="document.getElementById('gambar').click()">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-sm text-gray-600 mb-1">Klik untuk upload gambar baru</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF (maks. 5MB)</p>
                                    <input id="gambar" name="gambar" type="file" class="hidden" form="editForm" onchange="previewNewImage(event)">
                                </div>

                                <!-- New Image Preview -->
                                <div id="newImagePreview" class="mt-4 hidden">
                                    <p class="text-sm text-gray-700 mb-2">Pratinjau Gambar Baru:</p>
                                    <div class="relative">
                                        <img id="newImagePreviewImg" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                        <button type="button" onclick="removeNewImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-blue-700">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Kosongkan jika tidak ingin mengubah gambar
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-xl card-shadow overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-800">
                                <i class="fas fa-cogs mr-2"></i> Aksi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <button
                                    name="submit"
                                    type="submit"
                                    form="editForm"
                                    class="w-full btn-primary text-white px-4 py-3 rounded-lg font-medium hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>

                                <a href="index.php"
                                    class="w-full border border-gray-300 text-gray-700 px-4 py-3 rounded-lg font-medium hover:bg-gray-50 transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-times mr-2"></i> Batal
                                </a>

                                <a href="hapus.php?id=<?= $id; ?>"
                                    onclick="return confirmDelete()"
                                    class="w-full border border-red-300 text-red-700 px-4 py-3 rounded-lg font-medium hover:bg-red-50 transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-trash mr-2"></i> Hapus Produk
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="bg-white rounded-xl card-shadow overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-800">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Produk
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">ID Produk:</span>
                                    <span class="text-sm font-medium text-gray-800">#<?= $id; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tanggal Dibuat:</span>
                                    <span class="text-sm text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Terakhir Diubah:</span>
                                    <span class="text-sm text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Status:</span>
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format harga real-time
        const hargaInput = document.getElementById('harga');
        const hargaFormat = document.getElementById('hargaFormat');

        hargaInput.addEventListener('input', function() {
            const value = this.value.replace(/\D/g, '');
            const formatted = new Intl.NumberFormat('id-ID').format(value);
            hargaFormat.textContent = `Format: Rp ${formatted}`;
        });

        // Character counter for description
        const deskripsiTextarea = document.getElementById('deskripsi');
        const charCount = document.getElementById('charCount');

        deskripsiTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = `${length}/500`;

            if (length > 500) {
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        });

        // Initialize character count
        charCount.textContent = `${deskripsiTextarea.value.length}/500`;

        // Preview new image
        function previewNewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('newImagePreviewImg');
                const imagePreview = document.getElementById('newImagePreview');
                const uploadBox = document.getElementById('fileUploadBox');

                preview.src = reader.result;
                imagePreview.classList.remove('hidden');
                uploadBox.classList.add('hidden');
            };

            if (file) {
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    input.value = '';
                    return;
                }

                reader.readAsDataURL(file);
            }
        }

        // Remove new image
        function removeNewImage() {
            const input = document.getElementById('gambar');
            const imagePreview = document.getElementById('newImagePreview');
            const uploadBox = document.getElementById('fileUploadBox');

            input.value = '';
            imagePreview.classList.add('hidden');
            uploadBox.classList.remove('hidden');
        }

        // Confirm delete
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.');
        }

        // Form validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const harga = document.getElementById('harga').value;

            if (!nama) {
                e.preventDefault();
                alert('Nama produk harus diisi');
                document.getElementById('nama').focus();
                return;
            }

            if (!harga || harga <= 0) {
                e.preventDefault();
                alert('Harga harus lebih dari 0');
                document.getElementById('harga').focus();
                return;
            }

            // Optional: Show loading state
            const submitBtn = document.querySelector('button[name="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Drag and drop for image upload
        const fileUploadBox = document.getElementById('fileUploadBox');
        const fileInput = document.getElementById('gambar');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadBox.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadBox.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadBox.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            fileUploadBox.classList.add('border-indigo-500', 'bg-indigo-50');
        }

        function unhighlight() {
            fileUploadBox.classList.remove('border-indigo-500', 'bg-indigo-50');
        }

        fileUploadBox.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length) {
                fileInput.files = files;
                previewNewImage({
                    target: fileInput
                });
            }
        });
    </script>
</body>

</html>