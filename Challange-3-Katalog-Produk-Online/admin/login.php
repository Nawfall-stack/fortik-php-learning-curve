<?php
session_start();
require '../config/database.php';

$error = '';
if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = md5($_POST['password']);

    $result = mysqli_query($conn,
      "SELECT * FROM admin WHERE username='$user' AND password='$pass'");

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = 'Username atau password salah';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-600 mt-2">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="login-card rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    <?php if($error): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-700"><?php echo $error; ?></span>
                    </div>
                    <?php endif; ?>

                    <form method="post" class="space-y-6">
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Username
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input 
                                    type="text" 
                                    id="username" 
                                    name="username" 
                                    required 
                                    placeholder="Masukkan username"
                                    class="input-focus w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 transition duration-200"
                                >
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-key mr-2"></i>Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required 
                                    placeholder="Masukkan password"
                                    class="input-focus w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 transition duration-200"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            name="login"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-200 transform hover:-translate-y-0.5"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </button>
                    </form>

                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Akses terbatas untuk admin terotorisasi
                        </p>
                    </div>
                </div>
            </div>

            <!-- Demo Credentials (Hapus di production) -->
            <div class="mt-6 p-4 bg-white/50 backdrop-blur-sm rounded-lg border border-gray-200">
                <p class="text-sm text-gray-700 font-medium mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Demo Credentials:
                </p>
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 w-4"></i>
                        <span>Username: <code class="bg-gray-100 px-2 py-1 rounded">admin</code></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-key mr-2 w-4"></i>
                        <span>Password: <code class="bg-gray-100 px-2 py-1 rounded">admin123</code></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!username || !password) {
                e.preventDefault();
                alert('Harap isi semua field yang diperlukan');
            }
        });
    </script>
</body>
</html>