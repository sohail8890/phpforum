<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <title>MyForum</title>
</head>
<style>
.container{
  min-height: 85vh;
}
</style>

<body>
  <?php
  include 'partials/_navbar.php';
  include 'partials/_dbconnect.php';
  ?>


  <!--  search results -->


  <div class="container my-4">
    <h1>Search results <em>"<?php echo $_GET['search']; ?>"</em></h1>
    <hr>

    <?php
    $noresult =true;
    $query =$_GET["search"];
  $sql = "SELECT * FROM threads where  match (thread_title, thread_desc) against ('$query')";
  $result = mysqli_query($conn ,$sql);
  while($row = mysqli_fetch_assoc($result)){
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_id = $row['thread_id'];
    $url = "thread.php?threadid=" . $thread_id;
    $noresult= false;

    echo '
    <div class="result py-2">
      <h3> <a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
      <p>'.$desc.'</p>
    </div>
    ';
}
if($noresult){
  echo '<div class="container">
<h1>No Results Found</h1>
</div>';
}
  ?>



    





  <?php
  include 'partials/_footer.php';
  ?>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>