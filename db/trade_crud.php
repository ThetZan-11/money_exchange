<?php  
    
    function add_trade($mysqli, $exchange_amount, $converted_amount, $date, $currency_counter_id, $customer_id){
        $sql = "INSERT INTO `trade` (`exchange_amount`, `converted_amount`, `date`, `currency_counter_id`, `customer_id`, `soft_delete`) VALUES ('$exchange_amount', '$converted_amount', '$date', '$currency_counter_id', '$customer_id', 0)";
        return $mysqli->query($sql);
    } 
    
    function show_trades($mysqli){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`,
        `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`,
        `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` 
        WHERE `trade`.`soft_delete` = 0 ORDER BY `trade`.`id` DESC";
        return $mysqli->query($sql);
    }

    function show_trades_with_id($mysqli, $id){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`, `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`,`currency`.`buy_currency_code`, `currency`.`sell_currency_code`, `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` WHERE `trade`.`id` = '$id'";
        $result =  $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function show_trades_with_counter($mysqli, $counter_id){
        $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,
        `trade`.`exchange_amount`, `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`,`currency`.`buy_currency_code`, `currency`.`sell_currency_code`, `trade`.`date` 
        FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` 
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id` 
        INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` 
        WHERE `currency_counter`.`counter_id` = '$counter_id' AND `trade`.`soft_delete` = 0 ORDER BY `trade`.`id` DESC";
        return $mysqli->query($sql);
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

// Sell rate Crud function
    function total_amount_of_sell_currency_MMK($mysqli){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = 'MMK'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }
    function total_amount_of_sell_currency($mysqli, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currencyToday($mysqli, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code' AND `trade`.`date` = CURRENT_DATE";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currencyMonth($mysqli, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currencyYear($mysqli, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currency_today($mysqli,$counter_id, $sell_currency_code, ){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code'
        AND `currency_counter`.`counter_id`= '$counter_id' AND `trade`.`date` = CURRENT_DATE";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currency_month($mysqli,$counter_id, $sell_currency_code, ){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code'
        AND `currency_counter`.`counter_id`= '$counter_id' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function total_amount_of_sell_currency_year($mysqli,$counter_id, $sell_currency_code, ){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `currency`.`sell_currency_code` = '$sell_currency_code'
        AND `currency_counter`.`counter_id`= '$counter_id' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    
    function toal_amount_of_sell_currency_counter($mysqli, $counter_id, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE `counter`.`id` = '$counter_id' AND `currency`.`sell_currency_code` = '$sell_currency_code'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function toal_amount_of_sell_currency_alltime($mysqli, $sell_currency_code){
        $sql = "SELECT SUM(`trade`.`converted_amount`) AS `sell_rate` FROM `trade`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
        WHERE  `currency`.`sell_currency_code` = '$sell_currency_code'";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    
//Buy Currency Crud function

function total_amount_of_buy_currency_MMK($mysqli){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`sell_currency_code` = 'MMK'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
function total_amount_of_buy_currency($mysqli, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currencyToday($mysqli, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code' AND `trade`.`date` = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currencyMonth($mysqli, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currencyYear($mysqli, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currency_today($mysqli,$counter_id, $buy_currency_code, ){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code'
    AND `currency_counter`.`counter_id`= '$counter_id' AND `trade`.`date` = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currency_month($mysqli,$counter_id, $buy_currency_code, ){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code'
    AND `currency_counter`.`counter_id`= '$counter_id' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_amount_of_buy_currency_year($mysqli,$counter_id, $buy_currency_code, ){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `currency`.`buy_currency_code` = '$buy_currency_code'
    AND `currency_counter`.`counter_id`= '$counter_id' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


function toal_amount_of_buy_currency_counter($mysqli, $counter_id, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE `counter`.`id` = '$counter_id' AND `currency`.`buy_currency_code` = '$buy_currency_code'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function toal_amount_of_buy_currency_alltime($mysqli, $buy_currency_code){
    $sql = "SELECT SUM(`trade`.`exchange_amount`) AS `buy_rate` FROM `trade`
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id`= `currency_counter`.`currency_id` 
    INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` 
    WHERE  `currency`.`buy_currency_code` = '$buy_currency_code'";
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

function total_tradeCustomer_today($mysqli){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
    where `trade`.`soft_delete` = 0 AND `trade`.`date` = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_tradeCustomer_month($mysqli){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
    where `trade`.`soft_delete` = 0 AND `trade`.`date` = MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_tradeCustomer_year($mysqli){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
    where `trade`.`soft_delete` = 0 AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_tradeCustomer($mysqli){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) AS `customer_count`
    FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
    where `trade`.`soft_delete` = 0";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_tradeCustomer_alltime($mysqli, $counter_id){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) AS `customer_count`
    FROM `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    where `trade`.`soft_delete` = 0 AND `currency_counter`.`counter_id`='$counter_id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_trade_customer_with_today($mysqli, $counter_id){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) AS `customer_count`
    FROM `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    where `trade`.`soft_delete` = 0 AND `currency_counter`.`counter_id`='$counter_id' AND `trade`.`date` = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_trade_customer_with_month($mysqli, $counter_id){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) AS `customer_count`
    FROM `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    where `trade`.`soft_delete` = 0 AND `currency_counter`.`counter_id`='$counter_id' AND MONTH(`trade`.`date`) = MONTH(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function total_trade_customer_with_year($mysqli, $counter_id){
    $sql = "SELECT COUNT(DISTINCT `trade`.`customer_id`) AS `customer_count`
    FROM `trade` INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    where `trade`.`soft_delete` = 0 AND `currency_counter`.`counter_id`='$counter_id' AND YEAR(`trade`.`date`) = YEAR(CURRENT_DATE)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function search_query_for_sale_record($mysqli, $key){
    $sql = "SELECT * from `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id` 
    INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
    INNER JOIN `currency` ON `currency`.`id` = `currency_counter`.`currency_id`
    WHERE `customer`.`name` LIKE '%$key%' OR `customer`.`email` LIKE '%$key%' OR `trade`.`exchange_amount` LIKE '%$key%' 
    OR `trade`.`converted_amount` LIKE '%$key%' OR `trade`.`date` LIKE '%$key%'
    OR `currency`.`buy_currency_name` LIKE '%$key%' OR `currency`.`sell_currency_name` LIKE '%$key%'";
    return $mysqli->query($sql);
}


 function sale_record_filter_counter($mysqli, $counter_id){
    $sql = "SELECT `trade`.`id`,`customer`.`name`, `customer`.`email`,`trade`.`exchange_amount`,
        `trade`.`converted_amount`, `currency`.`buy_currency_name`, `currency`.`sell_currency_name`,
        `trade`.`date` FROM `trade` INNER JOIN `customer` ON `customer`.`id` = `trade`.`customer_id`
        INNER JOIN `currency_counter` ON `currency_counter`.`id` = `trade`.`currency_counter_id`
        INNER JOIN `currency` ON `currency_counter`.`currency_id` = `currency`.`id` 
        WHERE `trade`.`soft_delete` = 0 AND `currency_counter`.`counter_id`= '$counter_id' ORDER BY `trade`.`id` DESC ";
    return $mysqli->query($sql);
 }

    