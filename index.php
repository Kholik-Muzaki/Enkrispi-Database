<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Users</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang */
        }

        .page-header {
            background-color: #007bff;
            /* Warna header */
            color: #fff;
            /* Warna teks header */
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-group {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Daftar Siswa</h2>
                    <p>Ini adalah daftar siswa yang terdaftar dalam sistem.</p>
                </div>
                <div class="text-center mb-3">
                    <a href="tambah.php" class="btn btn-success">Tambah Siswa</a>
                </div>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Email Siswa</th>
                            <th>Telepon Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'koneksi.php';
                        require 'aes_functions.php'; // Memuat fungsi enkripsi/dekripsi AES

                        // Ambil key AES dari environment variable
                        $key = $_ENV['AES_KEY']; // Ambil nilai dari environment variable

                        $sql = "SELECT id, nama, email, telepon, iv FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Mendekripsi data yang diambil dari database
                                $nama_decrypted = decryptAES($row['nama'], $key, base64_decode($row['iv']));
                                $email_decrypted = decryptAES($row['email'], $key, base64_decode($row['iv']));
                                $telepon_decrypted = decryptAES($row['telepon'], $key, base64_decode($row['iv']));

                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($nama_decrypted) . "</td>";
                                echo "<td>" . htmlspecialchars($email_decrypted) . "</td>";
                                echo "<td>" . htmlspecialchars($telepon_decrypted) . "</td>";
                                echo "<td class='btn-group'>
                                        <a href='detail.php?id=" . $row['id'] . "' class='btn btn-info btn-sm mr-1'>Detail</a>
                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm mr-1'>Edit</a>
                                        <a href='hapus.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Belum ada data siswa</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>