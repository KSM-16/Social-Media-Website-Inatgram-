<?php
$con = mysqli_connect("127.0.0.1","root","","insta");
$post_id = $_GET['post_id'];
$get_com = "select * from comments where post_id='$post_id'";
$run_com = mysqli_query($con, $get_com);
while($row = mysqli_fetch_array($run_com) ){
    $com=$row['comment'];
    $author=$row['author'];
    $date=$row['date'];

    echo"
    <div class='row'>
    <div class='col-sm-3'></div>
    <div class='col-md-6 col-md-offset-3' style='border: 2px solid #e6e6e6;padding: 20px 30px;'>
    <div class='panel panel-info'>
        <div class='panel-body'>
        <div>
        <h5><strong>$author</strong> commented on $date</h5>
        <p class='text-basic' style='margin-left:5px;font-size:20px'>$com</p>
        </div>
        </div>
    </div>
    </div>
    </div>
    ";
}
?>