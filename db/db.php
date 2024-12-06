<?php

try {
    $mysqli = new mysqli("localhost", "root", "");
    $sql = "CREATE DATABASE IF NOT EXISTS `money_exchange`";
    if ($mysqli->query($sql)) {
        if ($mysqli->select_db("money_exchange")) {
            create_table($mysqli);
        }
    }
} catch (\Throwable $th) {
    echo "Can not connect to Database!";
    die();
}

function create_table($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `user`(`id` INT AUTO_INCREMENT NOT NULL,`name` VARCHAR(45) NOT NULL,`email` VARCHAR(95) UNIQUE NOT NULL,`password` VARCHAR(100) NOT NULL, `address` VARCHAR(255) NOT NULL,`ph_no` VARCHAR(255) NOT NULL,`role` INT NOT NULL,`user_img` VARCHAR(225) NOT NULL ,PRIMARY KEY(`id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    return true;
}