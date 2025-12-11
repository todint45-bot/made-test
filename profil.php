<?php
// profil.php
include_once 'config.php';

// check_login() akan mengalihkan ke login.php jika belum login
check_login(); 

$user = get_current_user();

// *--- PENTING: Penanganan jika $user null setelah check_login ---*
if ($user === null) {
    // Jika sesi login ada, tetapi data user di database simulasi (session users) hilang, logout user.
    header('Location: logout.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Petugas - <?= htmlspecialchars($user['nama'] ?? 'Petugas') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        .nav-link.active { color: #0f766e; font-weight: 600; }
        .main-container { padding-top: 80px; }
        .navbar { background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .profile-card { background: linear-gradient(45deg, #0d9488, #2dd4bf ); }
        .info-row { border-bottom: 1px solid #e5e7eb; }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="navbar fixed top-0 w-full flex items-center justify-between px-10 py-3 z-50">
        <div class="flex items-center space-x-3">
            <img src="asf.png" class="h-10" alt="Logo RS">
            <span class="text-gray-800 font-bold text-lg">Profil Petugas</span>
        </div>
        <div class="flex items-center space-x-6 text-base font-medium">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="manajemen_komplain.php" class="nav-link">Manajemen Komplain</a>
            <a href="profil.php" class="nav-link active">Profil</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <div class="main-container max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">
            
            <div class="profile-card text-white p-8 md:p-10 text-center">
                <img src="asf1.png"
                     class="w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg mb-4" alt="Foto Profil">
                <h1 class="text-2xl font-bold"><?= htmlspecialchars($user['nama'] ?? 'Profil Petugas') ?></h1>
                <p class="text-sm opacity-90"><?= htmlspecialchars($user['jabatan'] ?? 'Petugas Pengaduan') ?></p>
            </div>

            <div class="p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h2>
                
                <div class="info-row flex items-center py-3">
                    <div class="w-1/3 text-gray-500 font-medium">Username</div>
                    <div class="w-2/3 text-gray-800 flex items-center space-x-2">
                        <i class="ri-user-line text-teal-600"></i> 
                        <span><?= htmlspecialchars($_SESSION['username'] ?? '-') ?></span>
                    </div>
                </div>

                <div class="info-row flex items-center py-3">
                    <div class="w-1/3 text-gray-500 font-medium">Nama Lengkap</div>
                    <div class="w-2/3 text-gray-800 flex items-center space-x-2">
                        <i class="ri-profile-line text-teal-600"></i> 
                        <span><?= htmlspecialchars($user['nama'] ?? '-') ?></span>
                    </div>
                </div>
                
                <div class="info-row flex items-center py-3">
                    <div class="w-1/3 text-gray-500 font-medium">Jabatan</div>
                    <div class="w-2/3 text-gray-800 flex items-center space-x-2">
                        <i class="ri-briefcase-line text-teal-600"></i> 
                        <span><?= htmlspecialchars($user['jabatan'] ?? '-') ?></span>
                    </div>
                </div>
                
                <div class="info-row flex items-center py-3 border-none">
                    <div class="w-1/3 text-gray-500 font-medium">Password</div>
                    <div class="w-2/3 text-gray-800 flex items-center space-x-2">
                        <i class="ri-lock-line text-teal-600"></i> <span>********</span>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 pt-0">
                <button class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-lg flex items-center justify-center space-x-2">
                    <i class="ri-edit-line"></i> <span>Edit Profil</span>
                </button>
            </div>
            
            <a center href="manajemen_user.php" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-4">
                <i class="ri-user-add-line text-3xl text-teal-600"></i>
                <div>
                    <p class="font-semibold text-gray-800">Buat Akun Admin Baru</p>
                    <p class="text-sm text-gray-500">Tambahkan petugas atau administrator baru</p>
                </div>

                <a href="manajemen_komplain.php" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-4">
                <i class="ri-list-check text-3xl text-teal-600"></i>
                <div>
                    <p class="font-semibold text-gray-800">Lihat Semua Komplain</p>
                    <p class="text-sm text-gray-500">Pindah ke tabel manajemen komplain</p>
                </div>
            </a>
        </div>

        </div>
    </div>
</body>
</html>