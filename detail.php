<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang */
            padding: 20px;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            /* Warna header */
            color: #fff;
            /* Warna teks header */
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
        <div class="card">
            <div class="card-header">
                <h2>Detail User</h2>
            </div>
            <div class="card-body">
                <?php
                require 'koneksi.php';
                require 'aes_functions.php'; // Memuat fungsi enkripsi/dekripsi AES

                $id = $_GET['id'];

                $sql = "SELECT * FROM users WHERE id = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Ambil key AES dari environment variable
                    $key = $_ENV['AES_KEY']; // Ambil nilai dari environment variable

                    // Mendekripsi data yang diambil dari database
                    $nama_decrypted = decryptAES($row['nama'], $key, base64_decode($row['iv']));
                    $email_decrypted = decryptAES($row['email'], $key, base64_decode($row['iv']));
                    $telepon_decrypted = decryptAES($row['telepon'], $key, base64_decode($row['iv']));

                    echo "<div class='row'>";
                    echo "<div class='col-md-4'><strong>ID:</strong></div>";
                    echo "<div class='col-md-8'>" . $row['id'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-4'><strong>Nama:</strong></div>";
                    echo "<div class='col-md-8'>" . htmlspecialchars($nama_decrypted) . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-4'><strong>Email:</strong></div>";
                    echo "<div class='col-md-8'>" . htmlspecialchars($email_decrypted) . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-4'><strong>Telepon:</strong></div>";
                    echo "<div class='col-md-8'>" . htmlspecialchars($telepon_decrypted) . "</div>";
                    echo "</div>";
                } else {
                    echo "<p class='text-danger'>User tidak ditemukan.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>