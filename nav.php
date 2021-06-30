
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>insta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="home_style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="main.js"></script>
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
    $u_pass = $row['password'];
    $email = $row['email'];
    $country = $row['country'];
    $user_gender = $row['gender'];
    $user_birthday = $row['birthdate'];
    $user_image = $row['pro_img'];
    $user_cover = $row['cover'];
    $recovery_account = $row['recover'];
    $register_date = $row['regdate'];
    $fq="select count(*) as ca from follow where email='$email'";
    $rr=mysqli_query($con,$fq);
    $rf=mysqli_fetch_array($rr);
    $follower=$rf['ca'];  
    
    $fa="select count(*) as cf from follow where u_follow='$email'";
    $ra=mysqli_query($con,$fa);
    $fa=mysqli_fetch_array($ra);
    $following=$fa['cf'];

    $user_posts = "select * from posts where user_id='$user_id'"; 
    $run_posts = mysqli_query($con,$user_posts); 
    $posts = mysqli_num_rows($run_posts);
?> 
<nav class="navbar navbar-expand-sm bg-dark"  >
<div class="container-fluid">
<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1"
       data-toggle="collapse">
			<span class="icon-bar"></span>
			</button>
      <a class="navbar-brand" style="color:white" href="instahome.php?em=<?php echo $email;?>">
      <h4 style="color: white; font-family:Georgia ;font-style:italic; ">Instagram</h4></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="profile.php?em=<?php echo $email;?>" ><h5>Profile</h5></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href='home.php?em=<?php echo $email;?>' ><h5>Home</h5></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="msg.php?u_id=<?php echo $user_id;?>" ><h5>Message</h5> </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="find.php?em=<?php echo $email;?>" ><h5>Find People</h5></a>
    </li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li>
    <form class="navbar-form navbar-left form-inline" method="get" action="result.php?em=<?php echo $email;?>" 
    style="align-self: flex-end;">
    <input class="form-control mr-sm-2" type="text" name="user_query" placeholder="Search">
    <button class="btn btn-success" type="submit" name="search_u">Search</button>
  </form>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="check.php" ><h5>Logout</h5></a>
    </li>
  </ul>
</div>
</div>
</nav>

</body>
</html>
