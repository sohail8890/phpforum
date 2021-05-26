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
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id =$id";
      $result = mysqli_query($conn ,$sql);
      while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        //Query the users table to find out the name op
        $sql2 = "SELECT user_email FROM `users` where sno=$thread_user_id";
        $result2 = mysqli_query($conn ,$sql2);
        $row2= mysqli_fetch_assoc($result2);
        $posted_by= $row2['user_email'];
      }
    ?>
    <?php
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
    //  insert into db
    $comment= $_POST['comment'];
    $comment= str_replace("<", "&lt", $comment);
    $comment= str_replace(">", "&gt", $comment);
    $sno= $_POST['sno'];
    
    $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn ,$sql);
    $showAlert=true;
    if($showAlert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!! </strong> Your Comment has been added.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    }

    ?>

  <div class="container my-4">
    <h1><?php echo $title; ?> forums</h1>
    <p><?php echo $desc; ?></p>
    <p><b>Posted by:</b><em> <?php echo $posted_by;?></em></p>
  </div>
  <hr>
  <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
 echo '  <div class="container">
 <h1 class=py-3>Post Your Comment</h1>
 <form action= "'. $_SERVER['REQUEST_URI'].'" method="POST">
   <div class="mb-3">
     <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
     <textarea class="form-control" id="desc" name="comment" rows="3"></textarea>
     <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">

   </div>
   <button type="submit" class="btn btn-primary">Post Comment</button>
 </form>
</div>';
}
else{
  echo '
  <div class="container">
 <h1 class=py-3>Post Your Comment</h1>

  <h3>You are not logged in. Please login to Comment.</h3>
  </div>';

}
  ?>

 




  <div class="container">
    <h1 class=py-3>Discussions</h1>
    <hr>
     <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
      $result = mysqli_query($conn ,$sql);
      $noResult=true;
      while($row = mysqli_fetch_assoc($result)){
      $noResult=false;

        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];
        $comment_by = $row['comment_by'];
        $sql2 = "SELECT user_email FROM `users` where sno=$comment_by";
        $result2 = mysqli_query($conn ,$sql2);
        $row2= mysqli_fetch_assoc($result2);
        

        echo '
        <div class="d-flex">
        <div class="flex-shrink-0">
          <img src="img/defaultuser.png" width=50px alt="...">
        </div>
        <div class="flex-grow-1 ms-3">
        <p class="fw-bold my-0">'.$row2['user_email'].' at '.$comment_time.'</p>
          '.$content.'
          <hr>
        </div>
      </div>';
        
      }
      if($noResult){
        echo ' <h1>No Comments Found!!</h1>
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