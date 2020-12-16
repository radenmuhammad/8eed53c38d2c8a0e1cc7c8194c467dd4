<?php 
	session_start();
?>
<html>
	<body>
		<form id="signup" name="signup" method="POST" action="">
			Email : <input type="text" id="email" name="email" value=""/><br><br>
			Password : <input type="password" id="password" name="password" value=""/><br>
			<input type="submit" id="signup" name="signup" value="Sign Up"/>
		</form>
	</body>
</html>
<?php 
	if(!empty($_REQUEST)){
		$user_name = "root";
		$password = "";
		$database = "rest_api";
		$host_name = "localhost";
		$con = mysqli_connect($host_name, $user_name, $password,$database) or die("gagal, database tidak ditemukan");
		$f = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE email='".$_REQUEST['email']."'"));
		if(empty($f)){
			$token = "";
			$token = rand().rand().time();
			$fx = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE token='".$token."'"));
			while(!empty($fx)){
				$token = rand().rand().time();
				$fx = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE token='".$token."'"));
			}			
			mysqli_query($con,"INSERT INTO users (email, 
			                                      password,
												  token) 
			                   VALUES('".$_REQUEST['email']."',
							  '".md5($_REQUEST['password'])."',
							  '".$token."'
							  )");
			$_SESSION['token'] = $token;				  
			header("Location:home.php");					
		}else{
			echo "this email is already exists";
		}
	}
?>