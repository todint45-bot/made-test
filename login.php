<?php
// login.php

// Sertakan file konfigurasi untuk sesi dan data user
// PASTIKAN FILE config.php ADA DI FOLDER YANG SAMA
include_once 'config.php'; 

// Jika pengguna sudah login, langsung alihkan ke dashboard.php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

$self_file = 'login.php'; 
$nama_rs = "Rumah Sakit";
$login_message = '';
$is_login_successful = false;

// Kredensial Demo
$demo_username = 'admin';
$demo_password = 'admin123'; 

// 1. Logika Pemrosesan Login (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Cek di simulasi database user (dari config.php)
    if (isset($_SESSION['users'][$username]) && $_SESSION['users'][$username]['password'] === $password) {
        
        // **LOGIKA PENTING: LOGIN SUKSES & REDIRECT**
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php'); // Alihkan ke halaman dashboard
        exit;
        
    } else {
        // Login Gagal
        $login_message = '<div class="alert error">❌ Username atau Password salah. Silakan coba lagi.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - <?= $nama_rs ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        /* Variabel CSS Kustom */
        :root {
            --teal-600: #0d9488;
            --teal-700: #0f766e;
            --teal-50: #ecfdf5;
            --gray-800: #1f2937;
        }
        
        /* --- CSS Login Card --- */
        .login-card {
            max-width: 400px;
            /* Margin atas disesuaikan agar berada di tengah atas tanpa navbar */
            margin: 80px auto 40px; 
            background-color: white;
            padding: 40px;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-header {
            color: #008080; /* Warna yang diminta */
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        
        .input-group input {
            padding-left: 40px; /* Ruang untuk ikon */
            padding-right: 15px;
            padding-top: 10px;
            padding-bottom: 10px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            width: 100%;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-group input:focus {
            border-color: var(--teal-600);
            box-shadow: 0 0 0 1px var(--teal-600);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1.25rem;
        }

        .show-password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .demo-info-box {
            background-color: #f0f7ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.5rem;
            padding: 15px;
            margin-top: 20px;
            text-align: left;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .demo-info-box strong {
            color: #1e40af;
        }
        .demo-credentials {
            background-color: #fff;
            padding: 8px;
            border-radius: 4px;
            margin-top: 5px;
            font-weight: 600;
            color: #0d9488;
            font-family: monospace;
        }
        
        /* Status Message */
        .alert { padding: 10px; border-radius: 0.5rem; margin-bottom: 15px; font-weight: 600; }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .error { background-color: #fee2e2; color: #b91c1c; border: 1px solid #ef4444; }

        @media (max-width: 768px) {
            .login-card { margin-top: 50px; padding: 30px 20px; }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container">
        <div class="login-card">
            
            <img src="asf.png" width="80" 
                class="mx-auto mb-4" 
                alt="Icon Login">

            <h2 class="login-header text-2xl">Login Petugas</h2>
            <p class="text-gray-500 text-sm mb-6">Masuk ke dashboard manajemen pengaduan</p>
            
            <?php echo $login_message; ?>

            <?php if (!$is_login_successful): ?>
                <form action="<?= $self_file ?>" method="POST" onsubmit="return validateLogin()">

                    <div class="input-group">
                        <i class="ri-user-line input-icon"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="input-group">
                        <i class="ri-lock-line input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <i class="ri-eye-line show-password-toggle" id="togglePassword"></i>
                    </div>

                    
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-lg shadow-md flex items-center justify-center">
                        <i class="ri-login-box-line mr-2"></i> Masuk
                    </button>
                </form>

            <?php endif; ?>

            <div class="mt-8 text-center">
                <a href="home.php" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    ← Kembali ke Home
                </a>
            </div>

        </div>
    </div>
    
    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle ikon mata
            if (type === 'text') {
                e.target.classList.remove('ri-eye-line');
                e.target.classList.add('ri-eye-off-line');
            } else {
                e.target.classList.remove('ri-eye-off-line');
                e.target.classList.add('ri-eye-line');
            }
        });

        function validateLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (username === '' || password === '') {
                alert('Username dan password wajib diisi.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>