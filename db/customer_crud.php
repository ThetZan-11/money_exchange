<?php

function get_customer ($mysqli){
    $sql = "SELECT * FROM `customer`";
    return $mysqli->query($sql); 
}

function get_customer_with_id($mysqli , $id){
    $sql = "SELECT * FROM `customer` WHERE `id`= $id";
    return $mysqli->query($sql); 
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