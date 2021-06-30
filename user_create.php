<?php
$con = mysqli_connect("127.0.0.1","root","","insta");
if(isset($_POST['sign_up'])){
    $first_name = htmlentities(mysqli_real_escape_string($con,$_POST['first_name']));
    $last_name = htmlentities(mysqli_real_escape_string($con,$_POST['last_name']));
    $email = htmlentities(mysqli_real_escape_string($con,$_POST['u_email']));
    $pass = htmlentities(mysqli_real_escape_string($con,$_POST['u_pass']));
    $gender = htmlentities(mysqli_real_escape_string($con,$_POST['u_gender']));
    $birthday = htmlentities(mysqli_real_escape_string($con,$_POST['u_birthday']));
    $country = htmlentities(mysqli_real_escape_string($con,$_POST['u_country']));
    $stutus="varified";
    $post = "no";
    $newgid = sprintf('%05d', rand(0, 999999));
    $name = strtolower($first_name . "_" . $last_name . "_" . $newgid);
    $check_username_query = "select name from user where email='$email'";
    $run_username = mysqli_query($con,$check_username_query);
    if(strlen($pass) <8 ){
        echo"<script>alert('Password should have at least 8 characters!')</script>";
        exit();
    }
  /*  echo"$first_name $last_name ";*/
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 /* else {
    echo "<sript>alert('connected')</script>"; 
  }*/
    $check_email = "select * from user where email='$email'";
    $run_email = mysqli_query($con,$check_email);
   if( $run_email = mysqli_query($con,$check_email)){
    $check = mysqli_num_rows($run_email);
    if($check == 1){
        echo "<script>alert('Email already exist, Please try using another email')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
        exit();
    }

    }
   else {
        echo "mail not checked"; 
    }
    $f=0;$ff=0;
    $profile="blank-profile-picture.png";
    $cover="nature1.jpg";
    $insert = "insert into user (fname,lname,name,description,recover,password,
    email,country,gender,birthdate,pro_img,cover,regdate,status,post,follower,following)
    values('$first_name','$last_name','$name','Hello Everyone! I am new in Instagram!',
    '','$pass','$email','$country','$gender','$birthday','$profile','$cover',NOW(),
    '$stutus','$post','$f','$ff')";
   /* $ins="insert into follow(email,u_follow) values('$email','$email')";
    $qr=mysqli_query($con, $ins);*/
    $query = mysqli_query($con, $insert);
    echo "$query";
    if($query){
        echo "<script>alert('Wellcome $first_name!')</script>";
        echo "<script>window.open('signin.php', '_self')</script>";
    }
    else{
        echo"failed";
        echo "<script>alert('Registration failed, please try again!')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
    }

}
?>