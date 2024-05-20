<?php
error_reporting(0);

include 'caesar_chiper.php';
$kunci_pergeseran = 3;

$pass = "ndwd udkdvld";

$pass_input = $_GET['pass'];

if(isset($pass_input)){
    if($pass == caesar_encrypt($pass_input, $kunci_pergeseran)){
        echo "Password benar";
    }else{
        echo "Password salah";
    }
}elseif(isset($_GET['token'])){
    // echo $_GET['token'];
    echo caesar_decrypt($_GET['token'], $kunci_pergeseran);
}

?>


