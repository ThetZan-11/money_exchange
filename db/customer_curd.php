<?php

function get_customer ($mysqli){
    $sql = "SELECT * FROM `customer`";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

