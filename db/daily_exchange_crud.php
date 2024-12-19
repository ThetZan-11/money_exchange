<?php

    function update_daily($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency){
        $sql = "UPDATE `daily_exchange` JOIN `currency` ON 
        `daily_exchange`.`currency_id` = `currency`.`id` 
        SET `daily_exchange`.`sell_rate` = '$sell_rate',
         `daily_exchange`.`buy_rate` = '$buy_rate',
          `daily_exchange`.`date`= '$date' 
          WHERE `currency`.`buy_currency_code` = '$buy_currency' AND `currency`.`sell_currency_code`='$sell_currency' ";
        return $mysqli->query($sql);
    }

    function show_daily_update($mysqli){
        $sql = "SELECT `currency`.`currency_name`, `daily_exchange`.`buy_rate`, `daily_exchange`.`sell_rate` FROM `daily_exchange` INNER JOIN `currency` ON `currency`.`id` = `daily_exchange`.`currency_id`";
        return $mysqli->query($sql);
    }


    function add_daily($mysqli, $sell_rate,$buy_rate,$date,$currency_id){
        $sql = "INSERT INTO `daily_exchange` (`sell_rate`,`buy_rate`,`date`,`currency_id`) VALUE ('$sell_rate','$buy_rate','$date','$currency_id')";
        return $mysqli->query($sql);
    }


   function select_rates($mysqli, $buy_currency, $sell_currency){
    $sql = "SELECT `currency`.`buy_currency_code`,`currency`.`sell_currency_code`,`daily_exchange`.`sell_rate`,`daily_exchange`.`buy_rate` FROM `daily_exchange` INNER JOIN `currency` ON `daily_exchange`.`currency_id` = `currency`.`id` WHERE `currency`.`buy_currency_code`='$buy_currency' AND `currency`.`sell_currency_code`='$$sell_currency'";
    return $mysqli->query($sql);
   }