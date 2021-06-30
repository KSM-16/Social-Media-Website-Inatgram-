
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>insta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
  .nav-link{
      color:white;
  }
  </style>
</head>
<body>

<?php 
    $con = mysqli_connect("127.0.0.1","root","","insta");
    $user = $_SESSION['email'];
    $get_user = "select * from user where email='$user'"; 
    $run_user = mysqli_query($con,$get_user);
    $row=mysqli_fetch_array($run_user);
            
    $user_id = $row['user_id']; 
    $user_name = $row['name'];
    $first_name = $row['fname'];
    $last_name = $row['lname'];
    $describe_user = $row['description'];
    $user_pass = $row['status'];
    $email = $row['email'];
    $country = $row['country'];
    $user_gender = $row['gender'];
    $user_birthday = $row['birthdate'];
    $user_image = $row['pro_img'];
    $user_cover = $row['cover'];
    $recovery_account = $row['recover'];
    $register_date = $row['regdate'];
    $following=$row['following'];
    $follower=$row['follower'];  

    $user_posts = "select * from posts where user_id='$user_id'"; 
    $run_posts = mysqli_query($con,$user_posts); 
    $posts = mysqli_num_rows($run_posts);
?> 
<div  style = " background-color: #778899; padding:18px;height:100px;">
    <center><h1 style="color: white; font-family:Georgia ; font-style:italic; ">
    Instagram</h1></center>
</div>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="profile.php" >Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="home.php" >Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="msg.php" >Message</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="find.php" >Find People</a>
    </li>
    <li>
    <form class="form-inline" method="get" action="result.php">
    <input class="form-control mr-sm-2" type="text" name="user_query" placeholder="Search">
    <button class="btn btn-success" type="submit" name='search_u'>Search</button>
  </form>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="check.php" >Log out</a>
    </li>
  </ul>
</nav>

</body>
</html>