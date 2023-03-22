<?php session_start(); ?>
<?php
function validate_form($conn){
		$json = file_get_contents('php://input');
		$_data = json_decode($json,true);

		$username = filter_var($_data['username'],FILTER_SANITIZE_STRING);
		$email = filter_var($_data['email'],FILTER_SANITIZE_EMAIL);
		$pass = filter_var($_data['password'],FILTER_SANITIZE_STRING);
		$c_pass = filter_var($_data['confirm_password'],FILTER_SANITIZE_STRING);

		

		if(empty($username) or empty($username) or empty($email) or empty($pass) or empty($c_pass)){
				$GLOBALS['error'] = "Error: Please enter all data";
				return false;
		}
		
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$GLOBALS['error'] = "Error: Please enter a valid email";
			return false;
		}

		if(strlen($pass) < 8){
			$GLOBALS['error'] = "Error: Please enter a password with length greater than 8";
			return false;
		}
		elseif($pass != $c_pass){
			$GLOBALS['error'] = "Error: password donot match";
			return false;
		}

		
		$sql = "SELECT * from tbl_user WHERE username = '$username'";
		$result = mysqli_query($conn,$sql) or die('error occurred');
		if(mysqli_num_rows($result) > 0 ){
			$GLOBALS['error'] = "Error: Username '$username' already exists";
			return false;
		}
		$sql = "SELECT * from tbl_user WHERE email = '$email'";
		$result = mysqli_query($conn,$sql) or die('error occurred');
		if(mysqli_num_rows($result) > 0){
			$GLOBALS['error'] = "Error: Email '$email' already exists";
			return false;
		}
		
		$pass = password_hash($pass, PASSWORD_DEFAULT);

		$sql= "INSERT INTO tbl_user(username,email,password) VALUE('$username','$email','$pass')";
		
		if(mysqli_query($conn,$sql)){
			return true;
		}else{
			$GLOBALS['error'] = "Error: couldnot register please try again";
			return false;
		}
	}
?>

<?php 
	define('host','localhost');
	define('user','root');
	define('db_password','');
	define('database','Blog');
	$error = "";
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$conn = mysqli_connect(host,user,db_password,database) or die(mysqli_connect_error());
		if(validate_form($conn)){
			$_SESSION['message'] = 'Registered Successfully';
			echo  json_encode("Success: Registered Successfully");
		}else{
			echo json_encode($error);
		}

	}else{
		header("location:http://localhost/WebProject/static/template/405.html");
	}
?>