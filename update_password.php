<? incude 
 <?php
    // Updating Password
    if($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['submit_2'])){
      $old_pass = $_POST['old_password'];
      $new_pass = $_POST['new_password'];
      $valid = true;
      
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
      
      if($valid){
        if(password_verify($old_pass, $data['password'])){
            $password = password_hash($new_pass, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_user SET password = $password ";
            session_unset();
            if(mysqli_query($conn,$row)){
              $_SESSION['message'] = 'Password Updated Successfully';
            }else{
              $_SESSION['message'] = 'Password Update UnSuccessfull';
            }
          }else{
            $error_old_pass = "Old password donot match";
          }
      }
  }
  mysqli_close($conn);
 ?>
