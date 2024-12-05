<?php require_once("./islogin.php");

if($user['role'] == 1){
    header("Location:./admin/index.php");
} elseif ($user['role']==2) {
    header("Location:./staff/index.php");
}


