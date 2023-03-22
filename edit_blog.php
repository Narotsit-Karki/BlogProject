<?php include "config/db.php" ?>
<?php $error_title = $error_description = $error_content = $error_file = ""; ?>


<?php 

		$blog_id = $_GET['blog_id'];
		$result = mysqli_query($conn,"SELECT * FROM tbl_blog WHERE blog_id = $blog_id") or die("Some Error Occurred");
		$data = mysqli_fetch_assoc($result);

	
?>

<?php

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$title = $_POST['title'];
		$description = $_POST['description'];
		$content = $_POST['content'];
		$error = false;
		$imgContent = "";

		if(empty($title)){
			$title = $data['title'];
		}

		
		if(empty($title)){
			$description = $data['description'];
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
    }

	if(empty($content)){
			$content = $data['content'];
		}elseif(strlen($content) < 100){
			$error = true;
			$error_content = "Write Content of length greater than 100";
		}

	if(!$error){
		$uid = $_COOKIE['uid'];
		
		if(empty($_FILES["image"]["name"])){
			$sql = "UPDATE tbl_blog SET title='$title', description='$description',content = '$content' WHERE blog_id =$blog_id AND user=$uid";
		}else{
			$sql = "UPDATE tbl_blog SET title='$title', description='$description',content = '$content',blog_image = '$imgContent' WHERE blog_id =$blog_id AND user=$uid";
		}
	
		if(mysqli_query($conn,$sql)){
			session_unset();
			$_SESSION['message'] = 'Blog Updated Successfully';
			header('location:index.php');
		}else{
			$_SESSION['message'] = 'Blog not Updated Please Try again';
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
		<h1>Edit Blog <?php echo $data['title']; ?></h1>
	</div>	
	
	<form style="margin-bottom:10px;" enctype="multipart/form-data" method="POST">
		<label>Blog Title:</label>
		<input type='text' name='title' value='<?php echo $data['title']; ?>'>
		<span class='error'><?php echo $error_title; ?></span>

		<label>Blog Description:</label>
		<textarea name='description' rows='4'><?php echo $data['description']; ?></textarea>
		<span class='error'><?php echo $error_description; ?></span>

		<label>Blog Image:</label>
		<input type="file" accept="image/*" name="image">
		<span class='error'><?php echo $error_file; ?></span>

		<label>Blog Content:</label>
		<textarea name="content"><?php echo $data['content']; ?></textarea>
		<span class='error'><?php echo $error_content; ?></span>
		<input type="submit" name="submit" value="post">

	</form>
	<?php include "footer.php"; ?>
</body>
</html>
