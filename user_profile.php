<?php
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
include("nav.php");
include("functions.php");
if(isset($_GET['u_id'])){
	$id = $_GET['u_id'];
?>

<html>
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		border: 5px solid #e6e6e6;
		padding:40px 50px;
	}
	#post_img{
		height:auto;
		width:100%;
	}
</style>
<body> <br>
<div class="row">
	<div class="col-sm-2">	</div>
	<div class="col-sm-8">
	<?php
	$con = mysqli_connect("127.0.0.1","root","","insta");
	$email=$_SESSION['email'];
    $get_user = "select * from user where user_id='$id'"; 
    $run_user = mysqli_query($con,$get_user);
	$row=mysqli_fetch_array($run_user);
	$user_image = $row['pro_img'];
    $user_cover = $row['cover'];
    $f_name=$row['fname'];
	$l_name=$row['lname'];
	$f_email=$row['email'];
    $desc_user=$row['description'];
    $u_country=$row['country'];
    $register=$row['regdate'];
    $gender=$row['gender'];
	$birthday=$row['birthdate'];
	$fq="select count(*) as ca from follow where email='$f_email'";
    $rr=mysqli_query($con,$fq);
    $rf=mysqli_fetch_array($rr);
    $fler=$rf['ca'];
    
    $fa="select count(*) as cf from follow where u_follow='$f_email'";
    $ra=mysqli_query($con,$fa);
    $fa=mysqli_fetch_array($ra);
    $fling=$fa['cf'];
    
	$qr="select * from follow where email='$f_email' and u_follow='$email'";
	$rn = mysqli_query($con,$qr);
	$ch = mysqli_num_rows($rn);
	$ff ="Follow";
	if($ch==1){
		$ff="Unfollow";
	}
			echo"
			<div>
				<div><img id='cover-img' class='rounded' src='cover/$user_cover' alt='cover'></div>
			</div>
			<div id='profile-img'>
				<img src='users/$user_image' alt='Profile' class='rounded-circle' width='180px' height='185px'>
			</div><br>
			";
		?>
	</div>
<div class="col-sm-2"></div>
</div>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-2" style="background-color: #e6e6e6;text-align: center;left: 0.8%;border-radius: 5px;
	max-height:700px;">
		<?php
		echo"
		<br>
			<center><h4><strong>About</strong></h4></center>
			<center><h3><strong>$f_name $l_name</strong></h3></center>
            <p><strong><i style='color:grey;'>$desc_user</i></strong></p><br>
            <p><strong>Followers: </strong> $fler</p><br>
			<p><strong>Following: </strong> $fling</p><br>
			<p><strong>Lives In: </strong> $u_country</p><br>
			<p><strong>Member Since: </strong> $register</p><br>
			<p><strong>Gender: </strong> $gender</p><br>
			<p><strong>Date of Birth: </strong> $birthday</p><br>
			<form method='post'><button class='btn btn-info' name='follow' type='submit'>$ff</button></form>
		";
		if(isset($_POST['follow'])){
			if($ff=="Follow"){
				$qr="insert into follow(email,u_follow,fdate) values('$f_email','$email',NOW())";
				$run= mysqli_query($con,$qr);
				if($run){
				echo "<script>window.open('user_profile.php?u_id=$id', '_self')</script>";}
			}else{
				$qr="delete from follow where email='$f_email' and u_follow='$email'";
				$run= mysqli_query($con,$qr);
				if($run){echo "<script>window.open('user_profile.php?u_id=$id', '_self')</script>";}
			}
		}
		?>
	</div>
	<div class="col-sm-6">
		<?php
		$con = mysqli_connect("127.0.0.1","root","","insta");
        $user = $_GET['u_id'];
		$get_posts = "select * from posts where user_id='$user' order by 1 DESC";
		$run_posts = mysqli_query($con, $get_posts);
		$i=0;
		while($row_posts = mysqli_fetch_array($run_posts)){
			$i=$i+1;
			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$content = $row_posts['content'];
			$upload_image = $row_posts['image'];
			$post_date = $row_posts['date'];

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
							<p><img src='users/$user_image'class='rounded-circle' width='100px' height='100px'></p>
							</div>
							<div class='col-sm-1'></div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;'
								 href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
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
						<form method='post'><button class='btn btn-info'  name='like".$i."'>$ll</button>   $likes</form></a>
						<a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
						<a href='single.php?post_id=$post_id' style='float:right;'>
						<button class='btn btn-info'>Comment</button></a><br>
					
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
								 href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
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
						<form method='post'><button class='btn btn-info'  name='like".$i."'>$ll</button>   $likes</form></a>
						<a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
						<a href='single.php?post_id=$post_id' style='float:right;'>
						<button class='btn btn-info'>Comment</button></a><br>
					
				</div><br><br>
				
				";
			}
			if(isset($_POST["like".$i.""])){
				if($ll=="Like"){
					$qr="insert into likes(email,pid) values('$email','$post_id')";
					$run= mysqli_query($con,$qr);
					if($run){
					echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";}
				}else{
					$qr="delete from likes where email='$email' and pid='$post_id'";
					$run= mysqli_query($con,$qr);
					if($run){echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";}
				}
			}
		}

		?>
	</div>
</div>
</body>
<?php }else{
	echo "<script>window.open('index.php', '_self')</script>";
} ?>
</html>