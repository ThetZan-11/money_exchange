<?php
function have_admin($mysqli)
{
    $sql = "SELECT COUNT(`id`) as `total` FROM `user` WHERE `role`=1";
    $total = $mysqli->query($sql);
    $total = $total->fetch_assoc();
    if ($total['total'] > 0) { 
        return false;
    }
    return true;
}

function save_user($mysqli, $name, $email, $password, $address, $ph_no, $role, $user_img)
{
    try {
        $sql = "INSERT INTO `user` (`name`,`email`,`password`,`address`,`ph_no`,`role`,`user_img`) VALUE ('$name','$email','$password','$address','$ph_no',$role,'$user_img')";
        return $mysqli->query($sql);
    } catch (\Throwable $th) {
        if ($th->getCode() === 1062) {
            return "This email is alerady have been used!";
        } else {
            return "Internal server error!";
        }
    }
}

function get_user_with_email($mysqli,$email){
    $sql = "SELECT * FROM `user` WHERE `email`='$email' AND `soft_delete` = 0";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_all_user($mysqli){
    $sql = "SELECT * FROM `user` WHERE `soft_delete` = 0";
    return $mysqli->query($sql);
}

function update_user($mysqli, $id,$name, $email, $address, $ph_no, $role, $user_img){
    $sql = "UPDATE `user` SET `name`='$name', `email`='$email', `address`='$address', `ph_no`='$ph_no', `role`='$role', `user_img`= '$user_img' WHERE `id`=$id";
    return $mysqli->query($sql);
}

function update_user_profile($mysqli, $id, $name, $email, $address, $phone, $user_img){
    $sql = "UPDATE `user` SET `name`='$name', `email`='$email', `address`='$address', `ph_no`='$phone', `user_img`= '$user_img' WHERE `id`=$id";
    return $mysqli->query($sql);
}   

function get_user_with_id($mysqli, $id){
    $sql = "SELECT * FROM `user` WHERE `id`=$id";
    return $mysqli->query($sql);
}

function get_email_of_user($mysqli){
    $sql = "SELECT `email` FROM `user` WHERE `soft_delete` = 0";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_staff($mysqli){
    $sql = "SELECT * FROM `user` WHERE `role`=2 AND `soft_delete` = 0";
    return $mysqli->query($sql);
}

function user_search ($mysqli , $key) 
{
$sql = "SELECT * FROM `user` WHERE `name` LIKE '%$key%' AND `soft_delete` = 0 OR `email` LIKE '%$key%' AND `soft_delete` = 0 OR `address` LIKE '%$key%' AND `soft_delete` = 0 OR  `ph_no` LIKE '%$key%'";
return $mysqli->query($sql);
}

function user_softdelete ($mysqli , $id)
{
    $sql = "UPDATE  `user` SET `soft_delete` = 1 WHERE `id` = $id";
    return $mysqli->query($sql);
}

function user_sd ($mysqli)
{
 $sql = "SELECT * FROM `user` WHERE `soft_delete` = 0";
 return $mysqli->query($sql);

}

function duty_with_date($mysqli, $user_id){
    $sql = "SELECT `counter`.`id` AS `counter_id`,`duty`.`id` AS `duty_id`,`duty`.`from_date`,`duty`.`to_date`,`counter`.`counter_name`,`user`.`name` FROM `duty` 
    INNER JOIN `user` ON `user`.`id` = `duty`.`user_id` 
    INNER JOIN counter ON `counter`.`id` = `duty`.`counter_id` WHERE `user`.`id` = '$user_id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

