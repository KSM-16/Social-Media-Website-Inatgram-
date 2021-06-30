<!DOCTYPE html>
<?php
/*if(isset($_SESSION['email'])){
    $email=$_SESSION['email'];
	echo "<script>window.open('instahome.php?em=$email', '_self')</script>";
}
else*/ 
if(isset($_COOKIE['user_c'])) {
    session_start();
    $email=$_SESSION['email'];
    echo "<script>window.open('instahome.php?em=$email', '_self')</script>";
}
else{
?>
<html>
<head>
	<title>Instagram</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    body{
        overflow-x:hidden;
    }
    #signup{
		width: 60%;
		border-radius: 30px;
	}
	#login{
		width: 60%;
		border-radius: 30px;
	}
	#login:hover{
		width: 60%;
		border: 2px solid #1da1f2;
		border-radius: 30px;
    }
    #signup:hover{
        width: 60%;
        border: 2px solid #1da1f2;
		border-radius: 30px;
    }
	.well{
		background-color: #778899;
	}
    </style>
</head>
<body>
<div class="row">
	<div class="col-sm-12">
        <div class="well">
            <center><h1 style="color: white; font-family:Georgia ; font-style:italic; ">
            Instagram</h1></center>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-6" style="left:0.5%">
        <img src="Capture1.jpg" >
    </div>
    <div class="col-sm-6" style="left:1%">
        <img src="logo1.jpg" >
        <form method="post" action="">
            <button id="signup" class="btn btn-info btn-lg" name="signup">Sign up</button><br><br>
            <?php
                if(isset($_POST['signup'])){
                    echo "<script>window.open('signup.php','_self')</script>";
                }
            ?>
            <button id="login" class="btn btn-info btn-lg" name="login">Login</button><br><br>
            <?php
                if(isset($_POST['login'])){
                    echo "<script>window.open('signin.php','_self')</script>";
                }
            ?>
        </form>
        <?php
        echo "<p><style>
        p{
            color :darkblue;
            font-size:30px;
        }
        </style>
        Join the Community
        </p>";
        ?>
    </div>
</div>

</body>
</html>
<?php
}
?>