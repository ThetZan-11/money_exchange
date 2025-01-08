<?php
    function add_duty($mysqli, $user_id, $counter_id, $from_date, $to_date){
        $sql = "INSERT INTO `duty` (`from_date`,`to_date`,`user_id`,`counter_id`) VALUE ('$from_date','$to_date','$user_id','$counter_id')";
        return $mysqli->query($sql);
    }

    function select_duty($mysqli){
        $sql = "SELECT `duty`.`id`,`user`.`name`,`counter`.`counter_name`,`counter`.`location`,`duty`.`from_date`,`duty`.`to_date` FROM `duty` INNER JOIN `user` on `user`.`id` = `duty`.`user_id` INNER JOIN `counter` ON `counter`.`id` = `duty`.`counter_id`";
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
        $sql = "SELECT `counter`.`id` FROM `duty` INNER JOIN counter ON `counter`.`id` = `duty`.`counter_id` INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` where `duty`.`user_id` = '$user_id'";
        $result =  $mysqli->query($sql);
        return  $result->fetch_assoc();
    }
