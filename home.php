<?php 
	session_start();
	if(empty($_SESSION["token"])){
		header("Location:login.php");
	}
	echo "Your Token : ".$_SESSION["token"]."<br>";
	echo "<a href='login.php'>Logout</a>";
?>