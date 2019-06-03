<?php
//set variables
$host="localhost";
$user="root";
$pass="";
$db="groupx";
//establish connection to database
$link=mysqli_connect("$host","$user","$pass","$db");
if($link===false){
	die("Sorry. Could not open database.".mysql_connect_error());
  }
?>
