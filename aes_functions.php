<?php
// aes_functions.php

// Fungsi untuk mendekripsi data yang telah dienkripsi dengan AES
// Fungsi untuk mendekripsi data yang telah dienkripsi dengan AES
function decryptAES($encryptedData, $key, $iv) {
    // Pastikan IV memiliki panjang yang tepat (16 byte)
    if (strlen($iv) !== 16) {
        die("IV harus memiliki panjang 16 byte.");
    }

    $decrypted = openssl_decrypt(base64_decode($encryptedData), 'aes-256-cbc', $key, 0, $iv);
    return $decrypted;
}


// Fungsi untuk mengenkripsi data menggunakan AES
function encryptAES($data, $key, $iv) {
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted);
}
?>
