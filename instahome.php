<?php
if(isset($_GET['em'])){
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}

include("nav.php");
include("functions.php");

?>
<html lang="en">
<head>
<?php
		$user = $_SESSION['email'];
		
		$get_user = "select * from user where email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);
		$user_name = $row['name'];
?>
	<title><?php echo "$user_name"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="home_style.css">
  <style>
	  div.gallery {
  border: 1px solid #ccc;
 
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

* {
  box-sizing: border-box;
}

.responsive {
  padding: 1px 2px;
  float: left;
  width: 24.1%;
}

@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.1%;
    margin: 2px 1px;
  }
}

@media only screen and (max-width: 500px) {
  .responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
  </style>
</head>

<body>
<br>
<?php
$con = mysqli_connect("127.0.0.1","root","","insta");
$get_posts = "select * from posts ORDER by 1 DESC";
$run_posts = mysqli_query($con, $get_posts);
$email=$_SESSION['email'];
$get_user="select user_id from user where email='$email'";
$run_id = mysqli_query($con, $get_user);
$get_id=mysqli_fetch_array($run_id);
$own_id=$get_id['user_id'];
$i=0;
while($row_posts = mysqli_fetch_array($run_posts)){
	$i =$i+1;
	$post_id = $row_posts['post_id'];
	$user_id = $row_posts['user_id'];
	$content = $row_posts['content'];
	$upload_image = $row_posts['image'];
	$post_date = $row_posts['date'];
echo"<div class='responsive'>
  <div class='gallery'>
    <a target='' href='single.php?post_id=$post_id'>
      <img src='imagepost/$upload_image' alt='$post_id' width='800' height='600'>
    </a>
  </div>
</div>";
}
?>
<div class="clearfix"></div>

</body>
<?php }else{
	echo "<script>window.open('index.php', '_self')</script>";
} ?>
</html>
