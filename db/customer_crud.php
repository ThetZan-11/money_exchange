<?php

function get_customer ($mysqli){
    $sql = "SELECT * FROM `customer`";
    return $mysqli->query($sql); 
}

function get_customer_with_id($mysqli , $id){
    $sql = "SELECT * FROM `customer` WHERE `soft_delete` = 0   AND `id`= $id";
    return $mysqli->query($sql); 
}

function get_customer_with_email($mysqli , $email){
    $sql = "SELECT * FROM `customer` WHERE  `soft_delete` = 0   AND `email`= '$email'";
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
    $sql = "SELECT * FROM `customer` WHERE  `name` LIKE '%$key%' AND `soft_delete` = 0  
    OR `email` LIKE '%$key%' AND `soft_delete` = 0  
    OR `address` LIKE '%$key%' AND `soft_delete` = 0  
    OR `ph_no` LIKE '%$key%' AND `soft_delete` = 0 ";
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

function customer_count_from_counter_today($mysqli, $user_email, $from_date, $to_date){
    $sql= "SELECT count(DISTINCT `customer`.`email`) AS `customer_count` 
    FROM `customer` INNER JOIN `trade` on `trade`.`customer_id` = `customer`.`id` 
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
    WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
    INNER JOIN counter ON `duty`.`counter_id` = `counter`.`id` INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
    WHERE `user`.`role` = 2 AND `user`.`email` = '$user_email' AND `duty`.`from_date` = '$from_date' AND `duty`.`to_date` = '$to_date')
    AND `trade`.`date`= CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function customer_count_from_counter_month($mysqli, $user_email, $from_date, $to_date){
    $sql= "SELECT count(DISTINCT `customer`.`email`) AS `customer_count` 
    FROM `customer` INNER JOIN `trade` on `trade`.`customer_id` = `customer`.`id` 
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
    WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
    INNER JOIN counter ON `duty`.`counter_id` = `counter`.`id` INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
    WHERE `user`.`role` = 2 AND `user`.`email` = '$user_email' AND `duty`.`from_date` = '$from_date' AND `duty`.`to_date` = '$to_date') AND MONTH(`trade`.`date`)=MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function customer_count_from_counter_year($mysqli, $user_email, $from_date, $to_date){
    $sql= "SELECT count(DISTINCT `customer`.`email`) AS `customer_count` 
    FROM `customer` INNER JOIN `trade` on `trade`.`customer_id` = `customer`.`id` 
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
    WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
    INNER JOIN `counter` ON `duty`.`counter_id` = `counter`.`id` INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
    WHERE `user`.`role` = 2 AND `user`.`email` = '$user_email' AND `duty`.`from_date` = '$from_date' AND `duty`.`to_date` = '$to_date') AND YEAR(`trade`.`date`)=YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


