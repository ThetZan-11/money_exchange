<?php
    function add_duty($mysqli, $user_id, $counter_id, $from_date, $to_date){
        $sql = "INSERT INTO `duty` (`from_date`,`to_date`,`user_id`,`counter_id`) VALUE ('$from_date','$to_date','$user_id','$counter_id')";
        return $mysqli->query($sql);
    }

    function select_duty($mysqli){
        $sql = "SELECT `duty`.`id`,`user`.`name`,`counter`.`counter_name`,
        `counter`.`location`,`duty`.`from_date`,`duty`.`to_date` FROM `duty` 
        INNER JOIN `user` on `user`.`id` = `duty`.`user_id` 
        INNER JOIN `counter` ON `counter`.`id` = `duty`.`counter_id` WHERE `duty`.`soft_delete`=0";
        return $mysqli->query($sql);
    }   

    

    function get_duites_with_id($mysqli , $id){
        $sql = "SELECT `user`.`name`, `counter`.`counter_name`, `counter`.`id`,`duty`.`from_date`,`duty`.`to_date`, `duty`.`counter_id`,`duty`.`user_id`  FROM `duty` INNER JOIN `user` ON `user`.`id`=`duty`.`user_id` INNER JOIN `counter` ON `counter`.`id`=`duty`.`counter_id` WHERE `user`.`role`=2 AND `duty`.`id` = '$id'";
        return $mysqli->query($sql);
    }

    function update_duty ($mysqli , $id , $counter_id , $user_id , $from_date , $to_date){
        $sql = "UPDATE `duty` SET `counter_id` = '$counter_id' , `user_id` = '$user_id' , `from_date` = '$from_date',
        `to_date` = '$to_date'  WHERE `id` = '$id'";
        return $mysqli->query($sql);
    }

    function get_counter_id_with_user_id($mysqli, $user_id){
        $sql = "SELECT `counter`.`id` FROM `duty` 
        INNER JOIN counter ON `counter`.`id` = `duty`.`counter_id` 
        INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
        where `duty`.`user_id` = '$user_id' AND `duty`.`soft_delete` = 0";
        $result =  $mysqli->query($sql);
        return  $result->fetch_assoc();
    }

    function duty_soft_delete($mysqli, $id){
        $sql = "UPDATE `duty` SET `soft_delete` = 1 WHERE `id` = '$id'";
        return $mysqli->query($sql);
    }

    function duty_validate_with_date($mysqli, $counter_id, $user_id, $date){
        $sql = "SELECT `id` FROM `duty` where '$date' 
        BETWEEN `duty`.`from_date` AND `duty`.`to_date` 
        AND `counter_id` = '$counter_id' 
        AND `user_id` = '$user_id' AND `duty`.`soft_delete` = 0";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function duty_validate_date_counter($mysqli, $date, $user_id){
        $sql = "SELECT COUNT(`counter`.`id`) AS 'count' FROM `duty` 
        INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` INNER JOIN counter ON `counter`.`id` = `duty`.`counter_id` 
        WHERE '$date' BETWEEN `duty`.`from_date` AND `duty`.`to_date` AND `user`.`id` = '$user_id' AND `duty`.`soft_delete` = 0";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    function duty_validate_counter_id($mysqli, $date, $user_id, $counter_id){
        $sql= "SELECT `duty`.`counter_id` AS `counter_id` FROM `duty` 
        INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` INNER JOIN counter ON `counter`.`id` = `duty`.`counter_id` 
        WHERE '$date' BETWEEN `duty`.`from_date` AND `duty`.`to_date` 
        AND `user`.`id` = '$user_id' AND `counter`.`id` != '$counter_id' AND `duty`.`soft_delete` = 0";
        return $mysqli->query($sql);
    }

    function search_duty ($mysqli, $search){
        $sql = "SELECT * FROM `duty` 
        INNER JOIN `user` on `user`.`id` = `duty`.`user_id` 
        INNER JOIN `counter` ON `counter`.`id` = `duty`.`counter_id` 
        WHERE `user`.`name` LIKE '%$search%' AND `duty`.`soft_delete`= 0 
        OR `counter`.`counter_name` LIKE '%$search%' AND `duty`.`soft_delete`= 0 
        OR `counter`.`location` LIKE '%$search%' AND `duty`.`soft_delete`= 0 
        OR `duty`.`from_date` LIKE '%$search%' AND `duty`.`soft_delete`= 0 
        OR `duty`.`to_date` LIKE '%$search%' AND `duty`.`soft_delete`= 0";
        return $mysqli->query($sql);
    }

    function staff_count_validate ($mysqli, $from, $to, $counter_id){
        $sql = "SELECT COUNT(`user`.`id`) AS `staff_count` FROM `duty` 
        INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
        INNER JOIN `counter` ON `counter`.`id` = `duty`.`counter_id` 
        WHERE '$from' AND '$to' BETWEEN `duty`.`from_date` AND `duty`.`to_date` AND `counter`.`id` = '$counter_id' AND `duty`.`soft_delete` = 0";
        $result = $mysqli->query($sql);
        return $result->fetch_assoc();
    }

    

   
