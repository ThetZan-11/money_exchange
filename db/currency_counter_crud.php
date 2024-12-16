<?php
    function add_currency_counter($mysqli, $counter_id, $currency_id){
        $sql = "INSERT INTO `currency_counter` (`counter_id`,`currency_id`) VALUE ('$counter_id','$currency_id')";
        return $mysqli->query($sql);
    }

    function edit_currency_counter($mysqli, $id, $counter_id, $currency_id){
        $sql = "UPDATE `currency_counter` SET `counter_id`=$counter_id, `currency_id`='$currency_id' WHERE `id`=$id";
        return $mysqli->query($sql);
    }

    function get_all_currency_counter($mysqli){
        $sql = "SELECT * FROM `currency_counter`";
        return $mysqli->query($sql);
    }

    function get_currency_counter($mysqli){
        $sql = "SELECT `currency_counter`.`id`,`counter`.`counter_name`,`currency`.`currency_name` FROM `currency_counter`INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` INNER JOIN `currency` ON `currency`.`id` = `currency_counter`.`currency_id`";
        return $mysqli->query($sql);
    }

    function get_currency_counter_with_id($mysqli, $id){
        $sql = "SELECT `currency`.`id` AS `id_for_currency`,`counter`.`id` AS `id_for_counter`,`currency_counter`.`id`,`counter`.`counter_name`,`currency`.`currency_name` FROM `currency_counter`INNER JOIN `counter` ON `counter`.`id` = `currency_counter`.`counter_id` INNER JOIN `currency` ON `currency`.`id` = `currency_counter`.`currency_id` WHERE `currency_counter`.`id`=$id";
        return $mysqli->query($sql);
    }

    
function delete_currency_counter($mysqli, $id){
    $sql = "DELETE FROM `currency_counter` WHERE `id`='$id'";
    return $mysqli->query($sql);
}

function get_currency_id_with_counter_id($mysqli,$id){
    $sql = "SELECT `currency_id` from `currency_counter` WHERE `counter_id`='$id'";
    $result =  $mysqli->query($sql);
    return $result->fetch_assoc();
}