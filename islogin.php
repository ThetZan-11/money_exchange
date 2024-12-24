<?php
   $user = json_decode($_COOKIE["user"], true);
   if(!$user){
    header("Location:../index.php?login=Login Please");
   } else {
    $url = $_SERVER['REQUEST_URI'];
    $arr = explode('/', $url);
    $code = 0;
    
    if ($arr[count($arr) - 2] !== "money_exchange") {
        $role = $arr[count($arr) - 2];
        if($role == 'admin'){
            $code = 1;
        } else if($role == 'staff'){
            $code = 2;
        } 

        if($user['role'] != $code){
            header("Location:../404.html");
        }
   } else {
    header("Location:../404.html");
   }
}

   if (isset($_POST['logout'])) {
    setcookie("user", "", -1, "/");
    header("Location:../index.php");
}

   
