<?php
 if(isset($_COOKIE['user_c'])) {
	session_start();
	header('Location: home.php');
}
else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signin</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <style>
    .error {color: #FF0000;}
    body{
		overflow-x: hidden;
	}
	.main-content{
		width: 50%;
		height: 40%;
		margin: 10px auto;
		background-color: #fff;
		border: 2px solid #e6e6e6;
		padding: 40px 50px;
    }
    #signin{
		width: 60%;
		border-radius: 30px;
    }
    .overlap-text{
		position: relative;
	}
	.overlap-text a{
		position: absolute;
		top: 8px;
		right: 10px;
		font-size: 14px;
		text-decoration: none;
		font-family: 'Overpass Mono', monospace;
		letter-spacing: -1px;

	}
    </style>
<body>
<div class="row">
	<div class="col-sm-12">
       <center> <img src="logo1.jpg"></center>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="main-content">
            <div class="l-part">
				<form action="" method="post">
				<input type="email" name="email" placeholder="Email" required="required" 
                    class="form-control input-md"><br>
				    <div class="overlap-text">
						<input type="password" name="pass" placeholder="Password" required="required" 
                        class="form-control input-md"><br>
						<a style="text-decoration:none; float: right;color: #187FAB;" data-toggle="tooltip" 
                        title="Reset Password" href="recovery.php">Forgot?</a>
					</div>
					<a style="text-decoration: none;float: right;color: #187FAB;" data-toggle="tooltip" 
                    title="Create Account!" href="signup.php">Don't have an account?</a><br><br>
							<div class="form-group form-check">
							<label class="form-check-label">
							<input class="form-check-input" type="checkbox" name="remember"> Remember me
								</label>
							</div>
					<center><button id="signin" class="btn btn-info btn-lg" name="login">Login</button></center>
					<?php include("login.php"); ?>
				</form>
			</div>
    </div>
	</div>
</div>
</body>
<?php
}
?>
</html>