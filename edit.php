<?php
require 'koneksi.php';
require 'aes_functions.php'; // Pastikan path ini benar

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Ambil key AES dari environment variable
    $key = $_ENV['AES_KEY']; // Pastikan variabel ini mengambil kunci yang tepat dari .env

    // Mendekripsi data yang diambil dari database
    $nama_decrypted = decryptAES($row['nama'], $key, base64_decode($row['iv']));
    $email_decrypted = decryptAES($row['email'], $key, base64_decode($row['iv']));
    $telepon_decrypted = decryptAES($row['telepon'], $key, base64_decode($row['iv']));

    // Tampilkan form untuk edit data
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f8f9fa; /* Warna latar belakang */
                padding: 20px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header bg-primary text-white">
                            <h2 class="text-center">Edit User</h2>
                        </div>
                        <div class="card-body">
                            <form action="proses_edit.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama_decrypted; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email_decrypted; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $telepon_decrypted; ?>" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    echo "User tidak ditemukan.";
}

$conn->close();
?>
