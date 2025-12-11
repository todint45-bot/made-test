<?php
// manajemen_user.php
include_once 'config.php';
check_login();

$user = get_current_user();
$message = '';
$form_data = ['username' => '', 'password' => '', 'nama' => '', 'jabatan' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_user = trim($_POST['username'] ?? '');
    $new_pass = trim($_POST['password'] ?? '');
    $new_nama = trim($_POST['nama'] ?? '');
    $new_jbt  = trim($_POST['jabatan'] ?? '');

    $form_data = ['username' => $new_user, 'password' => $new_pass, 'nama' => $new_nama, 'jabatan' => $new_jbt];

    if (empty($new_user) || empty($new_pass) || empty($new_nama)) {
        $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Gagal: Semua kolom wajib diisi.</div>';
    } elseif (isset($_SESSION['users'][$new_user])) {
        $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Gagal: Username sudah terdaftar.</div>';
    } else {
        // Tambahkan user baru ke simulasi database
        $_SESSION['users'][$new_user] = [
            'password' => $new_pass,
            'nama' => $new_nama,
            'jabatan' => $new_jbt
        ];
        $message = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">✅ Akun <strong>' . htmlspecialchars($new_user) . '</strong> berhasil ditambahkan!</div>';
        $form_data = ['username' => '', 'password' => '', 'nama' => '', 'jabatan' => '']; // Reset form
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun Admin - <?= $nama_rs ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        .nav-link.active { color: #0f766e; font-weight: 600; }
        .main-container { padding-top: 80px; }
        .navbar { background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="navbar fixed top-0 w-full flex items-center justify-between px-10 py-3 z-50">
        <div class="flex items-center space-x-3">
            <img src="asf.png" class="h-10" alt="Logo RS">
            <span class="text-gray-800 font-bold text-lg">Sistem Pengaduan RS</span>
        </div>
        <div class="flex items-center space-x-6 text-base font-medium">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="manajemen_komplain.php" class="nav-link">Manajemen Komplain</a>
            <a href="profil.php" class="nav-link">Profil</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <div class="main-container max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-xl shadow-lg mt-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center space-x-3">
                <i class="ri-user-add-line text-teal-600"></i>
                <span>Manajemen Akun Petugas</span>
            </h1>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Buat Akun Petugas Baru</h2>
                <?= $message ?>
                
                <form action="<?= $self_file ?>" method="POST" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($form_data['nama']) ?>"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2" required>
                        </div>
                         <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" value="<?= htmlspecialchars($form_data['jabatan']) ?>"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2" placeholder="Cth: Petugas Pengaduan" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username (Login)</label>
                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($form_data['username']) ?>"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2" required>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" id="password" name="password" value="<?= htmlspecialchars($form_data['password']) ?>"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2" required>
                        </div>
                    </div>

                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2">
                        <i class="ri-save-line"></i><span>Simpan Akun Baru</span>
                    </button>
                </form>
            </div>
            
            <hr class="my-8">

            <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Akun Petugas (Total: <?= count($_SESSION['users']) ?>)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <?php foreach ($_SESSION['users'] as $username => $data): ?>
                        <tr>
                            <td class="py-3 px-4 text-gray-900 font-medium"><?= htmlspecialchars($data['nama']) ?></td>
                            <td class="py-3 px-4 text-gray-600"><?= htmlspecialchars($username) ?></td>
                            <td class="py-3 px-4 text-gray-600"><?= htmlspecialchars($data['jabatan']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>