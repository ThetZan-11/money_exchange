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
        `daily_exchange`.`buy_rate`,`daily_exchange`.`sell_rate`, `daily_exchange`.`date` FROM `daily_exchange` 
        INNER JOIN `currency_pair` ON `currency_pair`.`id` = `daily_exchange`.`currency_pair_id` 
        INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id` 
        INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
        WHERE `daily_exchange`.`date` = '$date_now' ORDER BY `pair_name` DESC";
        return $mysqli->query($sql);
    }

   function select_rates($mysqli, $buy_currency, $sell_currency){
    $sql = "SELECT `currency`.`buy_currency_name`,`currency`.`sell_currency_name`,
    `currency`.`buy_currency_code`,`currency`.`sell_currency_code`,`daily_exchange`.`sell_rate`,
    `daily_exchange`.`buy_rate` FROM `daily_exchange` 
    INNER JOIN `currency` ON `daily_exchange`.`currency_id` = `currency`.`id` 
    WHERE `currency`.`buy_currency_code`='$buy_currency' 
    AND `currency`.`sell_currency_code`='$sell_currency'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

   function select_lastdate_record($mysqli){
    $sql = "SELECT * FROM `daily_exchange` WHERE `date` = CURRENT_DATE ORDER BY `id` DESC LIMIT 1";
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

   function calculate_exchange($mysqli, $buy_code, $sell_code){
    $sql = "SELECT `daily_exchange`.`id`,`sell_currency`.`flag` AS `sell_flag`,`buy_currency`.`flag` AS `buy_flag`,
    `buy_currency`.`currency_name` AS `buy_currency_name`,`sell_currency`.`currency_name` AS `sell_currency_name`,
    `daily_exchange`.`buy_rate`,`daily_exchange`.`sell_rate` FROM `daily_exchange`
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `daily_exchange`.`currency_pair_id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id` 
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `daily_exchange`.`date` = CURRENT_DATE AND `buy_currency`.`currency_code` = '$buy_code' 
    AND `sell_currency`.`currency_code` = '$sell_code'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }



   function select_details_for_trade($mysqli, $from_date, $to_date, $user_id, $buy_id, $sell_id){
    $sql = "SELECT `counter`.`counter_name`, `counter`.`id` AS `counter_id`, 
    `currency_pair_counter`.`id` AS `currency_pair_counter_id` from `duty` 
    INNER JOIN `counter` ON `counter`.`id` = `duty`.`counter_id` 
    INNER JOIN `currency_pair_counter` ON `currency_pair_counter`.`counter_id` = `counter`.`id` 
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `currency_pair_counter`.`currency_pair_id` 
    WHERE `duty`.`from_date` = '$from_date' AND `duty`.`to_date` = '$to_date' AND `duty`.`user_id` = '$user_id' 
    AND `currency_pair`.`buy_currency_id` = '$buy_id' AND `currency_pair`.`sell_currency_id` = '$sell_id'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

   function calculate_exchange_for_staff($mysqli, $currency_pair_id , $date){
    $sql = "SELECT `daily_exchange`.`id` AS `daily_exchange_id`,`sell_currency`.`flag` AS `sell_flag`,`buy_currency`.`flag` AS `buy_flag`,
    `buy_currency`.`currency_name` AS `buy_currency_name`,`sell_currency`.`currency_name` AS `sell_currency_name`,
    `buy_currency`.`id` AS `buy_currency_id`,`sell_currency`.`id` AS `sell_currency_id`,
    `daily_exchange`.`buy_rate`,`daily_exchange`.`sell_rate`,`currency_pair_counter`.`id` AS `currency_pair_counter_id` FROM `daily_exchange`
    INNER JOIN `currency_pair` ON `currency_pair`.`id` = `daily_exchange`.`currency_pair_id` 
    INNER JOIN `currency_pair_counter` ON `currency_pair_counter`.`currency_pair_id` = `currency_pair`.`id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id` 
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    WHERE `daily_exchange`.`date` = '$date' AND `currency_pair`.`id` = '$currency_pair_id'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

function select_currency_for_counter($mysqli, $from, $to, $user_id){
    $sql = "SELECT `buy_currency`.`id` AS `buy_id`,`sell_currency`.`id` AS `sell_id`,
    `currency_pair`.`id` AS `currency_pair_id`,`currency_pair_counter`.`id` as `pair_counter_id`,
    CONCAT(`buy_currency`.`currency_name`, ' to ', `sell_currency`.`currency_name`) AS `pair_name`
    FROM `currency_pair_counter` INNER JOIN `currency_pair` ON `currency_pair`.`id` = `currency_pair_counter`.`currency_pair_id` 
    INNER JOIN `currency` AS `sell_currency` ON `currency_pair`.`sell_currency_id` = `sell_currency`.`id` 
    INNER JOIN `currency` AS `buy_currency` ON `currency_pair`.`buy_currency_id` = `buy_currency`.`id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_pair_counter`.`counter_id` 
    WHERE `counter`.`id` = (SELECT `counter`.`id` FROM `counter` INNER JOIN `duty` ON `counter`.`id` = `duty`.`counter_id` 
    WHERE `duty`.`from_date` = '$from' AND `duty`.`to_date` = '$to' AND `duty`.`user_id` = '$user_id') 
    AND `currency_pair_counter`.`status` = true";
    return $mysqli->query($sql);
}
  