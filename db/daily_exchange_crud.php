<?php

    function update_daily($mysqli, $id, $sell_rate, $buy_rate, $date){
        $sql = "UPDATE `daily_exchange` SET `sell_rate`='$sell_rate',`buy_rate`='$buy_rate',`date`='$date' WHERE `id`='$id'";
        return $mysqli->query($sql);
    }