<?php 
function add_counter($mysqli , $counter_name , $location)  {

    $sql = "INSERT INTO `counter`(`counter_name` , `location`) VALUES('$counter_name' , '$location')"; 
    return $mysqli->query($sql);
    
}

function get_counter ($mysqli){
    $sql = "SELECT * FROM `counter`";
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
