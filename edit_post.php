<!DOCTYPE html>
<html>
<head>
<?php
session_start();
if(!isset($_SESSION['email'])){
	header("location: index.php");
}
include("nav.php");
include("functions.php");
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="home_style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="main.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
        <?php
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
            $get_post = "select * from posts where post_id='$post_id'";
            $run_post = mysqli_query($con, $get_post);
            $row = mysqli_fetch_array($run_post);
            $post_con=$row['content'];
        }
        ?>
        <br>
        <form action="" method="post" id="f">
        <center><h3>Edit Your Post </h3> <br>
        <textarea class="form-controll" cols="90" rows="4" name="content">
        <?php echo $post_con; ?>
        </textarea><br>
        <input type="submit" name="update" value="Update post" class="btn btn-info"/></center>
        </form>
        <?php
        if(isset($_POST['update'])){
            $content=$_POST['content'];
            $update_post="update posts set content='$content' where post_id='$post_id'";
            $run_update=mysqli_query($con,$update_post);
            if($run_update){
                echo "<script>alert('A post has been updated!')</script>";
                echo "<script>window.open('profile.php?em=$email', '_self')</script>";
            }
        }
        ?>
        </div>
        <div class="col-sm-3"></div>
    </div>
</body>
</html>