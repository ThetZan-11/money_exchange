<?php


function add_currency($mysqli, $currencyName, $currencyCode, $total , $flag){
    $sql = "INSERT INTO `currency` (`currency_name`,`currency_code`,`total`,`flag`,`soft_delete`)
    VALUES ('$currencyName','$currencyCode','$total','$flag', 0)";
    return $mysqli->query($sql);
}

function update_currency($mysqli, $id ,$currencyName,$currencyCode,$total,$flag){
    $sql = "UPDATE `currency` SET `currency_name`='$currencyName', `currency_code`='$currencyCode',`total`='$total',`flag`='$flag' WHERE `id`=$id";
    return $mysqli->query($sql);
}

function get_all_currency($mysqli){
    $sql = "SELECT * FROM `currency` WHERE `soft_delete` = 0 ";
    return $mysqli->query($sql);    
}



function get_buy_name_code($mysqli){
    $sql = "SELECT DISTINCT `buy_currency_name`,`buy_currency_code` FROM `currency` WHERE `soft_delete` = 0 ";
    return $mysqli->query($sql);    
}

function get_sell_name_code($mysqli){
    $sql = "SELECT DISTINCT `sell_currency_name`,`sell_currency_code` FROM `currency` WHERE `soft_delete` = 0 ";
    return $mysqli->query($sql);    
}

