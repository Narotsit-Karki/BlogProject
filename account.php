<?php include "config/db.php"; ?>

<?php include "auth_check.php"; ?>
<?php 

  $error_old_pass = $error_new_pass = $error_email = $error_username = '';

  $uid = $_COOKIE['uid'];
  $sql = "SELECT * FROM tbl_user WHERE uid =$uid";
  $result = mysqli_query($conn,$sql) or die("Some Error Occurred");
  if(mysqli_num_rows($result) != 0){
    $user  = mysqli_fetch_assoc($result);
  }
?>

<?php 

  function check_duplicate($conn,$sql){
    $result = mysqli_query($conn,$sql) or die("Error Occurred");
    if(mysqli_num_rows($result) > 0){
      return true;
    }
    return false;
  }


// Updating Information
 if($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['submit_1'])){
      $username = $_POST['username'];
      $email = $_POST['email'];
      $valid = true;

      if(empty($username)){
        $username = $_COOKIE['username'];
      }

      if(empty($email)){
        $email = $_COOKIE['email'];
      }

      $sql = "SELECT * FROM tbl_user WHERE username='$username' AND uid != $uid";
      
      
      if(check_duplicate($conn,$sql)){
        $error_username = "Username ".$username." Already Exists";
        $valid = false;
      }

      $sql = "SELECT * FROM tbl_user WHERE email='$email' AND uid !=$uid";
      $duplicate = check_duplicate($conn,$sql);
      if(check_duplicate($conn,$sql)){
        $error_email = "Email ".$email." Already Exists";
        $valid = false;
      }

      if($valid){
        $sql =  "UPDATE tbl_user SET username = '$username' , email = '$email' WHERE uid = $uid";
        session_unset();
        if(mysqli_query($conn,$sql)){
          setcookie("username",$username,time() + (8600 * 30));
          setcookie("email",$email,time() + (8600 * 30));
          $_SESSION['message'] = "Account Information Updated Successfully";
        }else{
          $_SESSION['message'] = "Account Update UnSuccessfull";
        }
      }
    }

?>

 <?php
    // Updating Password
    if($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['submit_2'])){
      $old_pass = $_POST['old_password'];
      $new_pass = $_POST['new_password'];
      $valid = true;
      session_unset();

      if(empty($old_pass)){
        $error_old_pass = "Please Enter Old Password";  
        $valid = false;
      }
      
      if(empty($new_pass)){
        $error_new_pass = "Please Enter New Password";  
        $valid = false;
      }
      
      $sql = "SELECT password FROM tbl_user WHERE uid = $uid";
      $result = mysqli_query($conn,$sql) or die("Some Error Occurred");
      $data = mysqli_fetch_assoc($result);

      if($valid){
        if(password_verify($old_pass, $data['password'])){
            $password = password_hash($new_pass, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_user SET password = '$password' WHERE uid = '$uid' ";
            session_unset();
            if(mysqli_query($conn,$sql)){
              header("location:logout.php");
              }else{
              $_SESSION['message'] = 'Password Update UnSuccessfull!';
              
            }
          }else{
            $error_old_pass = "Old password donot match";
          }
      }
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>User Account Page</title>
    <link rel="stylesheet" href="static/css/account.css">
    <link rel="stylesheet" type="text/css" href="static/css/blog_style.css">
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
    <style type="text/css">
        .flex-container {
      display: flex;
      padding: 10px;
}

  .flex-child {
     flex: 1;

    }  

.flex-child:first-child {
    margin-right: 20px;
}
    </style>
  </head>
  <body>
    
    <?php include "nav.php"; ?> 
    <?php include "message.php"; ?>
    
    <div class="header">
      <h1>Account, <?php echo $_COOKIE['username']; ?></h1>
    </div>
    <div class="flex-container">
      
        <div class='flex-child'>
        <form action="account.php" method="POST">
          <label for="username">Username:</label>
          <input class='input_focus' type="text" id="username" name="username" value='<?php echo $user['username']; ?>'
          >
          <span id='error_3'>
            <?php echo $error_username; ?>
          </span>

          <label for="email">Email:</label>
          <input class='input_focus'type="text" id="email" name="email"
          value='<?php echo $user['email']; ?>'>
          <span id='error_4'>
            <?php echo $error_email; ?>
          </span>
          <input type="submit" value="update info" name='submit_1'>
          </form>

          <form action="account.php" method = "POST"> 
          <label for="password">Old Password:</label>
          <input class='input_focus' type="password" id="password" name="old_password">
          <span id='error_5'>
            <?php echo $error_old_pass; ?>
          </span>
  

          <label for="confirm_password">New Password:</label>
          <input class='input_focus' type="password" id="confirm_password" name="new_password">
          <span id='error_6'>
            <?php echo $error_new_pass; ?>
          </span>
           <input type="submit" value="update password" name='submit_2'>
          </form>
        </div>

        <div class='flex-child'>
        <h1>Your Blog Posts</h1>
          <a id='create_post' href="create_blog.php">+ Create New Post</a>
          <ul>
        <?php
         $user = $_COOKIE['uid'];
          $sql= "SELECT * from tbl_blog WHERE user = $user";
          $result = mysqli_query($conn,$sql) or die("Error Occurred");
          if(mysqli_num_rows($result) == 0){
            echo "<h1> No Blogs Posted Yet </h1>";
          }
          while($row = mysqli_fetch_assoc($result)){
           echo "<li><a href=single_blog.php?blog_id=".$row['blog_id'].">";
           include "user_blog.php";
           echo "</a></li>";
        }
        ?>
        </ul>
      </div>
    

    </div>
    <?php include "footer.php" ?>
  </body>
</html>
