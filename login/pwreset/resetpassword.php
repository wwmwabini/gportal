<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../../includes/config.php";
include "../../includes/common.php";

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
//get user email
$user_email = mysqli_real_escape_string($link,$_POST['e_mail']);

//query db for existance of email
$sql = "SELECT * FROM members WHERE email = '$user_email'";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $user_name=$row['name'];
}

//count rows in the query. if result matched details, then there can only exist 1 row matching
$count = mysqli_num_rows($result);

if($count == 1) {
//script to mail reset link
require_once "keygenerator.php";
// Create the unique user password reset key. $keygen is obtained from keygenerator.php
$resetkey = md5($keygen);
$requesttime=date("H:i:s");
$expirytime=date('Y-m-d H:i:s', time()+3600);
$requestdate=date("Y-m-d");

// Create a url to direct users to page to reset their password and save it to database
$finalkey="key=&time=$requesttime-&date=$requestdate-&key=$resetkey";
$urlseparator = "/";
$pwreset = "/login/pwreset/?";
$pwreseturl = "http://".$installurl.$urlseparator.$installdir.$urlseparator.$pwreset.$finalkey;


$sql="UPDATE `members` SET resetkey='$finalkey', expires='$expirytime' WHERE email='$user_email'";
mysqli_query($link,$sql);

// Mail them their key :CONTAINS - NAME, LINK

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

require '../../includes/PHPMailer/src/PHPMailer.php';
require '../../includes/PHPMailer/src/SMTP.php';
require '../../includes/PHPMailer/src/Exception.php';

$mail = new PHPMailer();                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = false;                                 // Enable verbose debug output
    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host = 'pld101.truehost.co.ke';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'no-reply@rawle.systems';       // SMTP username
    $mail->Password = 'Dxv1EEpyOYPI';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('no-reply@rawle.systems', $mailas);
    $mail->addAddress($_POST['e_mail']);

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $companyname.' Password Reset';
    $mail->Body    = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='../style.css'>
    <link rel='stylesheet' type='text/css' href='../center.css'>
    
</head>

<body>
<div id='content'>

<h1 align='center'>$companyname Password Reset Instructions</h1>

<p>Dear $user_name,<br><br>You have requested to reset your $companyname password. If you have not made this request, ignore this message. It will be useless in 1 hour.<br><br>To reset your password, please click the link below:

<p align='center'>$pwreseturl</p> 

<p>If you cannot click it, please paste it into your web browser address bar. Once you access the link, you will get a chance to reset your password.</b></p>

<br><br>Regards,<br>Admin</p>
<br><b><br>$companyname</b></p>

</body>
</html>";

    $mail->send();
    echo 'OK! Please check your email for password reset instructions.';

} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}
else{
echo "The email address you entered does not exist in the system. <a href='resetpassword.html' >Click here</a> to enter again!";
}
}
?>
