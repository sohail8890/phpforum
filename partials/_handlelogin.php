<?php
  // $login = false;
  $showError = false;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
  include '_dbconnect.php';
  $user_email = $_POST["email"];
  $user_password = $_POST["password"];
 


  
  $sql = "Select * from users where user_email = '$user_email' ";
  $result = mysqli_query($conn , $sql);
  $numRows = mysqli_num_rows($result);
  if($numRows == 1){
    $row = mysqli_fetch_assoc($result);
    if(password_verify($user_password, $row['user_password'])){
      // $login = true;
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['sno'] = $row['sno'];
      $_SESSION['useremail'] = $user_email;
      echo "loggedin ". $user_email;
    }

      header("location: /forum/index.php");
    }
  
  
  }


?>