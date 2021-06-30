<?php
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
?>
<html lang="en">
<head>
  <title>insta</title>
  <meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body{
      overflow-x:hidden;
    }
    .main_content{
      width:50%;
      height:40%;
      margin:10px auto;
      background-color: #fff;
      border:2px solid #e6e6e6;
      padding:40px 50px;
    }
    .header{
      margin-bottom:5px;
    }
    #signup{
      width:50%;
      border-radius:30px;
    }
  </style>
</head>

<body>
<div class="row">
  <div class="col-sm-12">
  <div class="well">
  <center><h1 style="color: black; font-family:Georgia ; font-style:italic; ">
    Instagram</h1></center>
  </div>
  </div>
</div>
<div class="row">
<div class="col-sm-3"></div>
  <div class="col-sm-6">
    <div class="main-content">
      <div class="header">
        <h3 style="text-align:center;">Change Password</h3>
      </div> <hr>
      <div class="l_pass">
        <form method="post">
          <div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="pass" type="password" class="form-control" placeholder="New Password" name="pass"
             required="required"> </div><br>
          <div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="npass" type="password" class="form-control" placeholder="Re-type your password" 
            name="npass" required="required">
          </div><br>
          <a style="float:right;color:#187FAB" data-toggle="tooltip" title="Signin" href="signin.php">
          Back to Sign in?</a> <br> <br>
          <center><button id="signup" class="btn btn-info btn-lg" name="change">Submit</button></center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
$con = mysqli_connect("127.0.0.1","root","","insta");
$email=$_GET['em'];
	if (isset($_POST['change'])) {
	
		$pass1 = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));
		$pass2 = htmlentities(mysqli_real_escape_string($con, $_POST['npass']));
        if($pass1==$pass2){
            if(strlen($pass1) <8 ){
                echo"<script>alert('Password should have at least 8 characters!')</script>";
                exit();
            }
            else{
                $up="update user set password='$pass1' where email='$email'";
                $query= mysqli_query($con, $up);
                if($query){
                    echo"<script>alert('Welcome!')</script>";
                    echo "<script>window.open('home.php?em=$email', '_self')</script>";
                }else{
                    echo"<script>alert('Your password did not match!')</script>";
                    echo "<script>window.open('change.php?em=$email', '_self')</script>";
                }
            }
        }
	}?>
</body>
</html>