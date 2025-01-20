<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/nav.php') ?>
<?php require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>

<?php  
$date =  $_SESSION['date'];
 $amount = $amountErr = "";
 $currency_pair_id  = $currency_pair_idErr = "";
 $result = "";
 $invalid = false;
 $order_detail = [];
 $status = false;
 $selected = "";

    if(isset($_POST['submit'])){
        $amount = $_POST['amount'];
        $currency_pair_id = $_POST['currency_pair_id'];
        $date_for_trade = date('Y-m-d');
        
        if($amount == ""){
            $amountErr = "can't be blank!";
            $invalid = true;           
        } else if(!is_numeric($amount)){
            $amountErr = "must be number";
            $invalid = true;  
        }

        if(!$invalid){
               
                $rate = calculate_exchange_for_staff($mysqli, $currency_pair_id, $date_for_trade);
                $result = ceil($rate['buy_rate'] * $amount);
                $duty = $_SESSION['date'];
                
    
                $sell_amount_check = check_cashflow_from_counter($mysqli, $rate['sell_currency_id'], $duty['counter_id']);
                var_dump($sell_amount_check['total']);
                if($result >= $sell_amount_check['total']){
                    $status = true;
                    $invalid = true;
                    $amountErr = "Amount isn't Enough in ".$duty['counter_name'];
                }

            if(!$status){
                array_push($order_detail, ['from_amount'=>$amount, 'to_amount'=>$result,
                'buy_currency_name'=>$rate['buy_currency_name'], 'sell_currency_name'=>$rate['sell_currency_name'],
                'currency_pair_counter_id'=>$rate['currency_pair_counter_id'], 'daily_exchange_id'=>$rate['daily_exchange_id'],
                'date'=>$date_for_trade,'duty_id'=>$duty['duty_id'], 'staff_name'=>$duty['name'], 'counter_name'=>$duty['counter_name']]);
                $_SESSION["order_detail"] = $order_detail;
                update_buy_currency_cash($mysqli, $rate['buy_currency_id'], $duty['counter_id'], $amount);
                update_sell_currency_cash($mysqli, $rate['sell_currency_id'], $duty['counter_id'], $result);
            }
        }
    }   

    if(isset($_POST['trade'])){
        echo "<script>location.replace('./trade_cal.php')</script>";
    }
?>

<main id="main" class="main">
    <div class="card p-5 ">
        <h3>Currency Converter</h3>
        <form method="post">

            <div class="row mt-3" >
            <div class="row mt-3">
                <div class="form-floating mb-3 col-md-5">
                      <input type="text" class="form-control" name="amount" placeholder="amount" id="floatingInput" value="<?= $amount ?>">
                      <label for="floatingInput"> Amount</label>
                      <small class="text-danger"><?= $amountErr ?></small>
                </div>
                <div class="form-floating mb-3 col-md-5">
                      <select class="form-select" id="floatingSelect" name="currency_pair_id" aria-label="Floating label select example">
                        <?php
                        $currencies = select_currency_for_counter($mysqli, $date['from_date'], $date['to_date'], $user['id']);
                            while ($currency = $currencies->fetch_assoc()) { 
                                if(isset($currency_pair_id) && $currency_pair_id==$currency['currency_pair_id']){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                ?>
                                <option value="<?= $currency['currency_pair_id'] ?>" <?= $selected ?> ><?= $currency['pair_name']?></option>
                        <?php  } ?>
                      </select>
                      <label for="floatingSelect">Currency</label>
                      <small class="text-danger"><?= $currency_pair_idErr ?></small>
                </div>
            </div>
            </div>
            <div class="row d-flex align-items-center ">
                <?php if(isset($rate)) { ?>
                     <div class="para col-md-6 mt-4">
                        <p class="para-mid"><?= number_format($amount) ?> <?= $rate['buy_currency_name'] ?> = <?php echo number_format($result); ?>  <?= $rate['sell_currency_name'] ?></p>
                        <p class="para-small">1 <img src="../assets/flag/<?= $rate['buy_flag'] ?>" width="25px" height="25px"> = <?= $rate['buy_rate'] ?> <img src="../assets/flag/<?= $rate['sell_flag'] ?>" width="25px" height="25px"></p>
                        <p class="para-small">1 <img src="../assets/flag/<?= $rate['sell_flag'] ?>" width="25px" height="25px"> = <?= $rate['buy_rate'] ?> <img src="../assets/flag/<?= $rate['buy_flag'] ?>" width="25px" height="25px"></p>
                    </div>
                 <?php } else { ?>
                    <div class="para col-md-6 mt-4" style="height: 165px;"></div>
                <?php } ?>

                <div class="form-group mb-3 col-md-6">
                    <button type="submit" name="submit" class="btn_converter">
                        CONVERT
                    </button>
                    <?php if(isset($rate) && $status == false){ ?>
                        <div class="mt-3">
                        <button name="trade" class="btn_converter">
                        Trade
                    </button>
                    </div>
                    <?php }   ?>
                        
                   
                </div>
            </div>
        </form>
    </div>
</main>

<?php require_once '../layout/footer.php';