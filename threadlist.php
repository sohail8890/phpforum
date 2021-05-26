<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <title>MyForum</title>
</head>

<body>
  <?php
    include 'partials/_navbar.php';
    include 'partials/_dbconnect.php';
    ?>

  <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE cat_id =$id";
      $result = mysqli_query($conn ,$sql);
      while($row = mysqli_fetch_assoc($result)){
        $catname = $row['cat_name'];
        $catdesc = $row['cat_desc'];
      }
    ?>

    <?php
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
    //  insert into db
    $thread_title= $_POST['title'];
    $thread_desc= $_POST['desc'];

    $thread_title= str_replace("<", "&lt", $thread_title);
    $thread_title= str_replace(">", "&gt", $thread_title);

    $thread_desc= str_replace("<", "&lt", $thread_desc);
    $thread_desc= str_replace(">", "&gt", $thread_desc);

    $sno= $_POST['sno'];
    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$thread_title', '$thread_desc', '$id', '$sno', current_timestamp());";
    $result = mysqli_query($conn ,$sql);
    $showAlert=true;
    if($showAlert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!! </strong> Your Thread has been added.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    }

    ?>

  <div class="container my-4">
    <h1>Welcome to <?php echo $catname; ?> forums</h1>
    <p><?php echo $catdesc; ?></p>
  </div>
  <hr>

<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
 echo ' <div class="container">
    <h1 class=py-3>Start a Discussion</h1>
    <form action= "' . $_SERVER["REQUEST_URI"].'" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Thread Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Ellaborate your concern</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>';
}
else{
  echo '
  <div class="container">
  <h3>You ares not logged in. Please login to start a discussion.</h3>
  </div>';

}
  ?>
  

  <div class="container">
    <h1 class=py-3>Browse Questions</h1>
    <hr>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
      $result = mysqli_query($conn ,$sql);
      $noResult=true;
      while($row = mysqli_fetch_assoc($result)){
        $noResult=false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['timestamp'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 = "SELECT user_email FROM `users` where sno=$thread_user_id";
        $result2 = mysqli_query($conn ,$sql2);
        $row2= mysqli_fetch_assoc($result2);
       


        

        echo '
        <div class="d-flex">
        <div class="flex-shrink-0">
          <img src="img/defaultuser.png" width=50px alt="...">
        </div>
        <div class="flex-grow-1 ms-3">
        <p class="fw-bold my-0">Asked by : '. $row2['user_email'].' at '.$thread_time.'</p>
          <h5><a class= "text-dark" href="thread.php?threadid= '.$id.'">'.$title.'</a></h5>
          '.$desc.'
          <hr>
        </div>
      </div>';
        
      }
      if($noResult){
        echo ' <h1>No Threads Found!!</h1>
        <p>Be the first person to comment..</p> ';
      }
    ?>




  </div>



  <?php
    include 'partials/_footer.php';
    ?>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>