<?php
//if(isset($_GET['em'])){
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
include("nav.php");
include("functions.php");
?>
<html lang="en">
<head>
  <title>Search Results</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="home_style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
  </style>
</head>

<body>
<div class="row">
    <div class="col-sm-12">
      <br>
    <center><h3>See Search Results</h3></center>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php results(); ?>
	</div>
</div>
</body>
</html>
<?php
/*}else{
	echo "<script>window.open('index.php', '_self')</script>";
}*/
?>