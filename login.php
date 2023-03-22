
<?php
	session_start();
	
?>

<?php
$error_password = $error_username = "";

if($_SERVER['REQUEST_METHOD'] ==  "POST"){
	$username = $_POST['username'];
	$pass = $_POST['password'];
	$valid = true;
	
	if(empty($username)){
		$error_username = "enter the username";
		$valid = false;
	}

	if(empty($pass)){
		$error_password =  "enter password";
		$valid =  false;
	}

	if($valid){
	$conn = mysqli_connect("localhost","root","",'Blog') or die(mysqli_connect_error());
	$sql = "SELECT * from tbl_user WHERE username = '$username'";
	$result = mysqli_query($conn,$sql) or die('some error occurred');
	if(mysqli_num_rows($result) == 0){
		$error_username = "username doesnot exist";
	}else{
		$result = mysqli_fetch_assoc($result);
		if(!password_verify($pass, $result['password'])){
			$error_password =  "password not valid";	
		}else{
			setcookie('uid',$result['uid'],time() + (8600 * 30));
			setcookie('username',$result['username'],time() + (8600 * 30));
			setcookie('email',$result['email'],time() + (8600 * 30));
			$_SESSION['message'] = "Welcome, $username";
			
			header('location:index.php');
		}
	}
	}}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="static/css/style.css">
	<link rel="stylesheet" type="text/css" href="static/css/blog_style.css">
</head>
<body>
	<?php include 'nav.php'; ?>
	<form action="login.php" method = "POST">
		<header>
			<div class="logo">
				<img src="static/images/logo-64x64.png" alt='Argon'>
				<h1>Argon</h1>
			</div>
		</header>		
			<?php include "message.php";?>
			<p><b>Welcome Back</b></p>

		<label for="username">Username:</label>
		<input class='input_focus' type="text" id="username" name="username">
		<span id='error_3'><?php echo $error_username; ?></span>

		<label for="password">Password:</label>
		<input class='input_focus' type="password" id="password" name="password">
		<span id='error_5'><?php echo $error_password; ?></span>

		<input type="submit" value="Login" id='submit'>
		<div style="margin-top: 8px;text-align: center;">
			Not Joined ? <a href="register.html" style="text-decoration: none;"> Join us </a>
		</div>
	</form>
</body>
</html>


