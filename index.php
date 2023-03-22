<?php include "config/db.php"; ?>
<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="static/css/blog_style.css">
	<link rel="stylesheet" type="text/css" href="static/css/style.css">
	
</head>

<body>
	<?php include "nav.php"; ?>
	<?php include "message.php"; ?>
	<div>
		<h1>Latest Blog</h1>
	</div>
	
	<?php
	
	$sql = "SELECT * FROM tbl_blog ORDER BY created_at DESC";
	$result = mysqli_query($conn, $sql);

	
	while ($row = mysqli_fetch_assoc($result)) {
		$id = $row['user'];
		$sql = "SELECT username from tbl_user WHERE uid = '$id' ";
		$user = mysqli_query($conn,$sql);
		$user = mysqli_fetch_assoc($user);
		$blog_id = $row['blog_id'];

	    echo '<div class="blog-post">';
	    echo '<h2 class="blog-title">' . $row['title'] . '</h2>';
	    echo '<p class="blog-user">By ' . $user['username'] . ' on ' . date('F j, Y', strtotime($row['created_at'])) . '</p>';
	  	echo '<img class="blog-image" src="data:image/*;base64,' .  base64_encode($row['blog_image'])  . '" />';
	    echo '<p class="blog-description">' . $row['description'] . '</p>';
	    echo "<a type='button' class='view' href='single_blog.php?blog_id=$blog_id'> View </a>";
	    if(isset($_COOKIE['uid']) and $_COOKIE['uid'] == $row['user']){
	    	echo "<a type='button' class='delete' href='delete_blog.php?blog_id=$blog_id'> Delete </a>";
	    	echo "<a type='button' class='edit' href='edit_blog.php?blog_id=$blog_id'> Edit </a>";
	    }
	    echo '</div>';
	}

	mysqli_close($conn);
?>
<?php include "footer.php" ?>
</body>
</html>
