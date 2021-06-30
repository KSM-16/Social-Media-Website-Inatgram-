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
        <h3 style="text-align:center;">Forgot Password</h3>
      </div> <hr>
      <div class="l_pass">
        <form method="post">
          <div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="email" type="email" class="form-control" placeholder="Email" name="email" required="required">
          </div><br>
          <pre class="text">Enter your recovery word:</pre>
          <div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
            <input id="cnt" type="text" class="form-control" placeholder="write your recovery word" 
            name="recover" required="required">
          </div><br>
          <a style="float:right;color:#187FAB" data-toggle="tooltip" title="Signin" href="signin.php">
          Back to Sign in?</a> <br> <br>
          <center><button id="signup" class="btn btn-info btn-lg" name="submit">Submit</button></center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
$con = mysqli_connect("127.0.0.1","root","","insta");

	if (isset($_POST['submit'])) {
	
		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$recover = htmlentities(mysqli_real_escape_string($con, $_POST['recover']));

		$select_user = "select * from user where email='$email' AND recover='$recover' ";
    $query= mysqli_query($con, $select_user);
		$check_user = mysqli_num_rows($query);
 		if($check_user == 1){
      session_start();
			$_SESSION['email'] = $email;
			echo "<script>window.open('change.php?em=$email', '_self')</script>";
		}else{
			echo"<script>alert('Your Email or Recovery word is incorrect')</script>";
		}
	}?>
</body>
</html>