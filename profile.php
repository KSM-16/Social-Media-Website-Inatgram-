<?php
if(isset($_GET['em'])){
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}else{
include("nav.php");
include("functions.php");
include("delete_post.php");
?>

<html>

<head>
    <title><?php echo "$user_name"; ?></title>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="home_style.css">

	<script src="main.js"></script>
</head>
<style>
	#cover-img{
		height: 450px;
		width: 100%;
	}#profile-img{
		position: absolute;
		top: 200px;
		left: 40px;
	}
	#update_profile{
		position: relative;
		top: -33px;
		cursor: pointer;
		left: 93px;
		border-radius: 2px;
		color: black;
		background-color: rgba(0,0,0,0.1);
		transform: translate(-50%, -50%);
	}
	#button_profile{
		position: absolute;
		top: 82%;
		left: 50%;
		cursor: pointer;
		transform: translate(-50%, -50%);
	}
	#own_post{
		border: 5px solid#e6e6e6;
		padding:40px 50px;
	}
	#post_img{
		height: auto;
		width:100%;
	}
</style>
<body>
	<br>
<div class="row">
	<div class="col-sm-2">	</div>
	<div class="col-sm-8">
	<?php
	$con = mysqli_connect("127.0.0.1","root","","insta");
    $user = $_SESSION['email'];
    $get_user = "select * from user where email='$user'"; 
    $run_user = mysqli_query($con,$get_user);
	$row=mysqli_fetch_array($run_user);
	$user_image = $row['pro_img'];
	$user_cover = $row['cover'];
			echo"
			<div>
				<div><img id='cover-img' class='rounded' src='cover/$user_cover' alt='cover'></div>
				<form action='profile.php?em=$user' method='post' enctype='multipart/form-data'>
				<ul class='nav pull-left' style='position:absolute;top:10px;left:40px;background-color:white'>
					<li class='dropdown'>
						<button class='dropdown-toggle btn btn-default ' data-toggle='dropdown'>Change Cover</button>
						<div class='dropdown-menu'>
							<center>
							<label class='btn btn-info btn-sm'>Select Cover
							<input type='file' name='u_cover' size='600' />
							</label><br>
							<button name='submit' class='btn btn-info btn-sm'>Update Cover</button>
							</center>
						</div>
					</li>
				</ul>
				</form>
			</div>
			<div id='profile-img'>
				<img src='users/$user_image' alt='Profile' class='rounded-circle' width='180px' height='185px'>
				<form action='profile.php?em=$user' method='post' enctype='multipart/form-data'>

				<label id='update_profile' class='btn btn-sm' style='background-color:#F0ECEA'> Select Profile
				<input type='file' name='u_image' size='600' />
				</label><br> <br>
				<button id='button_profile' name='update'style='background-color:#F0ECEA'class='btn btn-sm' >
				Update Profile</button>
				</form>
			</div><br>
			";
		?>
	<?php

	if(isset($_POST['submit'])){
		$u_cover = $_FILES['u_cover']['name'];
		$image_tmp = $_FILES['u_cover']['tmp_name'];
	/*	$random_number = rand(1,100);*/

		if($u_cover==''){
			echo "<script>alert('Please Select Cover Image')</script>";
			echo "<script>window.open('profile.php?em=$user' , '_self')</script>";
			exit();
		}else{
			move_uploaded_file($image_tmp, "cover/$u_cover");
			$update = "update user set cover='$u_cover' where user_id='$user_id'";
			$run = mysqli_query($con, $update);
			if($run){
			echo "<script>alert('Your Cover Updated')</script>";
			echo "<script>window.open('profile.php?em=$user' , '_self')</script>";
			}
		}
	}

	if(isset($_POST['update'])){
		$u_image = $_FILES['u_image']['name'];
		$image_tmp = $_FILES['u_image']['tmp_name'];
/*		$random_number = rand(1,100);*/
		if($u_image==''){
			echo "<script>alert('Please Select Profile Image on clicking on your profile image')</script>";
			echo "<script>window.open('profile.php?em=$user' , '_self')</script>";
			exit();
		}else{
			move_uploaded_file($image_tmp, "users/$u_image");
			$update = "update user set pro_img='$u_image' where user_id='$user_id'";
			$run = mysqli_query($con, $update);
			if($run){
			echo "<script>alert('Your Profile Updated')</script>";
			echo "<script>window.open('profile.php?em=$user' , '_self')</script>";
			}
		}
	}
	?>
	</div>
