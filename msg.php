<?php
if(isset($_GET['u_id'])){
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
include("nav.php");
?>
<html lang="en">
<head>
  <title>Messages</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="home_style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
	  #scroll_msg{
		max-height: 420px;
		overflow: scroll;
	  }
	  #m_btn{
		  width: 30%;
			height: 35px;
			font-size:20px;
		  margin: 5px;
		  border: none;
		  color: #fff;
		  float:right;
		  background-color: #2ecc71;
	  }
	  #from{
		  background-color:rgb(176, 190, 192); ;
		  padding: 5px;
		  font-size:16px;
		  float:right;
		  margin-bottom:5px;
		  max-width:50%;
	  }
	  #to{
		  background-color:rgb(138, 146, 218);
		  padding: 5px;
		  font-size:16px;
		  float:left;
		  margin-bottom:5px;
	  }
  </style>
</head>

<body>
<hr>
<div class="row">
<?php
	$con = mysqli_connect("127.0.0.1","root","","insta");
	$user = $_SESSION['email'];
    $own_user = "select * from user where email='$user'"; 
    $run_own = mysqli_query($con,$own_user);
    $row=mysqli_fetch_array($run_own);
    $own_id = $row['user_id']; 
    $first_name = $row['fname'];
	$last_name = $row['lname'];
	$own_name= "$first_name "."$last_name";
	$own_image = $row['pro_img'];
?>
	<div class="col-sm-3" id="select_user">
	<?php
		$con = mysqli_connect("127.0.0.1","root","","insta");
		$user = $_SESSION['email'];
		$own_user = "select * from user where email='$user'"; 
		$run_own = mysqli_query($con,$own_user);
		$row=mysqli_fetch_array($run_own);
		$own_id = $row['user_id']; 
		$fuser="select * from follow where u_follow='$user'";
		$run_u = mysqli_query($con,$fuser);
		while($row_u = mysqli_fetch_array($run_u)){
			$uemail=$row_u['email'];
			$user="select * from user where email='$uemail'";
			$run_user = mysqli_query($con,$user);
			$row_user = mysqli_fetch_array($run_user);
			$user_id = $row_user['user_id'];
			if($user_id!=$own_id){
			$f_name = $row_user['fname'];
			$l_name = $row_user['lname'];
			$u_name ="$f_name "."$l_name";
			$u_image = $row_user['pro_img'];
			echo"
				<div class='container-fluid'>
				<a style='text-decoration:none; cursor:pointer;color #3897f0;' href='msg.php?u_id=$user_id'>
				<img class='rounded-circle' src='users/$u_image' width='90px' height='90px' title='$u_name'>
				<strong>$u_name</strong><br><br> </a>	
				</div>
			";
			}
		}
		if(isset($_GET['u_id'])){
			$get_id=$_GET['u_id'];
			$get_user = "select * from user where user_id='$get_id'"; 
			$run_user = mysqli_query($con,$get_user);
			$row_user = mysqli_fetch_array($run_user);
			$f_name = $row_user['fname'];
			$l_name = $row_user['lname'];
			$get_name="$f_name "."$l_name";
			$user_profile = $row_user['pro_img'];
		}
	?>
	</div>
	<div class="col-sm-6">
		<div class="load_msg" id="scroll_msg">
		<?php
		$con = mysqli_connect("127.0.0.1","root","","insta");
		global $get_id,$own_id;
			$get_msg="select * from messages where (m_to='$own_id' and m_from='$get_id') 
			or (m_to='$get_id' and m_from='$own_id') order by 1 ASC";
			$run_msg = mysqli_query($con, $get_msg);
			while($row_msg = mysqli_fetch_array($run_msg)){
				$u_to=$row_msg['m_to'];
				$u_from=$row_msg['m_from'];
				$m_body=$row_msg['msg'];
				$m_date=$row_msg['date'];
				?>
				<div id='m_loaded'>
				<p><?php
					if($u_to==$get_id and $u_from==$own_id){
						echo"
							<div class='message' id='from' data-toggole='tooltip' title='$m_date'>$m_body</div><br>
						";
					}
					else if($u_to==$own_id and $u_from==$get_id){
						echo"
							<div class='message' id='to' data-toggole='tooltip' title='$m_date'>$m_body</div><br>
						";
					}
				?></p>
				</div>
				<?php
			}
		?>
		</div>
		<?php
			if(isset($_GET['u_id'])){
				$get_id=$_GET['u_id'];?>
				<form  action="" method="post">
					<textarea class="form-control" placeholder="Write your message"
					 name="m_box" id="m_textarea" cols="30" rows="3"></textarea>
					 <input type="submit" name="m_send" id="m_btn" value="send">
				</form><br>
		<?php	}
		if(isset($_POST['m_send'])){
			$msg=htmlentities($_POST['m_box']);
			if(strlen($msg)>=1){
				$insert="insert into messages(m_to,m_from,msg,date,m_seen) values('$get_id','$own_id','$msg',NOW(),'no')";
				$run_msg = mysqli_query($con, $insert);
			}
			$_POST['m_box']="";
			echo "<script>window.open('msg.php?u_id=$get_id' , '_self')</script>";
		}
		?>
	</div>
	<div class="col-sm-3">
		<?php
			if(isset($_GET['u_id'])){
				$get_id=$_GET['u_id'];
				$get_user = "select * from user where user_id='$get_id'"; 
				$run_user = mysqli_query($con,$get_user);
				$row_user = mysqli_fetch_array($run_user);
				$f_name = $row_user['fname'];
				$l_name = $row_user['lname'];
				$u_name="$f_name "."$l_name";
				$u_profile = $row_user['pro_img'];
				$u_country = $row_user['country'];
				$u_gender = $row_user['gender'];
				$u_birthday = $row_user['birthdate'];
				$u_describe = $row_user['description'];
			}
			if($get_id>0){
				echo"
					<div class='row'>
					<center>
					<div style='background-color:#e6e6e6;' class='col-sm-10' >
					<br>
					<center><img class='rounded-circle' src='users/$u_profile' width='150' height='150'></center><br>
					<center><ul class='light-group'>
						<li class='list-group-item' title='username'><strong>$u_name</strong></li>
						<li class='list-group-item' title='describe'><strong  style='color:gray;'>$u_describe</strong></li>
						<li class='list-group-item' title='genter'>Gender : $u_gender</li>
						<li class='list-group-item' title='country'>Country : $u_country</li>
						<li class='list-group-item' title='birthday'>Birthday : $u_birthday</li>
					</ul>
					</center>
					</div>
					</center>
					<br>
					</div>
				";
			}
		?>
	</div>
</div>

</body>
</html>
<?php
}else{
	echo "<script>window.open('index.php', '_self')</script>";
}
?>