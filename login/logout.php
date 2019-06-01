<?php
session_start();
session_destroy();
unset($_SESSION['login_email']);  
header("location:../login");
?>
