<?php session_start(); ?>
<?php
  
  if(!isset($_COOKIE['uid'])){
    $_SESSION['message'] = 'Login First!';
    header('location:login.php');
  }
?>