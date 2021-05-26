<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "myforum";

$conn = mysqli_connect($server, $username, $password, $database);

if(!$conn){
//   echo "Successfull";
// }
// else{
  echo "Failed to connect";
}

?>