function get_currency_with_id($mysqli, $id){
    $sql = "SELECT * FROM `currency` WHERE `id`='$id' AND `soft_delete` = 0 ";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function soft_delete_currency ($mysqli , $id)
{
    $sql ="UPDATE  `currency` SET `soft_delete` = 1 WHERE `id` = $id";
    return $mysqli->query($sql);
}

function currency_sd ($mysqli)
{
    $sql = "SELECT * FROM `currency`  WHERE `soft_delete` = 0";
    return $mysqli->query($sql);
}

function currency_search ($mysqli ,$key)
{
    $sql = "SELECT * FROM `currency` WHERE
    `currency_name` LIKE '%$key%' AND `soft_delete` = 0  
    OR `currency_code` LIKE '%$key%' AND `soft_delete` = 0  
    OR `total` LIKE '%$key%' AND `soft_delete` = 0";
    return $mysqli->query($sql);
}

function currency_pair_search($mysqli, $key){
    $sql = "SELECT `currency_pair`.`id` AS `pair_id`,`buy_currency`.`currency_name` AS `buy_currency_name`, `sell_currency`.`currency_name` AS `sell_currency_name`  FROM `currency_pair`
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id`
    WHERE `buy_currency`.`currency_name` LIKE '%$key%' AND `currency_pair`.`soft_delete` = 0 
    OR `sell_currency`.`currency_name` LIKE '%$key%' AND `currency_pair`.`soft_delete` = 0 ";
    return $mysqli->query($sql);
}

function currencypair_validate($mysqli, $buy_id, $sell_id){
    $sql = "SELECT * FROM `currency_pair` WHERE 
    `currency_pair`.`buy_currency_id` = '$buy_id' AND `currency_pair`.`sell_currency_id` = '$sell_id'
    AND `currency_pair`.`soft_delete` = 0 ";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
}

function currency_pair_with_id($mysqli, $id){
    $sql = "SELECT * FROM `currency_pair` WHERE `currency_pair`.`id` = '$id' AND `currency_pair`.`soft_delete` = 0";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
}

function add_currency_pair($mysqli, $buy_currency_id, $sell_currency_id){
    $sql = "INSERT INTO `currency_pair` (`buy_currency_id`,`sell_currency_id`)
    VALUES ('$buy_currency_id', '$sell_currency_id')";
    return $mysqli->query($sql);
}

function soft_delete_currency_pair($mysqli, $id){
    $sql = "UPDATE `currency_pair` SET `soft_delete` = 1 WHERE `id`='$id'";
    return $mysqli->query($sql);
}




function get_currencypair_id($mysqli, $buy_currency_id, $sell_currency_id){
    $sql = "SELECT `currency_pair`.`id` FROM `currency_pair` 
    WHERE `currency_pair`.`buy_currency_id` = '$buy_currency_id' AND `currency_pair`.`sell_currency_id` = '$sell_currency_id'
    AND `currency_pair`.`soft_delete` = 0 ";
    return $mysqli->query($sql);
}

function get_all_currency_pair($mysqli){
    $sql = "SELECT `currency_pair`.`id` AS `pair_id`,
    CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name`
    FROM `currency_pair`
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `currency_pair`.`soft_delete` = 0";
    return $mysqli->query($sql);
}

function get_all_currency_pair_separate($mysqli){
    $sql = "SELECT `currency_pair`.`id` AS `pair_id`,
    `buy_currency`.`currency_name` AS `buy_currency_name`, `sell_currency`.`currency_name` AS `sell_currency_name`
    FROM `currency_pair`
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `currency_pair`.`soft_delete` = 0";
    return $mysqli->query($sql);
}

function add_currency_pair_counter($mysqli, $currency_pair_id, $counter_id){
    $sql = "INSERT INTO `currency_pair_counter` (`currency_pair_id`,`counter_id`,`status`,`soft_delete`) 
    VALUES ('$currency_pair_id','$counter_id',0,0)";
    return $mysqli->query($sql);
}

function update_currency_pair_counter($mysqli, $id, $currency_pair_id, $counter_id){
    $sql = "UPDATE `currency_pair_counter` SET `currency_pair_id`='$currency_pair_id', `counter_id`='$counter_id'
    WHERE `id` = '$id'";
    return $mysqli->query($sql);
}

function select_currencypair_counter_with_id($mysqli, $id){
    $sql = "SELECT `currency_pair_counter`.`counter_id`, `currency_pair_counter`.`currency_pair_id`,`counter`.`counter_name`,  
    CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name` 
    FROM `currency_pair_counter` INNER JOIN `counter` ON `counter`.`id` = `currency_pair_counter`.`counter_id` 
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `currency_pair_counter`.`currency_pair_id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `currency_pair_counter`.`id` = '$id'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
}

function show_currency_pair_counter($mysqli){
    $sql = "SELECT `counter`.`counter_name`, `currency_pair_counter`.`id`, `currency_pair_counter`.`status`,
    CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name` 
    FROM `currency_pair_counter` INNER JOIN `counter` ON `counter`.`id` = `currency_pair_counter`.`counter_id` 
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `currency_pair_counter`.`currency_pair_id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `currency_pair_counter`.`soft_delete` = 0";
    return $mysqli->query($sql);
}

function search_currency_pair_counter($mysqli, $key){
    $sql = "SELECT  CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name`,
    `counter`.`counter_name`, `currency_pair_counter`.`status`, `currency_pair_counter`.`id`
    FROM `currency_pair_counter` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_pair_counter`.`counter_id` 
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `currency_pair_counter`.`currency_pair_id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id`
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `counter`.`counter_name` LIKE '%$key%' AND `currency_pair_counter`.`soft_delete` = 0 
    OR `buy_currency`.`currency_name` LIKE '%$key%' AND `currency_pair_counter`.`soft_delete` = 0
    OR `sell_currency`.`currency_name` LIKE '%$key%' AND `currency_pair_counter`.`soft_delete` = 0  ";
    return $mysqli->query($sql);
}

function status_on($mysqli, $id){
    $sql = "UPDATE `currency_pair_counter` SET `status` = true WHERE `id`='$id'";
    return $mysqli->query($sql);
}

function status_off($mysqli, $id){
    $sql = "UPDATE `currency_pair_counter` SET `status` = false WHERE `id`='$id'";
    return $mysqli->query($sql);
}

function currency_with_counter($mysqli, $currency_id, $counter_id){
    $sql = "SELECT `id` FROM `cash_flow` WHERE `counter_id` = '$counter_id' AND `currency_id` = '$currency_id'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
}

function cash_flow_with_counter_id($mysqli, $counter_id){
    $sql = "SELECT `counter`.`counter_name`,`currency`.`currency_name`,`currency`.`currency_code`,`cash_flow`.`total`,`cash_flow`.`id` FROM `cash_flow` 
    INNER JOIN `currency` ON `currency`.`id` = `cash_flow`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `cash_flow`.`counter_id` WHERE `counter`.`id` = '$counter_id'";
    return $mysqli->query($sql);
}







