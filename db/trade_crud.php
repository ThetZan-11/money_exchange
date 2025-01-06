<?php  
    
    function add_trade($mysqli, $exchange_amount, $converted_amount, $date, $currency_counter_id, $customer_id){
        $sql = "INSERT INTO `trade` (`exchange_amount`, `converted_amount`, `date`, `currency_counter_id`, `customer_id`, `soft_delete`) VALUES ('$exchange_amount', '$converted_amount', '$date', '$currency_counter_id', '$customer_id', 0)";
        return $mysqli->query($sql);
    } 
    
    function show_trades($mysqli){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`, `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`, `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` WHERE `trade`.`soft_delete` = 0 ORDER BY `trade`.`id` DESC";
        return $mysqli->query($sql);
    }

    function show_trades_with_id($mysqli, $id){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`, `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`,`currency`.`buy_currency_code`, `currency`.`sell_currency_code`, `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` WHERE `trade`.`id` = '$id'";
        $result =  $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_sale_counter_today_filter($mysqli ,$email){
        $sql = "SELECT COUNT(*) AS `sale_count` FROM `trade` 
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
        WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
        INNER JOIN counter ON `duty`.`counter_id` = `counter`.`id` 
        INNER JOIN `user` ON `user`.`id`=`duty`.`user_id` 
        WHERE `user`.`role` = 2 AND `user`.`email` = '$email') AND `trade`.`date`=CURRENT_DATE";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_sale_counter_month_filter($mysqli, $email){
        $sql = "SELECT COUNT(*) AS `sale_count` FROM `trade` 
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
        WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
        INNER JOIN counter ON `duty`.`counter_id` = `counter`.`id` 
        INNER JOIN `user` ON `user`.`id`=`duty`.`user_id` 
        WHERE `user`.`role` = 2 AND `user`.`email` = '$email') AND MONTH(`trade`.`date`)=MONTH(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_sale_counter_year_filter($mysqli, $email){
        $sql = "SELECT COUNT(*) AS `sale_count` FROM `trade` 
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
        WHERE `currency_counter`.`counter_id` = (SELECT DISTINCT `counter`.`id` from `duty`
        INNER JOIN counter ON `duty`.`counter_id` = `counter`.`id` 
        INNER JOIN `user` ON `user`.`id`=`duty`.`user_id` 
        WHERE `user`.`role` = 2 AND `user`.`email` = '$email') AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function toal_amount_of_sell_currency($mysqli, $counter_id, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `counter`.`id` = '$counter_id' AND `currency`.`sell_currency_code` = '$sell_currency_code'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function toal_amount_of_buy_currency($mysqli, $counter_id, $buy_currency_code){
        $sql = "SELECT SUM(`trade`.`exchange_amount`) FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `counter`.`id` = '$counter_id' AND `currency`.`buy_currency_code` = '$buy_currency_code'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }
// buy    sell
// USD to MMK 
// 30    150000

// Percentage Change = (New Value−Old Value)/Old Value × 100 (Percent Change Formula)

function total_sale_admin_today_filter_counter ($mysqli, $counter_id){
    $sql = "SELECT COUNT(*) AS `sales` from `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
     WHERE `currency_counter`.`counter_id` = '$counter_id' AND `trade`.`date` = CURRENT_DATE";
     $result = $mysqli->query($sql);
     return $result->fetch_assoc();
}

function total_sale_admin_month_filter_counter ($mysqli, $counter_id){
    $sql = "SELECT COUNT(*) AS `sales` from `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
     WHERE `currency_counter`.`counter_id` = '$counter_id' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
     $result = $mysqli->query($sql);
     return $result->fetch_assoc();
}

function total_sale_admin_year_filter_counter ($mysqli, $counter_id){
    $sql = "SELECT COUNT(*) AS `sales` from `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
     WHERE `currency_counter`.`counter_id` = '$counter_id' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
     $result = $mysqli->query($sql);
     return $result->fetch_assoc();
}

function total_sale_admin($mysqli){
    $sql = "SELECT COUNT(`trade`.`id`) AS `sales` from `trade`";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_sale_admin_today($mysqli){
    $sql = "SELECT COUNT(`trade`.`id`) AS `sales` from `trade` WHERE `trade`.`date` = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_sale_admin_month($mysqli){
    $sql = "SELECT COUNT(`trade`.`id`) AS `sales` from `trade` WHERE MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_sale_admin_year($mysqli){
    $sql = "SELECT COUNT(`trade`.`id`) AS `sales` from `trade` WHERE YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_sale_from_counter($mysqli, $counter_id){
    $sql = "SELECT COUNT(`trade`.`id`) AS `sales` from `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
     WHERE `currency_counter`.`counter_id` = '$counter_id'";
     $result = $mysqli->query($sql);
     return $result->fetch_assoc();
}


 

    