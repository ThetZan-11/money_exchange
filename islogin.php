<?php
   $user = json_decode($_COOKIE["user"], true);
   if(!$user){
    header("Location:../index.php?login=Login Please");
   }else{
    
   }

   if (isset($_POST['logout'])) {
    setcookie("user", "", -1, "/");
    header("Location:../index.php");
}

   
