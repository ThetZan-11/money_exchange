<?php 
function add_counter($mysqli , $counter_name , $location)  {

    $sql = "INSERT INTO `counter`(`counter_name`, `location`) VALUES('$counter_name' , '$location')"; 
    return $mysqli->query($sql);
    
}

function get_counter ($mysqli){
    $sql = "SELECT * FROM `counter`";
    return  $mysqli->query($sql);
  
}

function get_counter_with_sd($mysqli){
    $sql = "SELECT * FROM `counter` WHERE `soft_delete` = 0";
    return  $mysqli->query($sql);
  
}

function get_counter_id ($mysqli , $id){
    $sql = "SELECT * FROM `counter` WHERE `id` = $id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_counter ($mysqli , $id , $counter_name , $location){
    $sql = "UPDATE `counter` SET `counter_name`= '$counter_name' , `location` = '$location' WHERE `id` = $id";
    return $mysqli->query($sql);
     
}

function delete_counter ($mysqli , $id){
    $sql = "DELETE FROM `counter` WHERE `id`=$id";
    return $mysqli->query($sql);

}


function soft_delete ($mysqli , $id)
{

 $sql = "UPDATE `counter` SET `soft_delete` = 1 WHERE `id` = $id";
 return $mysqli->query($sql);

}

function counter_search ($mysqli , $key)
{
    $sql = "SELECT * FROM `counter` WHERE `counter_name` LIKE '%$key%' OR `location` LIKE '%$key%'";
    return $mysqli->query($sql);
}

function counter_validate_with_date($mysqli, $counter_id, $user_id, ){
    $sql = "SELECT `id` FROM `duty` where '2025-02-03' 
    BETWEEN `duty`.`from_date` AND `duty`.`to_date` AND `counter_id` = '$counter_id' AND `user_id` = '$user_id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}