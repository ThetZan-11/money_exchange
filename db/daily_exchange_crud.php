<?php

    function update_daily($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency){
        $sql = "UPDATE `daily_exchange` JOIN `currency` ON 
        `daily_exchange`.`currency_id` = `currency`.`id` 
        SET `daily_exchange`.`sell_rate` = '$sell_rate',
        `daily_exchange`.`buy_rate` = '$buy_rate',
        `daily_exchange`.`date`= '$date' 
        WHERE `currency`.`buy_currency_code` = '$buy_currency' AND `currency`.`sell_currency_code`='$sell_currency' AND `daily_exchange`.`date`='$date' ";
        return $mysqli->query($sql);
    }

    function add_new_rate($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency){
        $sql = "INSERT INTO `daily_exchange` (`sell_rate`,`buy_rate`,`date`,`currency_id`) VALUES ('$sell_rate','$buy_rate','$date',(SELECT `id` FROM `currency` WHERE `buy_currency_code`='$buy_currency' AND `sell_currency_code`='$sell_currency' LIMIT 1))";
        return $mysqli->query($sql);
    }

    function show_daily_update($mysqli, $date_now_select){
        $sql = "SELECT `currency`.`currency_name`, `daily_exchange`.`buy_rate`, `daily_exchange`.`sell_rate` FROM `daily_exchange` INNER JOIN `currency` ON `currency`.`id` = `daily_exchange`.`currency_id` WHERE `currency`.`buy_currency_code`!=`currency`.`sell_currency_code` AND `daily_exchange`.`date`='$date_now_select'";
        return $mysqli->query($sql);
    }

   function select_rates($mysqli, $buy_currency, $sell_currency){
    $sql = "SELECT `currency`.`buy_currency_name`,`currency`.`sell_currency_name`,`currency`.`buy_currency_code`,`currency`.`sell_currency_code`,`daily_exchange`.`sell_rate`,`daily_exchange`.`buy_rate` FROM `daily_exchange` INNER JOIN `currency` ON `daily_exchange`.`currency_id` = `currency`.`id` WHERE `currency`.`buy_currency_code`='$buy_currency' AND `currency`.`sell_currency_code`='$sell_currency'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

   function select_only_sell_code($mysqli){
    $sql = "SELECT DISTINCT `sell_currency_code` FROM `currency`";
    return $mysqli->query($sql);
    //return $result->fetch_assoc();
   }

   function select_only_buy_code($mysqli){
    $sql = "SELECT DISTINCT `buy_currency_code` FROM `currency`";
    return $mysqli->query($sql);
   }

   function select_date($mysqli){
    $sql = "SELECT `date` FROM `daily_exchange` ORDER BY `id` DESC LIMIT 1";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
   }

 

  