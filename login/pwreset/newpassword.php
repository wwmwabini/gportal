<?php
session_start();

if(!$_SESSION['user_email'])
{
header("location:resetpassword.html");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>GroupX | Reset Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div id="content">

<h1>Change Password</h1>

<h2>Enter new password</h2>

<p>Enter your email and new password below.</p>

<form action="changepassword.php" method="post" accept-charset="utf-8">
<tr><td>Email*:<br> <input type="text" name="e_mail" required></br></td></tr>
<tr><td>Password*:<br> <input type="password" name="pass1" required></br></td></tr>
<tr><td>Reenter Password*:<br> <input type="password" name="pass2" required></br></td></tr>

<tr><td colspan="1"><br><input type="submit" name="save" align="right" value="Reset">
<input type="reset" name="cancel" align="right" value="Cancel"></br></td></tr>
  
</form>
</div>
</body>
</html>
