<?php

error_reporting(0);

function createPlayfairMatrix($key) {
    $key = str_replace('J', 'I', strtoupper($key)); // Mengganti J dengan I dan mengonversi ke huruf besar
    $key = str_replace(' ', '', $key); // Menghapus spasi
    $key = array_unique(str_split($key)); // Mengonversi ke array, menghapus karakter duplikat, dan mengurutkan
    $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ"; // Alfabet Playfair tanpa J
    $matrix = array();
    $index = 0;

    // Membuat matriks
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if (isset($key[$index])) {
                $matrix[$i][$j] = $key[$index];
                $index++;
            } else {
                $pos = strpos($alphabet, $key[$index - 1]) + 1;
                while (in_array($alphabet[$pos], $key)) {
                    $pos++;
                }
                $matrix[$i][$j] = $alphabet[$pos];
                $pos++;
            }
        }
    }

    return $matrix;
}

function prepareInput($input) {
    $input = strtoupper($input); // Mengonversi ke huruf besar
    $input = str_replace('J', 'I', $input); // Mengganti J dengan I
    $input = preg_replace('/[^A-Z]/', '', $input); // Menghapus karakter non alfabet
    $input = str_split($input); // Memecah input menjadi array
    $pairs = array();

    // Membuat pasangan huruf
    for ($i = 0; $i < count($input); $i += 2) {
        if ($i == count($input) - 1 || $input[$i] == $input[$i + 1]) {
            $input[$i + 1] = 'X';
        }
        $pairs[] = $input[$i] . $input[$i + 1];
    }

    return $pairs;
}

function playfairEncrypt($plaintext, $key) {
    $matrix = createPlayfairMatrix($key);
    $pairs = prepareInput($plaintext);
    $ciphertext = '';

    foreach ($pairs as $pair) {
        $char1 = $pair[0];
        $char2 = $pair[1];
        $pos1 = findCharPosition($matrix, $char1);
        $pos2 = findCharPosition($matrix, $char2);
        $newChar1 = '';
        $newChar2 = '';

        if ($pos1['row'] == $pos2['row']) { // Jika berada di baris yang sama
            $newChar1 = $matrix[$pos1['row']][($pos1['col'] + 1) % 5];
            $newChar2 = $matrix[$pos2['row']][($pos2['col'] + 1) % 5];
        } elseif ($pos1['col'] == $pos2['col']) { // Jika berada di kolom yang sama
            $newChar1 = $matrix[($pos1['row'] + 1) % 5][$pos1['col']];
            $newChar2 = $matrix[($pos2['row'] + 1) % 5][$pos2['col']];
        } else { // Jika membentuk persegi
            $newChar1 = $matrix[$pos1['row']][$pos2['col']];
            $newChar2 = $matrix[$pos2['row']][$pos1['col']];
        }

        $ciphertext .= $newChar1 . $newChar2;
    }

    return $ciphertext;
}

function findCharPosition($matrix, $char) {
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if ($matrix[$i][$j] == $char) {
                return array('row' => $i, 'col' => $j);
            }
        }
    }
}

function playfairDecrypt($ciphertext, $key) {
    $matrix = createPlayfairMatrix($key);
    $pairs = str_split($ciphertext, 2); // Memecah ciphertext menjadi pasangan huruf
    $plaintext = '';

    foreach ($pairs as $pair) {
        $char1 = $pair[0];
        $char2 = $pair[1];
        $pos1 = findCharPosition($matrix, $char1);
        $pos2 = findCharPosition($matrix, $char2);
        $newChar1 = '';
        $newChar2 = '';

        if ($pos1['row'] == $pos2['row']) { // Jika berada di baris yang sama
            $newChar1 = $matrix[$pos1['row']][($pos1['col'] - 1 + 5) % 5];
            $newChar2 = $matrix[$pos2['row']][($pos2['col'] - 1 + 5) % 5];
        } elseif ($pos1['col'] == $pos2['col']) { // Jika berada di kolom yang sama
            $newChar1 = $matrix[($pos1['row'] - 1 + 5) % 5][$pos1['col']];
            $newChar2 = $matrix[($pos2['row'] - 1 + 5) % 5][$pos2['col']];
        } else { // Jika membentuk persegi
            $newChar1 = $matrix[$pos1['row']][$pos2['col']];
            $newChar2 = $matrix[$pos2['row']][$pos1['col']];
        }

        $plaintext .= $newChar1 . $newChar2;
    }

    return $plaintext;
}

// Contoh penggunaan
$key = "KEYWORD";
$plaintext = "HELLO WORLD";
$ciphertext = playfairEncrypt($plaintext, $key);
echo "Plaintext: $plaintext\n";
echo "Key: $key\n";
echo "Ciphertext: $ciphertext\n";

$decryptedText = playfairDecrypt($ciphertext, $key);
echo "Decrypted Text: $decryptedText\n";

?>
