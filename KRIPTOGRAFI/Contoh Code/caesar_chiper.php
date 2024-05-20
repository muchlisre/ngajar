<?php

// Fungsi untuk melakukan enkripsi menggunakan Caesar Cipher
function caesar_encrypt($plain_text, $shift) {
    $encrypted_text = "";
    $length = strlen($plain_text);
    for ($i = 0; $i < $length; $i++) {
        $char = $plain_text[$i];
        // Periksa apakah karakter merupakan huruf alfabet
        if (ctype_alpha($char)) {
            // Enkripsi hanya dilakukan pada huruf alfabet
            $offset = ord(ctype_upper($char) ? 'A' : 'a');
            $encrypted_text .= chr((ord($char) + $shift - $offset) % 26 + $offset);
        } else {
            // Karakter selain huruf tidak dienkripsi
            $encrypted_text .= $char;
        }
    }
    return $encrypted_text;
}

// Fungsi untuk melakukan dekripsi menggunakan Caesar Cipher
function caesar_decrypt($encrypted_text, $shift) {
    return caesar_encrypt($encrypted_text, 26 - $shift); // Dekripsi adalah enkripsi dengan pergeseran kebalikan
}

// Contoh penggunaan
$pesan_awal = "PESAN RAHASIA";
$kunci_pergeseran = 3;

// Encoding (Enkripsi)
$pesan_terenkripsi = caesar_encrypt($pesan_awal, $kunci_pergeseran);
echo "Pesan terenkripsi: " . $pesan_terenkripsi . "<br>";

// Decoding (Dekripsi)
$pesan_terdekripsi = caesar_decrypt($pesan_terenkripsi, $kunci_pergeseran);
echo "Pesan terdekripsi: " . $pesan_terdekripsi;

?>


