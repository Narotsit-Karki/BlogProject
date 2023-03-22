<?php incude "config/db.php"; ?>
<?php 
  session_start();

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
  mysqli_close($conn);
?>
