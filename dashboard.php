<?php
// dashboard.php
include_once 'config.php';
check_login(); // Periksa status login

// Ambil data user yang sedang login
$user = get_current_user(); 
// $username_display = $user['nama'] ?? $_SESSION['username']; // BARIS INI DIHAPUS

// --- SIMULASI DATA DASHBOARD ---
$stats = [
    'total' => 5,
    'menunggu' => 2,
    'proses' => 1,
    'selesai' => 2
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - <?= htmlspecialchars($user['nama'] ?? 'Petugas') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        :root { --teal-600: #0d9488; --teal-700: #0f766e; }
        .navbar { background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .main-container { padding-top: 80px; }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .bg-teal-gradient { background: linear-gradient(135deg, #0f766e, #0d9488); }
        .nav-link.active { color: #0f766e; font-weight: 600; }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="navbar fixed top-0 w-full flex items-center justify-between px-10 py-3 z-50">
        <div class="flex items-center space-x-3">
            <img src="asf.png" class="h-10" alt="Logo RS">
            <span class="text-gray-800 font-bold text-lg">Dashboard Petugas</span>
        </div>
        <div class="flex items-center space-x-6 text-base font-medium">
            <a href="dashboard.php" class="nav-link active">Dashboard</a>
            <a href="manajemen_komplain.php" class="nav-link">Manajemen Komplain</a>
            <a href="profil.php" class="nav-link">Profil</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <div class="main-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-teal-gradient text-white p-6 rounded-xl shadow-lg mt-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Selamat Datang, <?= htmlspecialchars($user['nama'] ?? $_SESSION['username'] ?? 'Petugas') ?>!</h1>
                <p class="mt-1">Kelola dan pantau semua pengaduan pasien dari dashboard ini</p>
            </div>
             <i class="ri-dashboard-line text-5xl opacity-80"></i>
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-6">Ringkasan Pengaduan</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <?php 
            $card_data = [
                ['label' => 'Total Pengaduan', 'count' => $stats['total'], 'color' => 'bg-white', 'icon' => 'ri-file-text-line', 'text_color' => 'text-blue-600'],
                ['label' => 'Menunggu Verifikasi', 'count' => $stats['menunggu'], 'color' => 'bg-white', 'icon' => 'ri-time-line', 'text_color' => 'text-yellow-600'],
                ['label' => 'Dalam Proses', 'count' => $stats['proses'], 'color' => 'bg-white', 'icon' => 'ri-settings-4-line', 'text_color' => 'text-teal-600'],
                ['label' => 'Terselesaikan', 'count' => $stats['selesai'], 'color' => 'bg-white', 'icon' => 'ri-check-line', 'text_color' => 'text-green-600'],
            ];
            foreach ($card_data as $card): ?>
                <div class="stat-card <?= $card['color'] ?> p-5 rounded-xl shadow-md flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500"><?= $card['label'] ?></p>
                        <p class="text-4xl font-bold text-gray-800 mt-1"><?= $card['count'] ?></p>
                    </div>
                    <i class="<?= $card['icon'] ?> text-4xl <?= $card['text_color'] ?> opacity-50"></i>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg mt-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Pengaduan Terbaru</h3>
                <a href="manajemen_komplain.php" class="text-teal-600 hover:text-teal-700 font-medium">Lihat Semua →</a>
            </div>
            
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-left text-gray-500 text-sm font-medium">
                        <th class="py-3 px-2">No. Tiket</th>
                        <th class="py-3 px-2">Nama Pelapor</th>
                        <th class="py-3 px-2">Jenis</th>
                        <th class="py-3 px-2">Tanggal</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <tr>
                        <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF83</td>
                        <td class="py-4 px-2">Made</td>
                        <td class="py-4 px-2">Fasilitas & Sarana</td>
                        <td class="py-4 px-2">10 Des 2025</td>
                        <td class="py-4 px-2"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Verifikasi</span></td>
                        <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700">Detail →</a></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-2 text-gray-900 font-medium">TKT12345ABCD</td>
                        <td class="py-4 px-2">Budi</td>
                        <td class="py-4 px-2">Pelayanan</td>
                        <td class="py-4 px-2">09 Des 2025</td>
                        <td class="py-4 px-2"><span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">Dalam Proses</span></td>
                        <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700">Detail →</a></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF84</td>
                        <td class="py-4 px-2">Ade</td>
                        <td class="py-4 px-2">Fasilitas & Sarana</td>
                        <td class="py-4 px-2">10 Des 2025</td>
                        <td class="py-4 px-2"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Verifikasi</span></td>
                        <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700">Detail →</a></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF85</td>
                        <td class="py-4 px-2">Dea</td>
                        <td class="py-4 px-2">Fasilitas & Sarana</td>
                        <td class="py-4 px-2">10 Des 2025</td>
                        <td class="py-4 px-2"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Terselesaikan</span></td>
                        <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700">Detail →</a></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF86</td>
                        <td class="py-4 px-2">Mades</td>
                        <td class="py-4 px-2">Fasilitas & Sarana</td>
                        <td class="py-4 px-2">10 Des 2025</td>
                        <td class="py-4 px-2"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Terselesaikan</span></td>
                        <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700">Detail →</a></td>
                    </tr>

                </tbody>
            </table>
        </div>
        
        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-6"></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            
             <a href="manajemen_komplain.php" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-4">
                <i class="ri-list-check text-3xl text-teal-600"></i>
                <div>
                    <p class="font-semibold text-gray-800">Kelola Komplain</p>
                    <p class="text-sm text-gray-500">Lihat dan kelola semua pengaduan pasien</p>
                </div>
            </a>
            <a href="profil.php" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-4">
                <i class="ri-profile-line text-3xl text-teal-600"></i>
                <div>
                    <p class="font-semibold text-gray-800">Profil</p>
                    <p class="text-sm text-gray-500">Kelola informasi profil petugas</p>
                </div>
            </a>
            <a href="home.php" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-4">
                <i class="ri-home-4-line text-3xl text-teal-600"></i>
                <div>
                    <p class="font-semibold text-gray-800">Ke Halaman Utama</p>
                    <p class="text-sm text-gray-500">Kembali ke halaman utama website</p>
            </div>
            </a>
        </div>
    </div>
</body>
</html>