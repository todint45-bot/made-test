<?php
// manajemen_komplain.php
include 'config.php';
check_login();

$user = get_current_user();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Komplain - <?= $nama_rs ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        .nav-link.active { color: #0f766e; font-weight: 600; }
        .main-container { padding-top: 80px; }
        .navbar { background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .stat-box { transition: transform 0.2s; }
        .stat-box:hover { transform: translateY(-2px); }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="navbar fixed top-0 w-full flex items-center justify-between px-10 py-3 z-50">
        <div class="flex items-center space-x-3">
            <img src="asf.png" class="h-10" alt="Logo RS">
            <span class="text-gray-800 font-bold text-lg">Manajemen Komplain</span>
        </div>
        <div class="flex items-center space-x-6 text-base font-medium">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="manajemen_komplain.php" class="nav-link active">Manajemen Komplain</a>
            <a href="profil.php" class="nav-link">Profil</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <div class="main-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-xl shadow-lg">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                <div class="relative w-full md:w-1/3">
                    <input type="text" placeholder="Cari berdasarkan tiket, nama, atau email..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-teal-500">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <div class="relative w-full md:w-auto">
                    <select class="appearance-none w-full border border-gray-300 bg-white px-4 py-2 pr-8 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option>Semua Status</option>
                        <option>Menunggu Verifikasi</option>
                        <option>Dalam Proses</option>
                        <option>Selesai</option>
                        <option>Ditolak</option>
                    </select>
                    <i class="ri-arrow-down-s-line absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="stat-box bg-blue-50 p-4 rounded-xl shadow-md text-center">
                    <p class="text-xs font-medium text-gray-500">Total</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">5</p>
                    <p class="text-sm text-blue-600 font-semibold">Total Pengaduan</p>
                </div>
                <div class="stat-box bg-yellow-50 p-4 rounded-xl shadow-md text-center">
                    <p class="text-xs font-medium text-gray-500">Menunggu</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">2</p>
                    <p class="text-sm text-yellow-600 font-semibold">Menunggu Verifikasi</p>
                </div>
                <div class="stat-box bg-teal-50 p-4 rounded-xl shadow-md text-center">
                    <p class="text-xs font-medium text-gray-500">Proses</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">1</p>
                    <p class="text-sm text-teal-600 font-semibold">Dalam Proses</p>
                </div>
                <div class="stat-box bg-green-50 p-4 rounded-xl shadow-md text-center">
                    <p class="text-xs font-medium text-gray-500">Selesai</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">2</p>
                    <p class="text-sm text-green-600 font-semibold">Terselesaikan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">No. Tiket</th>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">Nama Pelapor</th>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">Jenis Pengaduan</th>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">Tanggal</th>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="py-3 px-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <tr>
                            <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF83</td>
                            <td class="py-4 px-2">Made<br><span class="text-xs text-gray-500">made@gmail.com</span></td>
                            <td class="py-4 px-2">Fasilitas & Sarana</td>
                            <td class="py-4 px-2">10 Des 2025</td>
                            <td class="py-4 px-2">
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Verifikasi</span>
                            </td>
                            <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700 font-medium">Detail →</a></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-gray-900 font-medium">TKT12345ABCD</td>
                            <td class="py-4 px-2">Budi<br><span class="text-xs text-gray-500">budi@gmail.com</span></td>
                            <td class="py-4 px-2">Pelayanan</td>
                            <td class="py-4 px-2">09 Des 2025</td>
                            <td class="py-4 px-2">
                                <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">Dalam Proses</span>
                            </td>
                            <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700 font-medium">Detail →</a></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF83</td>
                            <td class="py-4 px-2">Ade<br><span class="text-xs text-gray-500">made@gmail.com</span></td>
                            <td class="py-4 px-2">Fasilitas & Sarana</td>
                            <td class="py-4 px-2">10 Des 2025</td>
                            <td class="py-4 px-2">
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Verifikasi</span>
                            </td>
                            <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700 font-medium">Detail →</a></td>
                        </tr>

                        <tr>
                            <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF83</td>
                            <td class="py-4 px-2">Dea<br><span class="text-xs text-gray-500">made@gmail.com</span></td>
                            <td class="py-4 px-2">Fasilitas & Sarana</td>
                            <td class="py-4 px-2">10 Des 2025</td>
                            <td class="py-4 px-2">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Terselesaikan</span>
                            </td>
                            <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700 font-medium">Detail →</a></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-gray-900 font-medium">TKT849XXXXCF83</td>
                            <td class="py-4 px-2">Mades<br><span class="text-xs text-gray-500">made@gmail.com</span></td>
                            <td class="py-4 px-2">Fasilitas & Sarana</td>
                            <td class="py-4 px-2">10 Des 2025</td>
                            <td class="py-4 px-2">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Terselesaikan</span>
                            </td>
                            <td class="py-4 px-2"><a href="#" class="text-teal-600 hover:text-teal-700 font-medium">Detail →</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</body>
</html>