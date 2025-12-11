<?php
// PHP Sederhana untuk menampilkan pesan status formulir (Mode Formulir)
$form_status_message = '';
$is_submission_successful = false;
$ticket_number = 'TKT' . strtoupper(bin2hex(random_bytes(6))); // Generate tiket simulasi

// 1. Logika Pemrosesan Formulir (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data input (disimpan dalam variabel POST)s
    $nama      = trim($_POST['nama'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telepon   = trim($_POST['telepon'] ?? '');
    $alamat    = trim($_POST['alamat'] ?? '');
    $jenis     = trim($_POST['jenis'] ?? '');
    $tanggal   = trim($_POST['tanggal'] ?? '');
    $kronologi = trim($_POST['kronologi'] ?? '');
    
    // Cek semua field wajib (*) terisi
    if (!empty($nama) && !empty($email) && !empty($telepon) && !empty($alamat) && !empty($jenis) && !empty($tanggal) && !empty($kronologi)) {
        // Jika Sukses, langsung redirect ke mode sukses
        // Ini adalah cara yang benar untuk mencegah pengiriman ulang formulir
        header("Location: pengaduan.php?status=success&ticket=" . $ticket_number);
        exit;
    } else {
        // Jika Gagal, tampilkan pesan error di halaman formulir
        $form_status_message = '<div class="alert error">❌ Gagal mengirim. Pastikan semua kolom wajib (*) terisi.</div>';
    }
}

// 2. Logika Cek Mode Sukses (GET)
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $is_submission_successful = true;
    // Ambil nomor tiket dari URL, atau gunakan nomor tiket simulasi jika tidak ada
    $ticket_number_display = htmlspecialchars($_GET['ticket'] ?? $ticket_number);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_submission_successful ? 'Pengaduan Berhasil Dikirim' : 'Formulir Pengaduan Pasien'; ?></title>
    
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6; 
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        
        .navbar nav a {
            text-decoration: none;
            color: #555;
            margin: 0 15px;
            padding: 5px 0;
        }

        .navbar nav a.active {
            color: #008080; 
            border-bottom: 2px solid #008080;
            font-weight: bold;
        }

        .btn-petugas {
            background-color: #008080;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        /* --- STYLING MODE FORMULIR --- */
        .form-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header-form {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-form h2 {
            color: #008080;
            margin: 5px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #008080;
            padding-bottom: 5px;
            border-bottom: 2px solid #e0f2f1;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-grid-detail {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr; 
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box; 
        }
        
        #char-count {
            text-align: right;
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }

        .full-width {
            grid-column: 1 / -1; 
        }

        .upload-area {
            border: 2px dashed #b2dfdb; 
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            color: #008080;
        }

        .info-box {
            background-color: #e0f7fa; 
            border-left: 5px solid #00bcd4; 
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
        }

        .info-box ul {
            list-style: disc;
            padding-left: 20px;
            margin: 0;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-cancel,
        .btn-submit {
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: #555;
            border: 1px solid #ccc;
        }

        .btn-submit {
            background-color: #008080;
            color: white;
            font-weight: bold;
        }

        /* Status Message */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* --- STYLING MODE SUKSES (Screenshot 75 & 76) --- */
        .success-card {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-card h2 {
            font-size: 24px;
            color: #333;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .icon-check {
            width: 60px;
            height: 60px;
            background-color: #4CAF50; /* Hijau */
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .icon-check:after {
            content: '✓';
            color: white;
            font-size: 30px;
        }
        
        .ticket-info {
            background-color: #f0fafa;
            border: 1px solid #b2dfdb;
            padding: 30px 20px;
            margin: 20px auto;
            border-radius: 8px;
            max-width: 400px;
        }

        .ticket-number-label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .ticket-number-box {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #008080;
            color: white;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .ticket-number-box button {
            background: none;
            border: none;
            color: white;
            margin-left: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .next-steps-list {
            text-align: left;
            margin: 30px auto;
            max-width: 400px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 20px;
        }
        
        .next-steps-list ol {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .next-steps-list li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            line-height: 1.4;
            color: #555;
        }

        .next-steps-list li:before {
            content: counter(step-counter);
            counter-increment: step-counter;
            position: absolute;
            left: 0;
            top: 0;
            background-color: #008080;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
        }

        .help-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #555;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .contact-item span {
            color: #008080;
            font-weight: bold;
        }

        .success-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-track, .btn-home, .btn-print {
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            border: 1px solid #ccc;
        }
        
        .btn-track {
            background-color: #008080;
            color: white;
            font-weight: bold;
        }
        
        .btn-home, .btn-print {
            background-color: #fff;
            color: #555;
        }
        
        .commitment-text {
            font-size: 12px;
            color: #777;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            .form-grid, .form-grid-detail {
                grid-template-columns: 1fr; 
            }
            .success-actions {
                flex-direction: column;
            }
            .help-section {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>


    <div class="container">
        
        <?php if ($is_submission_successful): ?>
            <div class="success-card">
                <div class="icon-check"></div>
                <h2>Pengaduan Berhasil Dikirim!</h2>
                <p>Terima kasih telah menyampaikan pengaduan Anda. Tim kami akan segera menindaklanjuti.</p>
                
                <div class="ticket-info">
                    <span class="ticket-number-label">Nomor Tiket Anda</span>
                    <div class="ticket-number-box">
                        <?php echo $ticket_number_display; ?>
                        <button onclick="navigator.clipboard.writeText('<?php echo $ticket_number_display; ?>'); alert('Nomor tiket berhasil disalin!');">
                            &#x2398;
                        </button>
                    </div>
                    <small>Simpan nomor tiket ini untuk melacak status pengaduan</small>
                </div>
                


                <div class="success-actions">
                    <a href="?mode=tracking&ticket=<?php echo $ticket_number_display; ?>" class="btn-track">
                        &#128269; Lacak Pengaduan
                    </a>
                    <a href="home.php" class="btn-home">
                        &#127968; Kembali ke Home
                    </a>
                </div>
                
                <p class="commitment-text">
                    Kami berkomitmen untuk memberikan pelayanan terbaik dan menyelesaikan pengaduan Anda dengan profesional
                </p>
            </div>
            
        <?php else: ?>
            <?php echo $form_status_message; ?>

            <div class="form-card">
                <div class="header-form">
                    <img src="asf.png" alt="Icon Form" width="80" style="border-radius: 50%;">
                    <h2>Form Pengaduan Pasien</h2>
                    <p>Silakan isi formulir di bawah ini dengan lengkap dan jelas</p>
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="section-title">Data Pelapor</div>
                    <div class="form-grid">
                        <div class="form-group"><label for="nama">Nama Lengkap *</label><input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required></div>
                        <div class="form-group"><label for="email">Email *</label><input type="email" id="email" name="email" placeholder="contoh@email.com" required></div>
                        <div class="form-group"><label for="telepon">Nomor Telepon *</label><input type="text" id="telepon" name="telepon" placeholder="08xxxxxxxxxxxx" required></div>
                        <div class="form-group"><label for="alamat">Alamat *</label><input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required></div>
                    </div>

                    <div class="section-title">Detail Pengaduan</div>
                    <div class="form-grid-detail">
                        <div class="form-group">
                            <label for="jenis">Jenis Pengaduan *</label>
                            <select id="jenis" name="jenis" required>
                                <option value="">Pilih jenis pengaduan</option>
                                <option value="Pelayanan">Pelayanan</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group"><label for="tanggal">Tanggal Kejadian *</label><input type="date" id="tanggal" name="tanggal" required></div>
                        <div class="form-group"><label for="lokasi">Lokasi Kejadian</label><input type="text" id="lokasi" name="lokasi" placeholder="Contoh: Ruang IGD"></div>
                    </div>

                    <div class="form-group full-width">
                        <label for="kronologi">Kronologi Kejadian *</label>
                        <textarea id="kronologi" name="kronologi" rows="5" placeholder="Jelaskan kronologi kejadian secara detail dan jelas" required></textarea>
                        <small id="char-count" style="color:#777;">Wajib di isi</small>
                    </div>

                    <div class="section-title">Bukti Pendukung (Opsional)</div>
                    <div class="form-group full-width upload-area">
                        <input type="file" id="bukti" name="bukti" accept=".jpg, .jpeg, .png, .pdf" style="display: none;">
                        <label for="bukti">
                            <span style="font-size: 30px;">⬆️</span><br>Klik untuk *upload* file<br>Format: JPG, PNG, PDF (Maks: 5MB)
                        </label>
                    </div>

                    <div class="info-box full-width">
                        <strong>Informasi Penting</strong>
                        <ul>
                            <li>Pastikan semua data yang Anda isi adalah benar dan dapat dipertanggungjawabkan</li>
                            <li>Tim kami akan merespons maksimal 2x24 jam (48 jam)</li>
                        </ul>
                    </div>

                    <div class="form-actions full-width">
                        <a href="home.php" class="btn-cancel" role="button">Batal</a>
                        <button type="submit" class="btn-submit">Kirim Pengaduan</button>
                    </div>
                </form>
            </div>
            
        <?php endif; ?>
    </div>

    <script>
        // Fungsi untuk menyalin teks ke clipboard
        // (Ini diperlukan karena metode inline onclick mungkin tidak didukung oleh semua browser)
        function copyTicketNumber(ticket) {
            navigator.clipboard.writeText(ticket).then(() => {
                alert("Nomor tiket " + ticket + " berhasil disalin!");
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
                alert("Gagal menyalin nomor tiket. Silakan salin manual.");
            });
        }
    </script>

</body>
</html>