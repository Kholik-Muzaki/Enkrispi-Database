<?php
require 'koneksi.php';
require 'aes_functions.php'; // Memuat fungsi enkripsi/dekripsi AES

// Mendapatkan data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];

// Key dan IV untuk enkripsi AES (harus sama saat enkripsi dan dekripsi)
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Mengenkripsi data sebelum disimpan ke database
$nama_encrypted = encryptAES($nama, $key, $iv);
$email_encrypted = encryptAES($email, $key, $iv);
$telepon_encrypted = encryptAES($telepon, $key, $iv);

// Mengubah IV menjadi base64 untuk disimpan ke database
$iv_base64 = base64_encode($iv);

// Query untuk menyimpan data terenkripsi ke database
$sql = "INSERT INTO users (nama, email, telepon, iv) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nama_encrypted, $email_encrypted, $telepon_encrypted, $iv_base64);

if ($stmt->execute()) {
    // Redirect ke halaman index.php jika data berhasil ditambahkan
    header('Location: index.php');
    exit();
} else {
    echo "Gagal menambahkan data: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
