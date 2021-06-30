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
	<title>Find People</title>
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
    <center><h2>Find New People</h2><br><br>
    <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
    <form class="serch_form"  action="">
        <input type="text" placeholder="Search People"
        style="padding: 10px;font-size: 17px;border-radius: 4px;width:350px;border: 1px solid gray;
        float: left;background: #f2f2f2;" name="search_user">
        <button class="btn btn-info" type="submit" style="padding: 10px;float: left;
        font-size: 17px;" name="search" >Search</button>
    </form>
    </div>
    <div class="col-sm-3"></div>
    </div><br><br>
    </center>
    <?php
    search_user();
    ?>
	</div>
</div>
</body>
</html>
<?php
/*}else{
	echo "<script>window.open('index.php', '_self')</script>";
}*/
?>