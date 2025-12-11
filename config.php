<?php
// config.php
session_start();

$nama_rs = "Rumah Sakit";
$self_file = basename($_SERVER['PHP_SELF']);

// --- DATABASE SIMULASI USER ---
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'admin' => ['password' => 'admin123', 'nama' => 'Administrator', 'jabatan' => 'Petugas Pengaduan'],
    ];
}

/**
 * Fungsi untuk memeriksa apakah pengguna sudah login
 * Jika belum, akan dialihkan ke halaman login
 */
if (!function_exists('check_login')) { // <-- PENGAMANAN TAMBAHAN
    function check_login() {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Izinkan login.php diakses tanpa perlu login
            if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
                header('Location: login.php');
                exit;
            }
        }
    }
}

/**
 * Fungsi untuk mendapatkan data user yang sedang login
 */
if (!function_exists('get_current_user')) { // <-- PENGAMANAN TAMBAHAN
    function get_current_user() {
        if (isset($_SESSION['username'])) {
            // Memastikan data user ada di session, lalu mengembalikan data
            if (isset($_SESSION['users'][$_SESSION['username']])) {
                return $_SESSION['users'][$_SESSION['username']];
            }
        }
        return null;
    }
}
?>