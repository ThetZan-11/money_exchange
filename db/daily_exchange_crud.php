<?php

    function update_daily($mysqli, $buy_rate, $sell_rate, $date, $buy_currency_id, $sell_currency_id){
        $sql = "UPDATE `daily_exchange` SET `buy_rate` = '$buy_rate',
        `sell_rate` = '$sell_rate',
        `date`= '$date' 
        WHERE `id` = (SELECT `id` FROM `currency_pair` WHERE `buy_currency_id`='$buy_currency_id' 
        AND `sell_currency_id`='$sell_currency_id' AND soft_delete = 0 LIMIT 1 ) AND `date`= $date ";
        return $mysqli->query($sql);
    }

    function add_new_rate($mysqli, $buy_rate, $sell_rate, $date, $buy_currency_id, $sell_currency_id){
        $sql = "INSERT INTO `daily_exchange` (`buy_rate`,`sell_rate`,`date`,`currency_pair_id`, `soft_delete`) 
        VALUES ('$buy_rate','$sell_rate','$date',
        (SELECT `id` FROM `currency_pair` WHERE `buy_currency_id`='$buy_currency_id' 
        AND `sell_currency_id`='$sell_currency_id' AND soft_delete = 0 LIMIT 1 ),0)";
        return $mysqli->query($sql);
    }

    function show_daily_update($mysqli, $date_now){
        $sql = "SELECT CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name`,
        `daily_exchange`.`buy_rate`,`daily_exchange`.`sell_rate` FROM `daily_exchange` 
        INNER JOIN `currency_pair` ON `currency_pair`.`id` = `daily_exchange`.`currency_pair_id` 
        INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id` 
        INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
        WHERE `daily_exchange`.`date` = '$date_now' ORDER BY `pair_name` DESC";
        return $mysqli->query($sql);
    }

   function select_rates($mysqli, $buy_currency, $sell_currency){
    $sql = "SELECT `currency`.`buy_currency_name`,`currency`.`sell_currency_name`,`currency`.`buy_currency_code`,`currency`.`sell_currency_code`,`daily_exchange`.`sell_rate`,`daily_exchange`.`buy_rate` FROM `daily_exchange` INNER JOIN `currency` ON `daily_exchange`.`currency_id` = `currency`.`id` WHERE `currency`.`buy_currency_code`='$buy_currency' AND `currency`.`sell_currency_code`='$sell_currency'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }


   function select_currency_code($mysqli){
    $sql = "SELECT `currency_code`,`id` FROM `currency` WHERE `soft_delete` = 0";
    return $mysqli->query($sql);
   }

   function select_date($mysqli){
    $sql = "SELECT `date` FROM `daily_exchange` ORDER BY `id` DESC LIMIT 1";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

 

  