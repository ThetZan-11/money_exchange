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
    $sql = "CREATE TABLE IF NOT EXISTS `user`(`id` INT AUTO_INCREMENT NOT NULL,`name` VARCHAR(45) NOT NULL,`email` VARCHAR(95) UNIQUE NOT NULL,`password` VARCHAR(100) NOT NULL, `address` VARCHAR(255) NOT NULL,`ph_no` VARCHAR(255) NOT NULL,`role` INT NOT NULL,`user_img` VARCHAR(225) NOT NULL ,  `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `customer`(`id` INT AUTO_INCREMENT,`name` VARCHAR(100) NOT NULL,`email` VARCHAR(95) UNIQUE, `address` VARCHAR(255) NOT NULL,`ph_no` VARCHAR(255) NOT NULL,  `soft_delete` boolean DEFAULT 0  ,PRIMARY KEY(`id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `counter` (`id` INT AUTO_INCREMENT,`counter_name` VARCHAR(50) UNIQUE NOT NULL,`location` VARCHAR(100) NOT NULL,   `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `currency` (`id` INT AUTO_INCREMENT,`currency_name` VARCHAR(100) UNIQUE NOT NULL,`buy_currency_name` VARCHAR(100) NOT NULL, `buy_currency_code` VARCHAR(100) NOT NULL,`sell_currency_name` VARCHAR(100) NOT NULL, `sell_currency_code` VARCHAR(100) NOT NULL, `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `duty`(`id` INT AUTO_INCREMENT,`from_date` DATE NOT NULL,`to_date` DATE NOT NULL,`user_id` INT NOT NULL,`counter_id` INT NOT NULL,   `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`), FOREIGN KEY (`user_id`) REFERENCES `user`(`id`), FOREIGN KEY (`counter_id`) REFERENCES `counter`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `currency_counter`(`id` INT AUTO_INCREMENT,`currency_id` INT NOT NULL,`counter_id` INT NOT NULL, `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`), FOREIGN KEY (`currency_id`) REFERENCES `currency`(`id`), FOREIGN KEY (`counter_id`) REFERENCES `counter`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `daily_exchange`(`id` INT AUTO_INCREMENT,`sell_rate` FLOAT NOT NULL,`buy_rate` FLOAT NOT NULL,`date` DATE NOT NULL,`currency_id` INT NOT NULL,   `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`), FOREIGN KEY (`currency_id`) REFERENCES `currency`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `trade`(`id` INT AUTO_INCREMENT,`exchange_amount` FLOAT NOT NULL,`converted_amount` FLOAT NOT NULL,`date` DATE NOT NULL,`currency_counter_id` INT NOT NULL,`customer_id` INT NOT NULL,`soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`), PRIMARY KEY(`id`), FOREIGN KEY (`currency_counter_id`) REFERENCES `currency_counter`(`id`), FOREIGN KEY (`customer_id`) REFERENCES `customer`(`id`))";    
    if(!$mysqli->query($sql)){
        return false;
    }

    return true;
}