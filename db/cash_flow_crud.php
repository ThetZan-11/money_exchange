<?php
    function save_cash_flow($mysqli, $counter_id, $currency_id, $total){
        $sql = "INSERT INTO `cash_flow` (`counter_id`,`currency_id`,`total`, `soft_delete`)
        VALUES ('$counter_id', '$currency_id', '$total', 0)";
        return $mysqli->query($sql);
    }

    function update_cash_flow($mysqli, $id, $counter_id, $currency_id, $total){
        $sql = "UPDATE `cash_flow` SET `counter_id`='$counter_id', `currency_id`='$currency_id', `total`='$total'
        WHERE `id`='$id'";
        return $mysqli->query($sql);
    }

    function select_cash_flow($mysqli){
        $sql = "SELECT `cash_flow`.`id`,`currency`.`currency_name`, `counter`.`counter_name`, `cash_flow`.`total`, `currency`.`currency_code` FROM `cash_flow` 
        INNER JOIN `currency` ON `currency`.`id` = `cash_flow`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `cash_flow`.`counter_id` WHERE `cash_flow`.`soft_delete` = 0";
        return $mysqli->query($sql);
    }

    function cash_flow_with_id($mysqli, $id){
        $sql = "SELECT `cash_flow`.`counter_id`,`cash_flow`.`currency_id`,`currency`.`currency_name`, `counter`.`counter_name`, `cash_flow`.`total`, `currency`.`currency_code` FROM `cash_flow` INNER JOIN `currency` ON `currency`.`id` = `cash_flow`.`currency_id` 
        INNER JOIN `counter` ON `counter`.`id` = `cash_flow`.`counter_id` 
        WHERE `cash_flow`.`id` = '$id' AND `cash_flow`.`soft_delete` = 0";
        $result =  $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function update_currency_total_for_insert($mysqli, $amount, $currency_id){
        $sql = "UPDATE `currency` SET `total`=`total`-'$amount' WHERE `id`='$currency_id'";
        return $mysqli->query($sql);
    }

    function update_currency_total_for_update($mysqli, $total,$old_amount, $new_amount, $currency_id){
        $sql = "UPDATE `currency` SET `total` = '$total' + '$old_amount' - '$new_amount' WHERE `id` = '$currency_id'";
        return $mysqli->query($sql);
    }
