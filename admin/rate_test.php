<?php require_once '../layout/header.php'; 
    require_once ('../db/daily_exchange_crud.php');
    require_once ('../db/rate.php');
    get_exchange_rate($mysqli);
?>