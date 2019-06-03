<?php
session_start();
session_destroy();
unset($_SESSION['login_email']);  

require '../../includes/common.php';

header("location: http://$installurl/$installdir");
exit;
?>
