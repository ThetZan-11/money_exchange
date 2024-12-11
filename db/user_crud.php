<?php
function have_admin($mysqli)
{
    $sql = "SELECT COUNT(`id`) as total FROM `user` WHERE `role`=1";
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
    $sql = "SELECT * FROM `user` WHERE `email`='$email'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_all_user($mysqli){
    $sql = "SELECT * FROM `user`";
    return $mysqli->query($sql);
}

function update_user($mysqli, $id,$name, $email, $address, $ph_no, $role, $user_img){
    $sql = "UPDATE `user` SET `name`='$name', `email`='$email', `address`='$address', `ph_no`='$ph_no', `role`='$role', `user_img`= '$user_img' WHERE `id`=$id";
    return $mysqli->query($sql);
}

function get_user_with_id($mysqli, $id){
    $sql = "SELECT * FROM `user` WHERE `id`=$id";
    return $mysqli->query($sql);
}

function get_email_of_user($mysqli){
    $sql = "SELECT `email` FROM `user`";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


