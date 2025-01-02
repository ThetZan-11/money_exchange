<?php


function add_currency($mysqli, $currencyName, $sellCurrencyName, $sellCurrencyCode , $buyCurrencyName , $buyCurrencyCode){
    $sql = "INSERT INTO `currency` (`currency_name`,`sell_currency_name`,`sell_currency_code`,`buy_currency_name`,`buy_currency_code`)
    VALUE ('$currencyName','$sellCurrencyName','$sellCurrencyCode','$buyCurrencyName','$buyCurrencyCode')";
    return $mysqli->query($sql);
}

function get_all_currency($mysqli){
    $sql = "SELECT * FROM `currency`";
    return $mysqli->query($sql);    
}

function get_buy_name_code($mysqli){
    $sql = "SELECT DISTINCT `buy_currency_name`,`buy_currency_code` FROM `currency`";
    return $mysqli->query($sql);    
}

function get_sell_name_code($mysqli){
    $sql = "SELECT DISTINCT `sell_currency_name`,`sell_currency_code` FROM `currency`";
    return $mysqli->query($sql);    
}

function delete_currency($mysqli, $id){
    $sql = "DELETE FROM `currency` WHERE `id`=$id";
    return $mysqli->query($sql);
}

function get_currency_with_id($mysqli, $id){
    $sql = "SELECT * FROM `currency` WHERE `id`=$id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_currency($mysqli, $id ,$currencyName,$sellCurrencyName,$sellCurrencyCode,$buyCurrencyName,$buyCurrencyCode){
    $sql = "UPDATE `currency` SET `currency_name`='$currencyName', `sell_currency_name`='$sellCurrencyName',`sell_currency_code`='$sellCurrencyCode',`buy_currency_name`='$buyCurrencyName',`buy_currency_code`='$buyCurrencyCode' WHERE `id`=$id";
    return $mysqli->query($sql);
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




