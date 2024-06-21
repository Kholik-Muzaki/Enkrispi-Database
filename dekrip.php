<?php
// decrypt_data.php

// Memuat fungsi dekripsi AES
require 'aes_functions.php';
require 'koneksi.php'; // Pastikan ini sesuai dengan konfigurasi koneksi Anda

// Ambil key AES dari environment variable
$key = $_ENV['AES_KEY']; // Sesuaikan dengan cara Anda mendapatkan kunci

// Deklarasi variabel untuk hasil dekripsi
$nama_decrypted = "";
$email_decrypted = "";
$telepon_decrypted = "";

// Fungsi untuk menangani form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data terenkripsi dari form
    $nama_encrypted = $_POST['nama_encrypted'];
    $email_encrypted = $_POST['email_encrypted'];
    $telepon_encrypted = $_POST['telepon_encrypted'];
    $iv_base64 = $_POST['iv'];

    // Dekode IV dari base64 sebelum digunakan
    $iv_decoded = base64_decode($iv_base64);

    // Pastikan IV yang digunakan memiliki panjang yang tepat (16 byte)
    if (strlen($iv_decoded) !== 16) {
        die("IV harus memiliki panjang 16 byte.");
    }

    // Mendekripsi data menggunakan fungsi decryptAES
    $nama_decrypted = decryptAES($nama_encrypted, $key, $iv_decoded);
    $email_decrypted = decryptAES($email_encrypted, $key, $iv_decoded);
    $telepon_decrypted = decryptAES($telepon_encrypted, $key, $iv_decoded);
}
?>

<!-- Form untuk memasukkan data terenkripsi -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dekripsi Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang */
            padding: 20px;
        }

        .card {
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #28a745;
            /* Warna header hijau */
            color: #fff;
            /* Warna teks header putih */
            text-align: center;
            padding: 10px;
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Dekripsi Data</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="nama_encrypted">Data Nama Terenkripsi:</label>
                                <input type="text" class="form-control" id="nama_encrypted" name="nama_encrypted" required>
                            </div>
                            <div class="form-group">
                                <label for="email_encrypted">Data Email Terenkripsi:</label>
                                <input type="text" class="form-control" id="email_encrypted" name="email_encrypted" required>
                            </div>
                            <div class="form-group">
                                <label for="telepon_encrypted">Data Telepon Terenkripsi:</label>
                                <input type="text" class="form-control" id="telepon_encrypted" name="telepon_encrypted" required>
                            </div>
                            <div class="form-group">
                                <label for="iv">IV (Base64):</label>
                                <input type="text" class="form-control" id="iv" name="iv" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Dekripsi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menampilkan hasil dekripsi di bawah form -->
        <?php if ($nama_decrypted !== "") : ?>
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h2 class="text-center">Hasil Dekripsi</h2>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama:</strong> <?php echo $nama_decrypted; ?></p>
                            <p><strong>Email:</strong> <?php echo $email_decrypted; ?></p>
                            <p><strong>Telepon:</strong> <?php echo $telepon_decrypted; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>