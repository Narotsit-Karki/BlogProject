	
	<?php 
		if(isset($_SESSION['message'])){ 
			echo "<div class='message'>".$_SESSION['message']."</div>";
		} 
	?>