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
        $sql = "SELECT `user`.`name`, `counter`.`counter_name`, `counter`.`id` FROM `duty` INNER JOIN `user` ON `user`.`id`=`duty`.`user_id` INNER JOIN `counter` ON `counter`.`id`=`duty`.`counter_id` WHERE `user`.`role`=2 AND `duty`.`id` = '$id'";
        return $mysqli->query($sql);
    }