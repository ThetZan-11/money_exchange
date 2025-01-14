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
    $sql = "SELECT * FROM `currency` WHERE `id`=$id AND `soft_delete` = 0 ";
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
    $sql = "SELECT * FROM `currency` WHERE `currency_name` LIKE '%$key%' AND `soft_delete` = 0  
    OR `buy_currency_name` LIKE '%$key%' AND `soft_delete` = 0  
    OR `buy_currency_code` LIKE '%$key%' AND `soft_delete` = 0  
    OR `sell_currency_name` LIKE '%$key%' AND `soft_delete` = 0  
    OR `sell_currency_code` LIKE '%$key%' AND `soft_delete` = 0 ";
     return $mysqli->query($sql);
}



