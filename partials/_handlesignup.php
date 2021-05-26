<?php
  // $showAlert = false;
  $showError = " false";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
  include '_dbconnect.php';
  $user_email = $_POST["email"];
  $user_password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  // $exists = false;
  // check whether this username exist
  $existsql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
  $result = mysqli_query($conn , $existsql);
  $numRows = mysqli_num_rows($result);
  echo var_dump($numRows);
  if($numRows > 0){
    $showError = " Email already exists";

  }
  else{
    // $exists = false;
  

        if(($user_password == $cpassword) ){
          $hash =password_hash($user_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` ( `user_email`, `user_password`, `time`) VALUES ( '$user_email', '$hash', current_timestamp())";
        $result = mysqli_query($conn , $sql);
        echo  var_dump($result) ;
        if($result){
          $showAlert = true;
          header("Location: /forum/index.php?signupsuccess=true");
          exit();
        }
}
else{
  $showError = "Passwords do not match ";
  

}
  }
  header("Location: /forum/index.php?signupsuccess=false&error= $showError");

}
?>