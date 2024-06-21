<?php
require 'koneksi.php';
require 'aes_functions.php'; // Memuat fungsi enkripsi/dekripsi AES

$id = $_POST['id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];

// Ambil key AES dari environment variable
$key = $_ENV['AES_KEY']; // Ambil nilai dari environment variable

// Key dan IV untuk enkripsi AES (harus sama saat enkripsi dan dekripsi)
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Mengenkripsi data sebelum disimpan ke database
$nama_encrypted = encryptAES($nama, $key, $iv);
$email_encrypted = encryptAES($email, $key, $iv);
$telepon_encrypted = encryptAES($telepon, $key, $iv);

// Mengubah IV menjadi base64 untuk disimpan ke database
$iv_base64 = base64_encode($iv);

// Query untuk menyimpan data terenkripsi ke database
$sql = "UPDATE users SET nama=?, email=?, telepon=?, iv=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nama_encrypted, $email_encrypted, $telepon_encrypted, $iv_base64, $id);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
