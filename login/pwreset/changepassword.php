<?php

require '../groupx-config.php';

//IMPLEMENT HOW TO CHECK WHETHER RESET KEY IN THE URL IS VALID. CHECK IF THIS CAN BE IMPLEMENTED IN AN IF STATEMENT AFTER if($count==1){

$mail=mysqli_real_escape_string($link,$_POST['e_mail']);
$pswd1=mysqli_real_escape_string($link,$_POST['pass1']);
$pswd2=mysqli_real_escape_string($link,$_POST['pass2']);

//test if email exists in database
$sql="SELECT * FROM members WHERE email='$mail'";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$count = mysqli_num_rows($result);
if($count==1){
//test here if pswd1=pswd2 
if($pswd1==$pswd2)
{
$sql="UPDATE `members` SET password='$pswd1' WHERE email='$mail'";
}

if(mysqli_query($link,$sql)){
	$timenow=date('Y-m-d H:i:s');
        $sql="UPDATE `members` SET expires='$timenow' WHERE email='$mail'";
        mysqli_query($link,$sql);
echo "You have successfully reset your password. You can now <a href='../groupx-member'>Log In Here</a>.";

}
else{
	echo "ERROR. Passwords don't match.";
}
}
else{
echo "ERROR. Email does not exist in database. ";
}

mysqli_close($link);

?>
