
<?php include "config/db.php" ?>
<?php

	if($_SERVER['REQUEST_METHOD'] == "GET"){
		$blog_id = $_GET['blog_id'];
		$uid = $_COOKIE['uid'];
		$result = mysqli_query($conn,"SELECT * FROM tbl_blog WHERE blog_id = $blog_id AND user = $uid") or die("Error Occurred");
		
		if(mysqli_num_rows($result) > 0 ){

			$sql = "DELETE FROM tbl_blog WHERE user = $uid AND blog_id = '$blog_id'";
			$result = mysqli_query($conn,$sql) or die("Some Error Occurred");
			if(mysqli_affected_rows($conn) > 0){
				session_unset();
				$_SESSION['message'] = "Blog Deleted Successfully";
			}else{
				$_SESSION['message'] = "Blog Couldnot be Deleted";
			}
			header('location:'.$_SERVER['HTTP_REFERER']);
	}
}
?>