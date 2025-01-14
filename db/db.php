<?php

try {
    $mysqli = new mysqli("localhost", "root", "");
    $sql = "CREATE DATABASE IF NOT EXISTS `money_exchange_new`";
    if ($mysqli->query($sql)) {
        if ($mysqli->select_db("money_exchange_new")) {
            create_table($mysqli);
        }
    }
} catch (\Throwable $th) {
    echo "Can not connect to Database!";
    die();
}

function create_table($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `user`
    (`id` INT AUTO_INCREMENT NOT NULL,`name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(95) UNIQUE NOT NULL,
    `password` VARCHAR(100) NOT NULL, 
    `address` VARCHAR(255) NOT NULL,
    `ph_no` VARCHAR(255) NOT NULL,
    `role` INT NOT NULL,
    `user_img` VARCHAR(225) NOT NULL,
    `soft_delete` boolean DEFAULT 0 ,
    PRIMARY KEY(`id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `customer`
    (`id` INT AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(95) UNIQUE, 
    `address` VARCHAR(255) NOT NULL,
    `ph_no` VARCHAR(255) NOT NULL,  
    `soft_delete` boolean DEFAULT 0,
    PRIMARY KEY(`id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `counter` 
    (`id` INT AUTO_INCREMENT,
    `counter_name` VARCHAR(50) UNIQUE NOT NULL,
    `location` VARCHAR(100) NOT NULL,   
    `soft_delete` boolean DEFAULT 0 ,
    PRIMARY KEY(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `currency` 
    (`id` INT AUTO_INCREMENT,
    `currency_name` VARCHAR(100) UNIQUE NOT NULL,
    `currency_code` VARCHAR(100) UNIQUE NOT NULL,
    `total` float NOT NULL, 
    `flag` VARCHAR(255) NOT NULL,
    `soft_delete` boolean DEFAULT 0,
    PRIMARY KEY(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `duty`
    (`id` INT AUTO_INCREMENT,
    `from_date` DATE NOT NULL,
    `to_date` DATE NOT NULL,
    `user_id` INT NOT NULL,
    `counter_id` INT NOT NULL,   
    `soft_delete` boolean DEFAULT 0 ,
    PRIMARY KEY(`id`), 
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`),
    FOREIGN KEY (`counter_id`) REFERENCES `counter`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `currency_pair`
    (`id` INT AUTO_INCREMENT,
    `buy_currency_id` INT NOT NULL,
    `sell_currency_id` INT NOT NULL, 
    `soft_delete` boolean DEFAULT 0 ,PRIMARY KEY(`id`), 
    FOREIGN KEY (`buy_currency_id`) REFERENCES `currency`(`id`), 
    FOREIGN KEY (`sell_currency_id`) REFERENCES `currency`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }
    

    $sql = "CREATE TABLE IF NOT EXISTS `daily_exchange`
    (`id` INT AUTO_INCREMENT,
    `sell_rate` FLOAT NOT NULL,
    `buy_rate` FLOAT NOT NULL,
    `date` DATE NOT NULL,
    `currency_pair_id` INT NOT NULL,   
    `soft_delete` boolean DEFAULT 0,
    PRIMARY KEY(`id`), 
    FOREIGN KEY (`currency_pair_id`) REFERENCES `currency_pair`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `cash_flow`
    (`id` INT AUTO_INCREMENT,
    `total` FLOAT NOT NULL,
    `counter_id` INT NOT NULL,
    `currency_id` INT NOT NULL,
    `soft_delete` boolean DEFAULT 0,
    PRIMARY KEY(`id`), 
    FOREIGN KEY (`counter_id`) REFERENCES `counter`(`id`),
    FOREIGN KEY (`currency_id`) REFERENCES `currency`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `currency_pair_counter`
    (`id` INT AUTO_INCREMENT,
    `currency_pair_id` INT NOT NULL,
    `counter_id` INT NOT NULL,
    `status` boolean NOT NULL,
    `soft_delete` boolean DEFAULT 0,
    PRIMARY KEY(`id`), 
    FOREIGN KEY (`currency_pair_id`) REFERENCES `currency_pair`(`id`),
    FOREIGN KEY (`counter_id`) REFERENCES `counter`(`id`))";
    if(!$mysqli->query($sql)){
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `trade`
    (`id` INT AUTO_INCREMENT,
    `from_amount` FLOAT NOT NULL,
    `to_amount` FLOAT NOT NULL,
    `date` DATE NOT NULL,
    `daily_exchange_id` INT NOT NULL,
    `customer_id` INT NOT NULL,
    `duty_id` INT NOT NULL,
    `currency_pair_id` INT NOT NULL,
    `soft_delete` boolean DEFAULT 0, 
    PRIMARY KEY(`id`), 
    FOREIGN KEY (`daily_exchange_id`) REFERENCES `daily_exchange`(`id`), 
    FOREIGN KEY (`customer_id`) REFERENCES `customer`(`id`),
    FOREIGN KEY (`duty_id`) REFERENCES `duty`(`id`),
    FOREIGN KEY (`currency_pair_id`) REFERENCES `currency_pair`(`id`))";    
    if(!$mysqli->query($sql)){
        return false;
    }

    return true;
}