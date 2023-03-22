<?php
		$blog_id = $row['blog_id'];
 		echo '<div class="blog-post">';
	    echo '<h2 class="blog-title">' . $row['title'] . '</h2>';
	    echo '<p class="blog-user">By ' . $_COOKIE['username']. ' on ' . date('F j, Y', strtotime($row['created_at'])) . '</p>';
	  	echo '<img class="blog-image" src="data:image/*;base64,' .  base64_encode($row['blog_image'])  . '" />';
	    echo '<p class="blog-description">' . $row['description'] . '</p>';
	    if($_COOKIE['uid'] == $row['user']){
	    	echo "<a type='button' class='delete' href='delete_blog.php?blog_id= $blog_id'> Delete </a>";
	    	echo "<a type='button' class='edit' href='edit_blog.php?blog_id= $blog_id''> Edit </a>";
	    }
	    echo '</div>';
?>