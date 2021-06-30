<?php 
    $con = mysqli_connect("127.0.0.1","root","","insta");
function insertPost(){
    if(isset($_POST['sub'])){
        global $con;
        global $user_id;
        $email=$_SESSION['email'];
        $content = htmlentities($_POST['content']);
        $upload_image = $_FILES['upload_image']['name'];
        $image_tmp = $_FILES['upload_image']['tmp_name'];
        if($upload_image==""){
            echo "<script>alert('Please select an image!')</script>";
            echo "<script>window.open('home.php?em=$email', '_self')</script>";
        }
        else if(strlen($content) > 250){
            echo "<script>alert('Please use less than or equal 250 words!')</script>";
            echo "<script>window.open('home.php?em=$email', '_self')</script>";
        }
        else{
            $likes=0;
            if(strlen($upload_image) >= 1 && strlen($content) >= 1){
                move_uploaded_file($image_tmp, "imagepost/$upload_image");
                $insert = "insert into posts (user_id, content, image, date,likes) 
                values('$user_id', '$content','$upload_image', NOW(),'$likes')";

                $run = mysqli_query($con, $insert);
                if($run){
                    echo "<script>alert('Your Post updated a moment ago!')</script>";
                    echo "<script>window.open('home.php?em=$email', '_self')</script>";

                    $update = "update user set post='yes' where user_id='$user_id'";
                    $run_update = mysqli_query($con, $update);
                }

                exit();
            }
            else if($content==""){
                move_uploaded_file($image_tmp, "imagepost/$upload_image");
                $insert = "insert into posts (user_id, content, image, date,likes) values
                    ('$user_id','','$upload_image',NOW(),'$likes')";
                $run = mysqli_query($con, $insert);

                if($run){
                    echo "<script>alert('Your Post updated a moment ago!')</script>";
                    echo "<script>window.open('home.php?em=$email', '_self')</script>";

                    $update = "update user set post='yes' where user_id='$user_id'";
                    $run_update = mysqli_query($con, $update);
                }
                exit();
            }
        }
    }
}

function frnd_posts(){
    global $con;
    $email=$_SESSION['email'];
    $get_user="select user_id from user where email='$email'";
    $run_id = mysqli_query($con, $get_user);
    $get_id=mysqli_fetch_array($run_id);
    $own_id=$get_id['user_id'];

    $query="select * from follow where u_follow='$email'";
    $run_qr = mysqli_query($con, $query);
    while($row_userf = mysqli_fetch_array($run_qr)){
    $follow=$row_userf['email'];
    $qr="select user_id from user where email='$follow'";
    $run_idf = mysqli_query($con, $qr);
    $get_idf=mysqli_fetch_array($run_idf);
    $user_f=$get_idf['user_id'];
    $get_posts = "select * from posts where user_id='$user_f' ORDER by 1 DESC";
    $run_posts = mysqli_query($con, $get_posts);
    $i=0;
    while($row_posts = mysqli_fetch_array($run_posts)){
        $i =$i+1;
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
        if($user_id==$own_id){
            if($content=="" && strlen($upload_image) >= 1){
                echo"
                <div class='row'>
                    <div class='col-sm-3'>
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                            <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-1'></div>
                            <div class='col-sm-6'>
                                <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                                 href='profile.php?em=$email'>$user_name</a></h4>
                                <h5><small style='color:black;'>Updated a post on $post_date</small></h5>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='imagepost/$upload_image' style='height:auto'>
                            </div>
                        </div> <br>
    
                        <a href='#' style='float:left;'>
						<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                        <a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
                        <a href='single.php?post_id=$post_id' style='float:right;'>
                        <button class='btn btn-info'>Comment</button></a><br>
                    </div>
                    <div class='col-sm-3'>
                    </div>
                </div><br><br>
                ";
            }
    
            else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
                echo"
                <div class='row'>
                    <div class='col-sm-3'>
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                            <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-1'></div>
                            <div class='col-sm-6'>
                                <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                                 href='profile.php?em=$email'>$user_name</a></h4>
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
                        </div><br>
                        
                        <a href='#' style='float:left;'>
						<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                        <a href='single.php?post_id=$post_id' style='float:right;' >
						<button class='btn btn-info'>View</button></a>
                        <a href='single.php?post_id=$post_id' style='float:right;'>
                        <button class='btn btn-info'> Comment</button></a><br>
                    </div>
                    <div class='col-sm-3'>
                    </div>
                </div><br><br>
                ";
            }  
        }
        else{
        if($content=="" && strlen($upload_image) >= 1){
            echo"
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
                    <a href='single.php?post_id=$post_id' style='float:right;'>
                    <button class='btn btn-info'>Comment</button></a><br>
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }

        else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
            echo"
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
                    </div><br>
                    
                    <a href='#' style='float:left;'>
					<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                    <a href='single.php?post_id=$post_id' style='float:right;' >
					<button class='btn btn-info'>View</button></a>
                    <a href='single.php?post_id=$post_id' style='float:right;'>
                    <button class='btn btn-info'>Comment</button></a><br>
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }    
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
    }
}

