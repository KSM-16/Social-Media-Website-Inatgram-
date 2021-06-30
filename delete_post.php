<?php
$con = mysqli_connect("127.0.0.1","root","","insta");
$email=$_SESSION['email'];
if(isset($_GET['post_id'])){
    $post_id=$_GET['post_id'];
    $delete_post = "delete from posts where post_id='$post_id'";
    $run_delete = mysqli_query($con, $delete_post);
    if($run_delete){
        echo "<script>alert('A post has been deleted!')</script>";
        echo "<script>window.open('profile.php?em=$email', '_self')</script>";
    }
}

?>