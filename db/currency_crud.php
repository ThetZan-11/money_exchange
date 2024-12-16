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
    $sql = "UPDATE `currency` SET `currency_name`='$currencyName', `sell_currency_name`='$sellCurrencyName',`sell_currency_code`='$sellCurrencyCode',`buy_currency_name`='$buyCurrencyName',`buy_currency_code`='$buyCurrencyCode'";
    return $mysqli->query($sql);
}




