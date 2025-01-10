<?php
session_start();
   $user = json_decode($_COOKIE["user"], true);

   if(!$user){
    header("Location:../login.php?login=Login Please");
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
            $today_date = date('Y-m-d');

            if(isset($_SESSION['date'])){
                $date = $_SESSION['date'];
                if($date['from_date'] > $today_date || $date['to_date'] < $today_date ){
                    header("Location:../date_over_error.html");
                    setcookie("user", "", -1, "/");
                    session_destroy();
                } 
            } else {
                    echo "date empty";
                    header("Location:../date_over_error.html");
                    setcookie("user", "", -1, "/");
                    session_destroy();
            }
            
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
    header("Location:../login.php");
}

   
