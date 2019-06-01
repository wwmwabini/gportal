<?php
//establish connection to database
require '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") 
{

//get email and password of user
$login_email = mysqli_real_escape_string($link,$_POST['username']);
$login_pass = mysqli_real_escape_string($link,$_POST['pass']); 

//query database to see if details obtained are in database  
$sql = "SELECT number, role FROM members WHERE email = '$login_email' and password = '$login_pass'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

//count rows in the query. if result matched details, then there can only exist 1 row matching
$count = mysqli_num_rows($result);
 	
if($count == 1) {

    $userrole=$row['role']; 

    if ($userrole == "ADMIN") {
	//use global variabe $_SESSION to set session variables
	session_start();
	$_SESSION['login_email'] = $login_email;
        header("location:../root-int");

    }else if ($userrole == "MEMBER"){
	//use global variabe $_SESSION to set session variables
	session_start();
	$_SESSION['login_email'] = $login_email;
        header("location:../user");

    }else{
	header("location:../login");
	echo "Not exisistent";
     	//display error message "Account not active. Contact admin"
	}

}else{
	//header("location:../includes/failloginalert.html");	
	header("location:../login");
    }
}

?>
