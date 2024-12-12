<?php

function get_customer ($mysqli){
    $sql = "SELECT * FROM `customer`";
    return $mysqli->query($sql); 
}

function delete_customer($mysqli , $id){
    $sql = "DELETE FROM `customer` WHERE `id`=$id";
    return $mysqli->query($sql); 
}
