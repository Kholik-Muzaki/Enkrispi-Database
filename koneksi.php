<?php
// koneksi.php

require_once __DIR__ . '/vendor/autoload.php'; // Load library PHP dotenv
use Dotenv\Dotenv;

// Load nilai dari file .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Setup koneksi ke database
$db_host = 'localhost'; // Sesuaikan dengan host database Anda
$db_user = 'root';// Sesuaikan dengan username database Anda
$db_pass = ''; // Sesuaikan dengan password database Anda
$db_name = 'bismillah';// Sesuaikan dengan nama database Anda

// Buat koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil key AES dari environment variable
$key = $_ENV['AES_KEY']; // Ambil nilai dari environment variable
?>
