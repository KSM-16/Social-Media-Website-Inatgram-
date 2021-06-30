<?php
/*if(!isset($_COOKIE['user_c'])) {
    echo "Cookie named is not set!";
} else {
    echo "Cookie is set!<br>";
    echo "Value is: " . $_COOKIE['user_c'];
}*/
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
  </style>
</head>

<body>

<div class="row">
	<div id="insert_post" class="col-sm-12">
		<center>
		<form action="home.php?em=<?php echo $user;?>" method="post" id="f" enctype="multipart/form-data">
	<textarea class="form-control" id="content" rows="4" name="content" placeholder="Add a description...">
	</textarea><br>
		<label class="btn btn-secondary"  style="position: absolute;top: 47%;right: 18%;width: 100px;
		width: 100px;border-radius: 4px;transform: translate(-50%, -50%);">Select Image
		<input type="file" name="upload_image" size="600">
		</label>
		<button id="btn-post" class="btn btn-success" name="sub">Post</button>
		</form>
		<?php insertPost(); ?>
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php echo frnd_posts(); ?>
	</div>
</div>
</body>
<?php
}else{
	echo "<script>window.open('index.php', '_self')</script>";
}
?>
</html>
