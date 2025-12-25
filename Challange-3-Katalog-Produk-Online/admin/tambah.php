<?php
session_start();
require '../config/database.php';
if (!isset($_SESSION['login'])) header("Location: login.php");

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "../assets/img/".$gambar);

    mysqli_query($conn, "INSERT INTO produk VALUES (
      NULL, '$nama', '$deskripsi', '$harga', '$gambar')");
    
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Container -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
            <p class="text-gray-600 mt-2">Isi form di bawah untuk menambahkan produk baru ke katalog</p>
        </div>
        
        <!-- Form Container -->
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-500 to-purple-600">
                <div class="flex items-center">
                    <i class="fas fa-box text-white text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold text-white">Informasi Produk</h2>
                </div>
                <p class="text-indigo-100 mt-1">Pastikan data yang diisi sudah benar</p>
            </div>
            
            <!-- Form Content -->
            <div class="p-8">
                <form method="post" enctype="multipart/form-data" class="space-y-6">
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
                                required
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                placeholder="Masukkan nama produk"
                                autocomplete="off"
                            >
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
                                rows="4"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                placeholder="Deskripsikan produk secara detail..."
                            ></textarea>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Opsional. Maksimal 500 karakter.</p>
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
                                required
                                min="0"
                                step="100"
                                class="pl-12 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 form-input"
                                placeholder="0"
                            >
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div>
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-image mr-1"></i> Gambar Produk <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- File Upload Box -->
                        <div id="file-upload-box" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition duration-200">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mx-auto"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="gambar" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Unggah file</span>
                                        <input id="gambar" name="gambar" type="file" class="sr-only" required onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 5MB</p>
                                <p id="file-name" class="text-sm text-gray-900 font-medium mt-2"></p>
                            </div>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="image-preview" class="mt-4 hidden">
                            <p class="text-sm text-gray-700 mb-2">Pratinjau Gambar:</p>
                            <div class="relative w-48 h-48 border border-gray-300 rounded-lg overflow-hidden">
                                <img id="preview" class="w-full h-full object-cover" src="" alt="Preview">
                                <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end pt-6 space-x-4 border-t border-gray-200">
                        <a href="index.php" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button 
                            name="submit" 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg"
                        >
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Info Box -->
        <div class="max-w-3xl mx-auto mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tips</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Pastikan gambar produk memiliki resolusi yang baik</li>
                            <li>Harga yang dimasukkan adalah harga dalam satuan Rupiah</li>
                            <li>Produk akan langsung muncul di katalog setelah ditambahkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk preview gambar
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const imagePreview = document.getElementById('image-preview');
                const fileName = document.getElementById('file-name');
                
                preview.src = reader.result;
                imagePreview.classList.remove('hidden');
                fileName.textContent = file.name;
            };
            
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        
        // Fungsi untuk menghapus gambar yang sudah dipilih
        function removeImage() {
            const input = document.getElementById('gambar');
            const imagePreview = document.getElementById('image-preview');
            const fileName = document.getElementById('file-name');
            
            input.value = '';
            imagePreview.classList.add('hidden');
            fileName.textContent = '';
        }
        
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const harga = document.getElementById('harga').value;
            
            if (harga <= 0) {
                e.preventDefault();
                alert('Harga harus lebih dari 0');
                document.getElementById('harga').focus();
            }
        });
    </script>
</body>
</html>