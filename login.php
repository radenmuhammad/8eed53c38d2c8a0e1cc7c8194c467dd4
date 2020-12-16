<?php
	session_start();
?>
<form action="" method="POST">
	Email:<br>
	<input type="text" id="email" name="email" value=""/>
	<br>Password:<br>	
	<input type="text" id="password" name="password" value=""/><br>
	<input type="submit" id="login" value="Login"/>	
	<input type="button" id="signup" value="Sign Up" onClick="document.location.href='signup.php';"/>	
</form>
<?php
	if(!empty($_REQUEST)){
		$user_name = "root";
		$password = "";
		$database = "rest_api";
		$host_name = "localhost";		
		$con = mysqli_connect($host_name, $user_name, $password,$database) or die("gagal, database tidak ditemukan");
		$f = mysqli_fetch_array(mysqli_query($con,"
			SELECT * FROM users 
			WHERE email='".$_REQUEST['email']."'
			AND password='".md5($_REQUEST['password'])."'
			"));
		if(!empty($f)){
			print_r ($f);
			$_SESSION['token'] = $f['token'];				  			
			header("Location:home.php");
		}else{
			echo "invalid email or password";
		}	
	}
?>