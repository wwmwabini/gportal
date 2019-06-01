<?php
function rand_string($length) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789!@#$%^&*()+={}[]><?/~";
    return substr(str_shuffle($chars),0,$length);

}

$keygen = rand_string(10);

echo "\n";
?>
