<?php
    include 'partials/_dbconnect.php';

session_start();

echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum/index.php">MyForum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/forum/about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Top Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
           
          $sql = "SELECT cat_name, cat_id FROM `categories` LIMIT 3";
          $result = mysqli_query($conn ,$sql);
          while($row = mysqli_fetch_assoc($result)){
          echo '  <li><a class="dropdown-item" href="threadlist.php?catid='.$row['cat_id'].'">'.$row['cat_name'].'</a></li>';
          
          }
           
         echo ' </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/forum/contact.php" >Contact Us</a>
        </li>
      </ul>'
      ;
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '
        <form class="d-flex " method="get" action="search.php">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button></form>
       <p class= "text-light mx-2 my-0"> Welcome '. $_SESSION['useremail'].'</p>
       <a href="partials/_logout.php" class="btn btn-outline-success">Logout </a> ';
      }
      else{
      echo '  <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
      </form>
      <div class= mx-2>
      
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal"">Login</button>
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal" ">Signup</button>';
      }
     echo ' </div>
    </div>
  </div>
</nav> ';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php'; 
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Your account has been created. Now you can login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Error!</strong> Passwords do not match or Email already in use.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

?>