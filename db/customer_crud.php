<?php

function get_customer ($mysqli){
    $sql = "SELECT * FROM `customer`";
    return $mysqli->query($sql); 
}

function get_customer_with_id($mysqli , $id){
    $sql = "SELECT * FROM `customer` WHERE `id`= $id";
    return $mysqli->query($sql); 
}

function get_customer_with_email($mysqli , $email){
    $sql = "SELECT * FROM `customer` WHERE `email`= '$email'";
    $result = $mysqli->query($sql); 
    return $result->fetch_assoc();
}

function delete_customer($mysqli , $id){
    $sql = "DELETE FROM `customer` WHERE `id`=$id";
    return $mysqli->query($sql); 
}

function update_customer($mysqli , $id , $name , $email , $address , $ph_no ){
    $sql = "UPDATE  `customer` SET `name` = '$name' , `email` ='$email' , `address` ='$address' , `ph_no` = '$ph_no'
    WHERE `id` = $id";
    return $mysqli->query($sql);
}

function search_query_for_customer($mysqli, $key){
    $sql = "SELECT * FROM `customer` WHERE `name` LIKE '%$key%' OR `email` LIKE '%$key%' OR `address` LIKE '%$key%' OR `ph_no` LIKE '%$key%'";
    return $mysqli->query($sql);
}        
function add_customer($mysqli, $name, $email, $address, $ph_no){
    $sql ="INSERT INTO `customer` (`name`, `email`, `address`,`ph_no`)
    VALUES ('$name' , '$email' , '$address' , $ph_no)";
    return $mysqli->query($sql);
}


function soft_delete_customer ($mysqli , $id) 
{
 $sql ="UPDATE `customer` SET `soft_delete` = 1 WHERE `id` = $id";
 return $mysqli->query($sql);
}

function get_sd_customer ($mysqli)
{
$sql ="SELECT * FROM `customer` WHERE `soft_delete` = 0";
return $mysqli->query($sql);

}

