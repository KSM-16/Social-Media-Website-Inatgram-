<?php
if(isset($_GET['em'])){
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
include("nav.php");
?>
<html lang="en">
<head>
  <title>Edit Your Profile</title>
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
<br>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-8">
	<form action="" method="post" entype="multypart/form-data">
    <table class="table table-bordered table-hover">
    <tr align="center">
        <td colspan="6" class="active"><h3>Edit Your Profile</h3></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Change Your First Name</td>
        <td><input class="form-control" type="text" name='f_name' required value="<?php echo $first_name;?>"></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Change Your Last Name</td>
        <td><input class="form-control" type="text" name='l_name' required value="<?php echo $last_name;?>"></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Description</td>
        <td><input class="form-control" type="text" name='describe' required value="<?php echo $describe_user;?>"></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Email</td>
        <td><input class="form-control" type="email" name='u_email' required value="<?php echo $email;?>"></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Password</td>
        <td><input class="form-control" type="password" name='u_pass' id="mypass" required
         value="<?php echo $u_pass;?>">
         <input type="checkbox"  onclick="show_password()">
         <strong>Show Password</strong>
         <script>
             function show_password() {
                var x = document.getElementById("mypass");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
         </script>
         </td>
    </tr>
    <tr>
        <td style="font-weight:bold">Gender</td>
        <td>
            <select class="form-control" name="u_gender" >
            <option><?php echo $user_gender;?></option>
            <option>Male</option>
            <option>Female</option>
            <option>Others</option>
            </select>
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold">Birthday</td>
        <td><input class="form-control input-md" type="date" name='u_birthday' required value="<?php echo $user_birthday;?>"></td>
    </tr>
    <tr>
        <td style="font-weight:bold">Country</td>
        <td>
            <select class="form-control" name="u_country" >
            <option><?php echo $country;?></option>
            <option>Bangladesh</option>
            <option>United States of America</option>
            <option>Austrelia</option>
            <option>Japan</option>
            <option>United Kingdom</option>
            <option>France</option>
            <option>Germany</option>
            </select>
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold">Recover Option</td>
        <td>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mymodal">Turn on</button>
            <div id="mymodal" class="modal fade" role="dialoge">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="recovery.php?id=<?php echo $user_id;?>" method="post" id="f">
                            <strong>Write something for recover...</strong>
                            <textarea class="form-control" cols="80" rows="2" name="content" placeholder="Something...">
                            </textarea><br>
                            <input class="btn btn-secondary" type="submit" name="sub" value="submit" style="width:100px;">
                            <br><br>
                            <pre>We will ask you to write this if you forget your password.</pre><br>
                            </form>
                            <?php
                            if(isset($_POST['sub'])){
                                $cn=htmlentities(mysqli_real_escape_string($con,$_POST['content']));
                                if($cn==""){
                                    echo"<script>alert('Please enter something..')</script>";
                                    echo "<script>window.open('edit_profile.php?em=$email', '_self')</script>";
                                    exit();
                                }else{
                                    $up="update user set recover='$cn' where user_id=$user_id";
                                    $run=mysqli_query($con,$up);
                                    if($run){
                                        echo"<script>alert('Password Recovery saved.')</script>";
                                        echo "<script>window.open('edit_profile.php?em=$email', '_self')</script>";
                                    }else{
                                        echo"<script>alert('Error while updating..')</script>";
                                        echo "<script>window.open('edit_profile.php?em=$email', '_self')</script>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr align="center">
        <td colspan="6">
        <input type="submit" class="btn btn-info" name="update" style="width:250px;" value="update"></td>
    </tr>
    </table>
    </form>
    <?php
    $con = mysqli_connect("127.0.0.1","root","","insta");
    if(isset($_POST['update'])){
        $f_name = htmlentities(mysqli_real_escape_string($con,$_POST['f_name']));
        $l_name = htmlentities(mysqli_real_escape_string($con,$_POST['l_name']));
        $u_email = htmlentities(mysqli_real_escape_string($con,$_POST['u_email']));
        $u_describe = htmlentities(mysqli_real_escape_string($con,$_POST['describe']));
        $u_pass = htmlentities(mysqli_real_escape_string($con,$_POST['u_pass']));
        $u_gender = htmlentities(mysqli_real_escape_string($con,$_POST['u_gender']));
        $u_birthday = htmlentities(mysqli_real_escape_string($con,$_POST['u_birthday']));
        $u_country = htmlentities(mysqli_real_escape_string($con,$_POST['u_country']));
        if(strlen($u_pass) <8 ){
            echo"<script>alert('Password should have at least 8 characters!')</script>";
            exit();
        }
        $up="update user set fname='$f_name',lname='$l_name',description='$u_describe',country='$u_country',
        birthdate='$u_birthday',gender='$u_gender',email='$u_email',password='$u_pass' where user_id='$user_id'";
        $run=mysqli_query($con,$up);
        if($run){
            echo "<script>window.open('profile.php?em=$email', '_self')</script>";
        }else{
            echo"<script>alert('Error while updating..')</script>";
            echo "<script>window.open('edit_profile.php?em=$email', '_self')</script>";
        }
    }
    ?>
</div>
<div class="col-sm-2">
</div>	
</div>
<br><br>
</body>
</html>
<?php
}else{
	echo "<script>window.open('index.php', '_self')</script>";
}
?>