function single_post(){
    global $con;
    if(isset($_GET['post_id'])){
        $get_id=$_GET['post_id'];
    }
    $get_posts = "select * from posts where post_id='$get_id'";
    $run_posts = mysqli_query($con, $get_posts);
    $row_posts = mysqli_fetch_array($run_posts);
    $email = $_SESSION['email'];
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

    $user="select * from user where user_id='$user_id'";
    $run_user = mysqli_query($con,$user);
    $row_user = mysqli_fetch_array($run_user);
    $f_name = $row_user['fname'];
    $l_name = $row_user['lname'];
    $user_name="$f_name "."$l_name";
    $user_image = $row_user['pro_img'];

    $user_com = $_SESSION['email'];
    $get_com = "select * from user where email='$user_com'";
    $run_com = mysqli_query($con, $get_com);
    $row_com = mysqli_fetch_array($run_com);
    $user_id_c = $row_com['user_id'];
    $f_namec = $row_com['fname'];
    $l_namec = $row_com['lname'];
    $user_namec = "$f_namec "."$l_namec";
    $own_id = $user_id_c;
    $i=1;
    if($user_id==$own_id){
        if($content=="" && strlen($upload_image) >= 1){
            echo"
            <br>
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='profile.php?em=$email'>$user_name</a></h4>
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
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }
        else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
            echo"
            <br>
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='profile.php?em=$email'>$user_name</a></h4>
                            <h5><small style='color:black;'>Updated a post on $post_date</small></h5>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <p>$content</p>
                            <img id='posts-img' src='imagepost/$upload_image' style='height:auto'>
                        </div>
                    </div><br>
                    
                    <a href='#' style='float:left;'>
					<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }  
    }
    else{
    if($content=="" && strlen($upload_image) >= 1){
        echo"
        <br>
        <div class='row'>
            <div class='col-sm-3'>
            </div>
            <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                    <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-6'>
                        <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                         href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
            </div>
            <div class='col-sm-3'>
            </div>
        </div><br><br>
        ";
    }
    else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
        echo"
        <br>
        <div class='row'>
            <div class='col-sm-3'>
            </div>
            <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                    <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-6'>
                        <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                         href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
                </div><br>
                
                <a href='#' style='float:left;'>
				<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
            </div>
            <div class='col-sm-3'>
            </div>
        </div><br><br>
        ";
        }    
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

    include("comment.php");
    echo"
    <div class='row'>
        <div class='col-sm-3'></div>
        <div class='col-md-6 col-md-offset-3' style='border: 2px solid #e6e6e6;padding: 30px 40px;'>
        <div class='panel panel-info'>
        <div class='panel-body'>
        <form action='' method='post' class='form-inline'>
        <textarea placeholder='Write your comment here!' style='resize:none;padding:20px;' cols='60' name='comment'>
        </textarea>
        <button class='btn btn-info pull-right' name='reply'>Comment</button>
        </form>
        </div>
        </div>
        </div>
    </div>
    ";
    if(isset($_POST['reply'])){
        $comment = htmlentities($_POST['comment']);
        if($comment==""){
            echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
        }
        else{
            $insert="insert into comments(post_id,user_id,comment,author,date)
             values('$post_id','$user_id','$comment','$user_namec',NOW())";
            $run=mysqli_query($con, $insert);
            echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
        }
    }
}

