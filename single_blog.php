<?php include "config/db.php"; ?>
<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="static/css/blog_style.css">
	
</head>

<body>
	<?php include "nav.php"; ?>
	
	
<?php  
	$blog_id = $_GET['blog_id'];
	$result = mysqli_query($conn,"SELECT * FROM tbl_blog WHERE blog_id = $blog_id") or die("Some error occurred");
	$row = mysqli_fetch_assoc($result);
 	echo '<div class="blog-post">';
	echo '<h2 class="blog-title">' . $row['title'] . '</h2>';
	echo '<p class="blog-user">By ' . $_COOKIE['username']. ' on ' . date('F j, Y', strtotime($row['created_at'])) . '</p>';
	echo '<img class="blog-image" src="data:image/*;base64,' .  base64_encode($row['blog_image'])  . '" />';
	echo '<p class="blog-description">' . $row['description'] . '</p>';
	echo '<p class="blog-content">' . $row['content'] . '</p>';
?>

</body>
</html>
