<?php  
    
    function add_trade($mysqli, $exchange_amount, $converted_amount, $date, $currency_counter_id, $customer_id){
        $sql = "INSERT INTO `trade` (`exchange_amount`, `converted_amount`, `date`, `currency_counter_id`, `customer_id`, `soft_delete`) VALUES ('$exchange_amount', '$converted_amount', '$date', '$currency_counter_id', '$customer_id', 0)";
        return $mysqli->query($sql);
    } 
    
    function show_trades($mysqli){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`, `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`, `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` WHERE `trade`.`soft_delete` = 0";
        return $mysqli->query($sql);
    }