function search_user(){
    global $con;
    if(isset($_GET['search'])){
        $search_q = htmlentities($_GET['search_user']);
        $get_user="select * from user where name like '%$search_q%'";
    }
    else{
        $get_user="select * from user";
    }
    $user_com = $_SESSION['email'];
    $get_com = "select * from user where email='$user_com'";
    $run_com = mysqli_query($con, $get_com);
    $row_com = mysqli_fetch_array($run_com);
    $user_id_c = $row_com['user_id'];
    $run_user=mysqli_query($con, $get_user);
    while($row_user = mysqli_fetch_array($run_user)){
        $user_id = $row_user['user_id'];
        if($user_id!=$user_id_c){
        $f_name = $row_user['fname'];
        $l_name = $row_user['lname'];
        $user_name="$f_name "."$l_name";
        $user_image = $row_user['pro_img'];
        echo"
        <div class='row'>
        <div class='col-sm-4'></div>
        <div class='col-sm-6'>
        <div class='row' >
        <div class='col-sm-4'>
        <a href='user_profile.php?u_id=$user_id'>
        <img src='users/$user_image' class='rounded-circle' width='120px' height='120px' title='$user_name' 
        style='float:left;margin:1px;'/> </a></div>
        <div class='col-sm-6'>
        <br><br>
        <h3><a style='text-decoration:none; cursor:pointer;color #3897f0;'
         href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
        </div>
        <div class='col-sm-3'></div>
        </div>
        </div>
        <div class='col-sm-4'>
        </div>
        </div><br>
        ";
    }
    }
}

function results(){
    global $con;
    if(isset($_GET['search_u'])){
        $search_q=htmlentities($_GET['user_query']);
        $get_posts="select * from posts where content like '%$search_q%' or image like '%$search_q%'";
    }
    else{
        $get_posts="select * from posts";
    }
    $run_posts=mysqli_query($con, $get_posts);
    $post_num = mysqli_num_rows($run_posts);
    if($post_num==0){
        echo"
        <br>
        <div class='row'>
            <div class='col-sm-12'>
            <center><h4>No Result Found!</h4></center>
            </div>
        </div>
        ";
    }else{
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
        $email=$_SESSION['email'];
        $qry="select * from likes where pid='$post_id' and email='$email'";
        $rnq = mysqli_query($con,$qry);
        $chk = mysqli_num_rows($rnq);
        $ll ="Like";
        if($chk==1){
            $ll="Unlike";
        }

        $user="select * from user where user_id='$user_id' and post='yes'";
        $run_user = mysqli_query($con,$user);
        $row_user = mysqli_fetch_array($run_user);
        $f_name = $row_user['fname'];
        $l_name = $row_user['lname'];
        $user_name="$f_name "."$l_name";
        $user_image = $row_user['pro_img'];

        $user_com = $_SESSION['email'];
        $get_com = "select * from user where email='$user_com'";
        $run_com = mysqli_query($con, $get_com);
        $row_com = mysqli_fetch_array($run_com);
        $own_id = $row_com['user_id'];
        if($user_id==$own_id){
            if($content=="" && strlen($upload_image) >= 1){
                echo"
                <br>
                <div class='row'>
                    <div class='col-sm-3'>
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                            <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-1'></div>
                            <div class='col-sm-6'>
                                <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                                 href='profile.php?em=$email'>$user_name</a></h4>
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
                        <button class='btn btn-info'>View</button></a><br>
                    </div>
                    <div class='col-sm-3'>
                    </div>
                </div><br><br>
                ";
            }
            else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
                echo"
                <br>
                <div class='row'>
                    <div class='col-sm-3'>
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                            <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-1'></div>
                            <div class='col-sm-6'>
                                <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                                 href='profile.php?em=$email'>$user_name</a></h4>
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
                        </div><br>
                        
                        <a href='#' style='float:left;'>
					<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                        <a href='single.php?post_id=$post_id' style='float:right;' >
                        <button class='btn btn-info'>View</button></a><br>
                    </div>
                    <div class='col-sm-3'>
                    </div>
                </div><br><br>
                ";
            }  
        }
        else{
        if($content=="" && strlen($upload_image) >= 1){
            echo"
            <br>
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
                    <button class='btn btn-info'>View</button></a><br>
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }
        else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
            echo"
            <br>
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                    <div class='row'>
                        <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='rounded-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-1'></div>
                        <div class='col-sm-6'>
                            <h4><a style='text-decoration:none; cursor:pointer;color #3897f0;'
                             href='user_profile.php?u_id=$user_id'>$user_name</a></h4>
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
                    </div><br>
                    
                    <a href='#' style='float:left;'>
					<form method='post'><button class='btn btn-info' name='like".$i."'>$ll</button>   $likes</form></a>
                    <a href='single.php?post_id=$post_id' style='float:right;' >
                    <button class='btn btn-info'>View</button></a><br>
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
            }    
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
    }
}

?>