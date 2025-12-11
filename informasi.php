<?php
// informasi.php
// Asumsi config.php ada untuk variabel $nama_rs
// Catatan: Jika Anda belum membuat config.php, variabel $nama_rs akan kosong.
// Jika config.php tidak diperlukan di sini, Anda bisa menghapus include_once.
// Untuk demonstrasi, saya akan mendefinisikan $nama_rs di sini jika tidak ada:
$nama_rs = "Rumah Sakit"; 
// Jika Anda ingin menggunakan config.php, pastikan ada: include_once 'config.php';

// Menentukan tab yang aktif berdasarkan parameter GET
$active_tab = $_GET['tab'] ?? 'alur_pengaduan';

// Daftar tab yang tersedia
$tabs = [
    'alur_pengaduan' => 'Alur Pengaduan',
    'jenis_pengaduan' => 'Jenis Pengaduan',
    'hak_kewajiban' => 'Hak & Kewajiban',
    'layanan_pengaduan' => 'Layanan Pengaduan',
    'faq' => 'FAQ',
    'kontak' => 'Kontak',
];

// Pastikan tab yang dipilih valid
if (!array_key_exists($active_tab, $tabs)) {
    $active_tab = 'alur_pengaduan';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pengaduan - <?= htmlspecialchars($tabs[$active_tab]) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        /* Variabel CSS Kustom */
        :root {
            --teal-600: #0d9488;
            --teal-700: #0f766e;
            --teal-50: #ecfdf5;
            --gray-800: #1f2937;
            --primary-teal: #008080;
        }

        /* --- GLOBAL STYLING --- */
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
            z-index: 51; /* Lebih tinggi dari overlay */
            background-color: white; /* Selalu putih */
            box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
            color: var(--gray-800); 
        }
        .navbar a {
            color: var(--gray-800);
            transition: 0.3s ease;
            text-decoration: none;
        }
        .navbar a:hover { color: var(--teal-700); }
        .navbar a.active {
            color: var(--teal-700) !important;
            border-bottom: 2px solid var(--teal-700);
            font-weight: 600;
        }
        .login-btn {
            background-color: var(--teal-700) !important;
            color: white !important;
            transition: 0.3s ease;
        }
        .nav-title, .nav-subtitle { color: var(--gray-800) !important; }
        
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
        
        /* --- HERO & CONTENT STYLING --- */
        .hero-info {
            background-color: var(--primary-teal);
            padding: 40px 0;
            margin-top: 60px; /* Jarak dari fixed navbar */
        }
        .tab-nav {
            border-bottom: 2px solid #e5e7eb;
        }
        .tab-link {
            transition: color 0.2s, border-bottom 0.2s;
            padding: 15px 20px;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            text-decoration: none;
        }
        .tab-link.tab-active {
            color: var(--primary-teal);
            border-bottom: 2px solid var(--primary-teal);
            font-weight: 600;
        }
        .content-card {
            background-color: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            min-height: 200px;
        }
        /* Styling Alur Pengaduan */
        .step-num {
            background-color: var(--primary-teal);
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 12px;
        }
        /* Styling FAQ */
        .faq-item {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .faq-question {
            padding: 15px;
            cursor: pointer;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-answer {
            padding: 0 15px 15px 15px;
            color: #6b7280;
            line-height: 1.6;
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding: 10px 20px;
            }
            .navbar .hidden.md\:flex {
                display: none; 
            }
            .navbar .menu-toggle {
                display: block; 
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
                <a href="informasi.php" class="nav-link active">Informasi</a>
                <a href="pengaduan.php" class="nav-link">Form Pengaduan</a>
                <a href="tracking.php" class="nav-link">Tracking</a>
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
    <div class="hero-info text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Informasi Pengaduan</h1>
            <p class="mt-2 opacity-90">Panduan lengkap tentang sistem pengaduan pasien</p>
        </div>
    </div>

    <div class="bg-white sticky top-[72px] z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="tab-nav flex overflow-x-auto whitespace-nowrap space-x-6">
                <?php foreach ($tabs as $key => $label): ?>
                    <a href="?tab=<?= $key ?>" 
                       class="tab-link <?= $active_tab === $key ? 'tab-active' : '' ?>">
                        <?= $label ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-6"><?= $tabs[$active_tab] ?></h2>

        <?php if ($active_tab === 'alur_pengaduan'): ?>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="content-card">
                    <div class="step-num">1</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Pengajuan Pengaduan</h3>
                    <p class="text-gray-600 mb-4">Pasien atau keluarga mengisi formulir pengaduan melalui website dengan melengkapi data diri dan detail keluhan.</p>
                    <ul class="list-disc ml-5 text-gray-700 text-sm space-y-1">
                        <li>Isi data pribadi dengan lengkap</li>
                        <li>Pilih jenis pengaduan yang sesuai</li>
                        <li>Jelaskan kronologi dengan detail</li>
                    </ul>
                </div>
                 <div class="content-card">
                    <div class="step-num">2</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Penerimaan & Registrasi</h3>
                    <p class="text-gray-600 mb-4">Sistem akan otomatis memberikan nomor tiket dan mengirim konfirmasi ke email Anda.</p>
                    <ul class="list-disc ml-5 text-gray-700 text-sm space-y-1">
                        <li>Dapatkan nomor tiket unik</li>
                        <li>Konfirmasi dikirim ke email</li>
                        <li>Simpan nomor tiket untuk tracking</li>
                    </ul>
                </div>
            </div>

        <?php elseif ($active_tab === 'jenis_pengaduan'): ?>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-heart-line text-4xl mb-3" style="color: #f87171;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pelayanan Medis</h3>
                    <p class="text-sm text-gray-600">Keluhan terkait kualitas pelayanan medis, diagnosis, pengobatan, atau tindakan medis</p>
                </div>
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-nurse-line text-4xl mb-3" style="color: #60a5fa;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pelayanan Keperawatan</h3>
                    <p class="text-sm text-gray-600">Keluhan mengenai sikap, keramahan, atau kualitas pelayanan perawat</p>
                </div>
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-capsule-line text-4xl mb-3" style="color: #10b981;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Farmasi</h3>
                    <p class="text-sm text-gray-600">Keluhan terkait ketersediaan obat, harga, atau pelayanan apotek</p>
                </div>
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-bank-card-line text-4xl mb-3" style="color: #a855f7;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Administrasi & Billing</h3>
                    <p class="text-sm text-gray-600">Keluhan mengenai proses administrasi, pembayaran, atau klaim asuransi</p>
                </div>
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-building-line text-4xl mb-3" style="color: #fbbf24;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Fasilitas & Sarana</h3>
                    <p class="text-sm text-gray-600">Keluhan terkait kebersihan, kenyamanan, atau kondisi fasilitas rumah sakit</p>
                </div>
                <div class="content-card flex flex-col items-center text-center">
                    <i class="ri-user-smile-line text-4xl mb-3" style="color: #4ade80;"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Sikap & Etika</h3>
                    <p class="text-sm text-gray-600">Keluhan mengenai sikap, komunikasi, atau etika tenaga kesehatan</p>
                </div>
            </div>

        <?php elseif ($active_tab === 'faq'): ?>
            <?php
            $faqs = [
                ['q' => 'Bagaimana cara mengajukan pengaduan?', 'a' => 'Pengaduan dapat diajukan melalui formulir online pada menu "Form Pengaduan" di website ini. Pastikan Anda mengisi semua kolom wajib.'],
                ['q' => 'Berapa lama waktu penyelesaian pengaduan?', 'a' => 'Tim kami berkomitmen untuk memberikan tanggapan awal maksimal 2x24 jam. Proses penyelesaian lengkap akan bervariasi tergantung kompleksitas kasus.'],
                ['q' => 'Apakah identitas saya akan dirahasiakan?', 'a' => 'Ya, identitas pelapor dijamin kerahasiaannya dan hanya akan diungkapkan kepada pihak internal yang berwenang untuk tujuan investigasi.'],
                ['q' => 'Bagaimana cara melacak status pengaduan saya?', 'a' => 'Anda akan menerima nomor tiket unik setelah pengajuan. Gunakan nomor tiket tersebut di menu "Tracking" untuk memantau status secara real-time.'],
            ];
            ?>
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Frequently Asked Questions</h2>
                <?php foreach ($faqs as $i => $faq): ?>
                    <div class="faq-item" id="faq-<?= $i ?>">
                        <div class="faq-question">
                            <?= htmlspecialchars($faq['q']) ?>
                            <i class="ri-arrow-down-s-line text-xl ml-4"></i>
                        </div>
                        <div class="faq-answer">
                            <?= htmlspecialchars($faq['a']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php elseif ($active_tab === 'kontak'): ?>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="contact-info-box">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Kontak</h3>
                    
                    <div class="space-y-4">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="ri-phone-line"></i></div>
                            <div>
                                <p class="font-medium text-gray-800">Telepon</p>
                                <p class="text-sm text-gray-600">(021) 1234-5678</p>
                                <p class="text-xs text-gray-500">Senin - Jumat: 08.00 - 16.00</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="ri-mail-line"></i></div>
                            <div>
                                <p class="font-medium text-gray-800">Email</p>
                                <p class="text-sm text-gray-600">pengaduan@rumahsakit.com</p>
                                <p class="text-xs text-gray-500">info@rumahsakit.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="ri-map-pin-line"></i></div>
                            <div>
                                <p class="font-medium text-gray-800">Alamat</p>
                                <p class="text-sm text-gray-600">Jl. Parang Baris No.30</p>
                                <p class="text-xs text-gray-500">Sondakan, Kec. Laweyan, Kota Surakarta, Jawa Tengah</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="ri-time-line"></i></div>
                            <div>
                                <p class="font-medium text-gray-800">Jam Operasional</p>
                                <p class="text-sm text-gray-600">Senin - Jumat: 08.00 - 16.00</p>
                                <p class="text-xs text-gray-500">Sabtu: 08.00 - 12.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="w-full h-96 bg-gray-200 rounded-xl overflow-hidden shadow-lg">
                    <iframe src="https://www.google.com/maps/embed?origin=mfe&pb=!1m2!2m1!1sJalan+Parang+Baris+No+30+Sondakan+Surakarta" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>


        <?php else: ?>
             <div class="bg-white p-10 rounded-xl shadow-lg text-center">
                 <h3 class="text-xl font-semibold text-gray-700 mb-4">Informasi Tambahan</h3>
                 <p class="text-gray-500">Konten untuk halaman **<?= $tabs[$active_tab] ?>** akan ditempatkan di sini.</p>
             </div>
        <?php endif; ?>
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
            document.body.style.overflow = 'auto';
        }

        // Fungsi pembuka menu
        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.add("open");
            menuOverlay.classList.add("open"); 
            document.body.style.overflow = 'hidden'; 
        });

        // Event listener untuk tombol close (Silang)
        closeMenu.addEventListener("click", closeMobileMenu);
        
        // Event listener: Tutup ketika Overlay diklik
        menuOverlay.addEventListener("click", closeMobileMenu); 
        
        // Menutup menu jika salah satu link di menu mobile diklik
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
        
        // JavaScript sederhana untuk toggle FAQ
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', event => {
                const answer = item.nextElementSibling;
                const icon = item.querySelector('i');
                
                // Tutup semua yang lain
                document.querySelectorAll('.faq-answer').forEach(ans => {
                     if (ans !== answer) ans.style.display = 'none';
                });
                document.querySelectorAll('.faq-question i').forEach(ico => {
                    if (ico !== icon) ico.classList.replace('ri-arrow-up-s-line', 'ri-arrow-down-s-line');
                });


                // Toggle yang sedang diklik
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.classList.replace('ri-arrow-up-s-line', 'ri-arrow-down-s-line');
                } else {
                    answer.style.display = 'block';
                    icon.classList.replace('ri-arrow-down-s-line', 'ri-arrow-up-s-line');
                }
            });
        });
    </script>
</body>
</html>