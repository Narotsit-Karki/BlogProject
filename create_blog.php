<?php include 'config/db.php'; ?>

<?php session_start() ?>
<?php $error_title = $error_description = $error_content = $error_file = "";?>
<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$title = $_POST['title'];
		$description = $_POST['description'];
		$content = $_POST['content'];
		$error = false;

		if(empty($title)){
			$error_title = 'Please Enter a title of length greater than 10';
			$error = true;
		}

		if(empty($description)){
			$error_description = "Please Enter a description of length greater than 10";
			$error = true;
		}

		if(!empty($_FILES["image"]["name"])){ 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image));
        }else{
        	$error_file = 'Only jpg, png,jpeg,gif files allowed';
        	$error = true;
        }
    }else{
		$error_file = 'Please Select an Image';
		$error = true;
	}
	if(empty($content) || strlen($content) < 100){
			$error_content = "Please Enter a content of length greater than 100";
			$error = true;
		}

	if(!$error){
		
		$uid = $_COOKIE['uid'];
		$sql = "INSERT INTO tbl_blog(title,description,content,blog_image,user) VALUES ('$title','$description','$content','$imgContent','$uid')";
		if(mysqli_query($conn,$sql)){
			$_SESSION['message'] = 'Blog Posted Successfully';
			header('location:index.php');
		}else{
			$_SESSION['message'] = 'Blog not Posted Please Try again';
		}
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="static/css/blog_style.css">
	<link rel="stylesheet" type="text/css" href="static/css/style.css">
	<style type="text/css">
		
label{
	margin-top:30px;
}

	</style>
</head>
<body>
	<?php include "nav.php"; ?>
	<?php include "message.php"; ?>
	<div>
		<h1>Create Blog</h1>
	</div>	
	
	<form style="margin-bottom:10px;" enctype="multipart/form-data" method="POST">
		<label>Blog Title:</label>
		<input type='text' name='title'>
		<span class='error'><?php echo $error_title; ?></span>

		<label>Blog Description:</label>
		<textarea name='description' rows='4'></textarea>
		<span class='error'><?php echo $error_description; ?></span>

		<label>Blog Image:</label>
		<input type="file" accept="image/*" name="image">
		<span class='error'><?php echo $error_file; ?></span>

		<label>Blog Content:</label>
		<textarea name="content"></textarea>
		<span class='error'><?php echo $error_content; ?></span>
		<input type="submit" name="submit" value="post">

	</form>
	<?php include "footer.php"; ?>
</body>
</html>