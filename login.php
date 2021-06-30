<?php
$con = mysqli_connect("127.0.0.1","root","","insta");

	if (isset($_POST['login'])) {
	
		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));
      /*  if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 else {
    echo "'$email'  '$pass'"; 
}*/
		$select_user = "select * from user where email='$email' AND password='$pass' AND status='varified'";
        $query= mysqli_query($con, $select_user);
		$check_user = mysqli_num_rows($query);
      /*  echo "$check_user";*/
 		if($check_user == 1){
	   /*     echo "user!";*/
	  		 session_start();
			$_SESSION['email'] = $email;
			
			if(!empty($_POST['remember'])){
				setcookie('user_c',$email,time()+1800);
			}
			echo"<script>alert('Welcome!')</script>";
			echo "<script>window.open('instahome.php?em=$email', '_self')</script>";
		}else{
			echo"<script>alert('Your Email or Password is incorrect')</script>";
		}
	}
?>