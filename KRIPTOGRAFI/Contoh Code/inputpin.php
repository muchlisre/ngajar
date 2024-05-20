<form method="post" action="">
    <input type="password" name="pin" maxlength="5" placeholder="PIN" required>
</form>

<?php
error_reporting(0);

include 'caesar_chiper.php';
$kunci_pergeseran = 3;

$pass = "udkdv";

if(isset($_POST['pin'])){
    if($pass == caesar_encrypt($_POST["pin"], $kunci_pergeseran)){
        echo "OKK";
    }else{
        echo "FAIL";
    }
}