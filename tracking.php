<?php
$self_file = 'tracking.php'; 
$nama_rs = "Rumah Sakit";

// Variabel default
$mode = 'input';
$search_ticket = '';
$tracking_result = null;

// --- SIMULASI DATA PENGADUAN ---
$complaints_data = [
    'TKT12345ABCD' => [
        'status' => 'Sedang Diproses',
        'progress' => 50,
        'tanggal_masuk' => '2025-12-10',
        'kategori' => 'Pelayanan',
        'detail_status' => 'Pengaduan telah diverifikasi. Menunggu penugasan tim investigasi internal.'
    ],
    'TKT00098EFGH' => [
        'status' => 'Selesai',
        'progress' => 100,
        'tanggal_masuk' => '2025-12-01',
        'kategori' => 'Fasilitas',
        'detail_status' => 'Keluhan fasilitas (AC rusak) telah diperbaiki dan diverifikasi oleh tim teknis. Solusi sudah dikirim via email.'
    ],
];

// 1. Logika Pemrosesan Pencarian (GET)
if (isset($_GET['ticket']) && !empty($_GET['ticket'])) {
    $search_ticket = trim(htmlspecialchars(strtoupper($_GET['ticket']))); 
    $mode = 'result';
    
    if (array_key_exists($search_ticket, $complaints_data)) {
        $tracking_result = $complaints_data[$search_ticket];
    } else {
        $tracking_result = ['status' => 'Tidak Ditemukan', 'progress' => 0];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pengaduan Pasien - <?= $nama_rs ?></title>
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
        
        /* --- GLOBAL STYLING --- */
        /* Mengizinkan scroll di halaman ini */
        body {
            overflow-x: hidden;
        }

        /* --- NAVBAR STYLING (Selalu Mode Scrolled) --- */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 40px;
            z-index: 51;
            background-color: white; /* Selalu putih di halaman internal */
            box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
            color: var(--gray-800); /* Warna teks default hitam/abu */
        }
        .navbar a {
            color: var(--gray-800);
            transition: 0.3s ease;
            text-decoration: none;
        }
        .navbar a:hover {
            color: var(--teal-700);
        }
        .login-btn {
            background-color: var(--teal-700) !important;
            color: white !important;
            transition: 0.3s ease;
        }
        .nav-title, .nav-subtitle {
            color: var(--gray-800) !important;
        }
        .navbar a.active {
            color: var(--teal-700);
            border-bottom: 2px solid var(--teal-700);
            font-weight: 600;
        }

        /* --- MOBILE MENU & OVERLAY STYLING --- */
        #menuOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }
        #menuOverlay.open {
            opacity: 1;
            visibility: visible;
        }
        #mobileMenu {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 75%; 
            max-width: 300px;
            background-color: white;
            z-index: 51; 
            transform: translateX(100%); 
            transition: transform 0.3s ease-in-out;
            box-shadow: -4px 0 10px rgba(0,0,0,0.1);
        }
        #mobileMenu.open {
            transform: translateX(0); 
        }
        .mobile-nav-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: block;
            color: var(--gray-800);
            font-weight: 500;
        }
        
        /* --- CONTENT CARD STYLING --- */
        .tracking-card {
            max-width: 800px;
            margin: 100px auto 40px; 
            background-color: white;
            padding: 40px;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        /* Icon Styling */
        .icon-tracking {
            background-color: var(--teal-50);
            color: var(--teal-700);
            border-radius: 9999px; 
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Info Box Styling */
        .info-box {
            background-color: var(--teal-50); 
            border-left: 5px solid var(--teal-700); 
        }
        /* Detail Table */
        .detail-table th, .detail-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-table th {
            width: 35%;
            background-color: #f3f4f6;
            font-weight: 600;
            color: #4b5563;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding: 10px 20px;
            }
            .navbar .hidden.md\:flex {
                display: none; /* Sembunyikan menu desktop */
            }
            .navbar .menu-toggle {
                display: block; /* Tampilkan Hamburger */
            }
        }
        @media (min-width: 768px) {
            #mobileMenu {
                display: none !important;
            }
            #menuOverlay {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <nav id="navbar" class="navbar flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="asf.png" class="h-10" alt="Logo RS">
            <div class="flex flex-col leading-tight">
                <span class="nav-title font-bold">Sistem Pengaduan</span>
                <span class="nav-subtitle text-sm -mt-1"><?= $nama_rs ?></span>
            </div>
        </div>

        <div class="flex items-center space-x-6 text-base font-medium">
            <div class="hidden md:flex space-x-6">
                <a href="home.php" class="nav-link">Home</a>
                <a href="informasi.php" class="nav-link">Informasi</a>
                <a href="pengaduan.php" class="nav-link">Form Pengaduan</a>
                <a href="tracking.php" class="nav-link active">Tracking</a>
            </div>

            <a href="login.php" class="login-btn hidden md:block px-5 py-2 rounded-lg font-semibold shadow-md hover:bg-teal-800">
                Login Petugas
            </a>

            <button id="menu-toggle" class="md:hidden menu-toggle text-2xl">
                <i class="ri-menu-line"></i>
            </button>
        </div>
    </nav>
    <div id="menuOverlay" class="md:hidden"></div>
    
    <div id="mobileMenu" class="md:hidden">
        <div class="flex flex-col">
            <div class="flex justify-end p-5">
                <button id="closeMenu" class="text-gray-700 text-3xl">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <a href="home.php" class="mobile-nav-item">Home</a>
            <a href="informasi.php" class="mobile-nav-item">Informasi</a>
            <a href="pengaduan.php" class="mobile-nav-item">Form Pengaduan</a>
            <a href="tracking.php" class="mobile-nav-item">Tracking</a>
            
            <a href="login.php" class="mobile-login-btn">
                <button class="w-full bg-teal-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-teal-700">
                    Login Petugas
                </button>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="tracking-card">
            
            <?php if ($mode === 'input'): ?>
                <div class="icon-tracking w-16 h-16 p-4 mx-auto mb-5">
                    <i class="ri-search-line text-3xl"></i>
                </div>
                
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Tracking Pengaduan</h2>
                <p class="text-gray-600 mb-8">Masukkan nomor tiket untuk melacak status pengaduan Anda</p>
                
                <form action="<?= $self_file ?>" method="GET" class="flex flex-col md:flex-row gap-3 max-w-xl mx-auto mb-6">
                    <input type="text" name="ticket" 
                            placeholder="Masukkan nomor tiket (contoh: TKT12345ABCD)"
                            class="flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600"
                            value="<?= htmlspecialchars($search_ticket) ?>"
                            required>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center">
                        <i class="ri-search-line mr-2"></i> Cari
                    </button>
                </form>

                <div class="info-box p-4 rounded-lg mt-8 max-w-xl mx-auto">
                    <p class="text-base font-semibold text-teal-700 mb-1">Informasi</p>
                    <ul class="list-disc ml-5 text-gray-700 text-sm space-y-1 text-left">
                        <li>Nomor tiket dikirimkan ke email Anda setelah *submit* pengaduan</li>
                        <li>Simpan nomor tiket dengan baik untuk *tracking*</li>
                        <li>Status akan di-*update* secara berkala oleh tim kami</li>
                        <li>Hubungi kami jika ada pertanyaan</li>
                    </ul>
                </div>
                
            <?php elseif ($mode === 'result'): ?>
                <div class="text-center">
                    
                    <?php if ($tracking_result['status'] !== 'Tidak Ditemukan'): 
                        $status_class = strtolower(str_replace(' ', '-', $tracking_result['status']));
                    ?>
                        <div class="icon-tracking w-16 h-16 p-4 mx-auto mb-5" 
                            style="background-color: <?= $status_class === 'selesai' ? '#10b981' : ($status_class === 'diproses' ? '#f59e0b' : '#6b7280'); ?>; color: white;">
                            <i class="ri-<?= $status_class === 'selesai' ? 'check-line' : ($status_class === 'diproses' ? 'time-line' : 'close-line'); ?> text-3xl"></i>
                        </div>
                        
                        <h2 class="text-2xl font-semibold text-gray-800 mb-1">Status Pengaduan</h2>
                        <p class="text-xl font-bold text-gray-600 mb-4">Tiket: <?= htmlspecialchars($search_ticket) ?></p>

                        <div class="status-badge <?= $status_class ?>">
                            <?= htmlspecialchars($tracking_result['status']) ?>
                        </div>

                        <div class="w-full max-w-md mx-auto my-8">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Progress (<?= $tracking_result['progress'] ?>%)</p>
                            <div class="h-2 bg-gray-200 rounded-full">
                                <div class="h-2 rounded-full bg-teal-600" style="width: <?= $tracking_result['progress'] ?>%;"></div>
                            </div>
                        </div>
                        
                        <div class="overflow-hidden rounded-xl shadow-lg border border-gray-200 mt-10">
                            <table class="detail-table w-full text-sm">
                                <tbody>
                                    <tr>
                                        <th>Tanggal Masuk</th>
                                        <td><?= date('d F Y', strtotime($tracking_result['tanggal_masuk'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?= $tracking_result['kategori'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Update Terakhir</th>
                                        <td class="text-gray-700 italic"><?= $tracking_result['detail_status'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>
                        <div class="icon-tracking w-16 h-16 p-4 mx-auto mb-5 bg-red-100" style="color: #ef4444;">
                             <i class="ri-question-line text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-semibold text-red-600 mb-4">Tiket Tidak Ditemukan</h2>
                        <p class="text-gray-600">Mohon maaf, nomor tiket **<?= htmlspecialchars($search_ticket) ?>** tidak ditemukan.</p>
                        <p class="text-gray-600 mt-2">Pastikan nomor tiket sudah benar atau hubungi layanan bantuan.</p>

                    <?php endif; ?>
                    
                    <div class="mt-8">
                        <a href="<?= $self_file ?>" class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                            <i class="ri-arrow-left-line mr-2"></i> Kembali ke Pencarian
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobileMenu");
        const menuOverlay = document.getElementById("menuOverlay"); 
        const closeMenu = document.getElementById("closeMenu");

        // Fungsi penutup menu
        function closeMobileMenu() {
            mobileMenu.classList.remove("open");
            menuOverlay.classList.remove("open");
            document.body.style.overflow = 'auto'; // Pastikan scroll kembali normal
        }

        // Fungsi pembuka menu
        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.add("open");
            menuOverlay.classList.add("open"); 
            document.body.style.overflow = 'hidden'; // Kunci scroll
        });

        // Event listener untuk tombol close (Silang)
        closeMenu.addEventListener("click", closeMobileMenu);
        
        // Event listener: Tutup ketika Overlay diklik
        menuOverlay.addEventListener("click", closeMobileMenu); 
        
        // Menutup menu jika salah satu link di menu mobile diklik
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
        
        // *CATATAN: Logic Scroll Navbar Dihapus karena halaman ini selalu mode 'scrolled'*
    </script>
    
</body>
</html>