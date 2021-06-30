<?php
session_destroy();
setcookie('user_c',"",time()-600000000);
/*$_SESSION['email']="";
$_COOKIE['user_c']="";*/
header('Location: signin.php');
?>