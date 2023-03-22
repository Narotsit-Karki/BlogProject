  <nav>
    <a href="index.php"><img  src="static/images/logo-16x16.png"> Argon</a>
    <a href="index.php">Home</a>
    <a href="static/template/aboutus.html">About</a>
    <a href="#">Contact</a>
    
    <?php
      if(isset($_COOKIE['uid'])){
        echo "<a href='account.php'>".$_COOKIE['username'] ."</a>";
        echo "<a href='logout.php'>Logout</a>";
      }else{
        echo "<a href='login.php'>Login</a>";
      }
    ?>
  </nav>