<div class="col-sm-2"></div>
</div>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-2" style="background-color: #e6e6e6;text-align: center;left: 0.8%;border-radius: 5px;
	max-height:700px; ">
		<?php
		echo"<br>
			<center><h4><strong>About</strong></h4></center>
			<center><h3><strong>$first_name $last_name</strong></h3></center>
			<p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>
			<p><strong>Followers: </strong> $follower</p><br>
			<p><strong>Following: </strong> $following</p><br>
			<p><strong>Lives In: </strong> $country</p><br>
			<p><strong>Member Since: </strong> $register_date</p><br>
			<p><strong>Gender: </strong> $user_gender</p><br>
			<p><strong>Date of Birth: </strong> $user_birthday</p><br>
			<a href='edit_profile.php?em=$user'><button class='btn btn-secondary' name='edit' type='submit'>Edit Profile</button></a>
			<br>
			";
		?>
	</div>
	<div class="col-sm-6">
		<?php
		$con = mysqli_connect("127.0.0.1","root","","insta");

		$email=$_SESSION['email'];
		$get_user="select user_id from user where email='$email'";
		$run_id = mysqli_query($con, $get_user);
		$get_id=mysqli_fetch_array($run_id);
		$u_id=$get_id['user_id'];
		$get_posts = "select * from posts where user_id='$u_id' order by 1 DESC";
		$run_posts = mysqli_query($con, $get_posts);
		$i = 0;
		while($row_posts = mysqli_fetch_array($run_posts)){
			$i = $i + 1;
			
			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$content = $row_posts['content'];
			$upload_image = $row_posts['image'];
			$post_date = $row_posts['date'];

			//echo $post_id;

			$ql="select * from likes where pid='$post_id'";
			$rl = mysqli_query($con,$ql);
			$likes=mysqli_num_rows($rl);
			
			$qry="select * from likes where pid='$post_id' and email='$email'";
			$rnq = mysqli_query($con,$qry);
			$chk = mysqli_num_rows($rnq);
			$ll ="Like";
			if($chk==1){
				$ll="Unlike";
			}
			
			$user = "select * from user where user_id='$user_id' AND post='yes'";
			$run_user = mysqli_query($con,$user);
			$row_user = mysqli_fetch_array($run_user);
			$f_name = $row_user['fname'];
			$l_name = $row_user['lname'];
			$user_name="$f_name "."$l_name";
			$user_image = $row_user['pro_img'];

			if($content=="" && strlen($upload_image) >= 1){
				echo"
				<div id='own_post'>
						<div class='row'>
							<div class='col-sm-2'>
							<p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
							</div>
							<div class='col-sm-1'></div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;'
								 href='profile.php?em=$user'>$user_name</a></h3>
								<h5><small style='color:black;'>Updated a post on $post_date</small></h5>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
								<img id='posts-img' src='imagepost/$upload_image' style='height:auto;'>
							</div>
						</div> <br>
						<a href='#' style='float:left;'>
						<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
						<a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
						<a href='delete_post.php?post_id=$post_id' style='float:right;'>
						<button class='btn btn-info'>Delete</button></a><br>
					
				</div><br><br>
				
				";
			}
			else if(strlen($content)>=1 && strlen($upload_image) >= 1){
				echo"
				<div id='own_post'>
						<div class='row'>
							<div class='col-sm-2'>
							<p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
							</div>
							<div class='col-sm-1'></div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;'
								 href='profile.php?em=$user'>$user_name</a></h3>
								<h5><small style='color:black;'>Updated a post on $post_date</small></h5>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
							<p>$content</p>
                            <img id='posts-img' src='imagepost/$upload_image' style='height:auto;'>
							</div>
						</div> <br>
	
						<a href='#' style='float:left;'>
						<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
						<a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
						<a href='edit_post.php?post_id=$post_id' style='float:right;'>
						<button class='btn btn-info'>Edit</button></a>
						<a href='delete_post.php?post_id=$post_id' style='float:right;'>
						<button class='btn btn-info'>Delete</button></a><br>
					
				</div><br><br>
				
				";
			}
			if(isset($_POST["like".$i.""])){
				if($ll=="Like"){
					echo $post_id;
					$qr="insert into likes(email,pid) values('$email','$post_id')";
					$run= mysqli_query($con,$qr);
					if($run){
				echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
				}
				}else{
					echo $post_id;
					$qr="delete from likes where email='$email' and pid='$post_id'";
					$run= mysqli_query($con,$qr);
					if($run){echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
					}
				}
			}
		}
		?>
	</div>
</div>
</body>
<?php 
} ?>
</html>
<?php
}else{
	echo "<script>window.open('index.php', '_self')</script>";
}
?>