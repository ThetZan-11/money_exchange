<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/nav.php') ?>
<?php require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>

<?php  
 $amount = $amountErr = "";
 $from  = $fromErr = "";
 $to  = $toErr = "";
 $result = "";
 $invalid = false;

    if(isset($_POST['submit'])){
        $amount = $_POST['amount'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        if($amount == ""){
            $amountErr = "can't be blank!";
            $invalid = true;           
        } else if(!is_numeric($amount)){
            $amountErr = "must be number";
            $invalid = true;  
        }
        if($from == $to){
            $fromErr = "can't be same";
            $toErr = "can't be same";
            $invalid = true;
        }

        if(!$invalid){
            $rate = calculate_exchange($mysqli, $from, $to);
        }
    }
?>

<main id="main" class="main">
    <div class="card p-5">
        <h3>Currency Converter</h3>
        <form method="post">

            <div class="row mt-3">
                <div class="form-floating mb-3 col-md-4">
                      <input type="text" class="form-control" name="amount" id="floatingInput" placeholder="Enter Amount" value="<?= $amount ?>">
                      <label for="floatingInput">Amount</label>
                      <small class="text-danger"><?= $amountErr ?></small>
                </div>
                <div class="form-floating mb-3 col-md-4">
                      <select class="form-select" id="floatingSelect" name="from" aria-label="Floating label select example">
                        <?php
                        $currencies = get_all_currency($mysqli);
                            while ($currency = $currencies->fetch_assoc()) { 
                                if(isset($from) && $from==$currency['currency_code']){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                } ?>
                                <option value="<?= $currency['currency_code'] ?>"  <?= $selected ?>>
                                    <?= $currency['currency_name'] ?>
                                </option>
                        <?php  } ?>
                      </select>
                      <label for="floatingSelect">From</label>
                      <small class="text-danger"><?= $fromErr ?></small>
                </div>
                <div class="form-floating mb-3 col-md-4">
                      <select class="form-select" id="floatingSelect" name="to" aria-label="Floating label select example">
                      <?php
                      $currencies = get_all_currency($mysqli);
                            while ($currency = $currencies->fetch_assoc()) { 
                                if(isset($to) && $to==$currency['currency_code']){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }  ?>
                            <option value="<?= $currency['currency_code'] ?>"  <?= $selected ?>>
                                <?= $currency['currency_name'] ?>
                            </option>
                        <?php  } ?>
                       
                      </select>
                      <label for="floatingSelect">To</label>
                      <small class="text-danger"><?= $toErr ?></small>
                </div>
            </div>
            <div class="row d-flex align-items-center">
                <?php if(isset($rate)) { ?>
                     <div class="para col-md-6 mt-4">
                        <p class="para-mid"><?= number_format($amount) ?> <?= $rate['buy_currency_name'] ?> = <?php $result = $rate['buy_rate'] * $amount; echo number_format($result); ?>  <?= $rate['sell_currency_name'] ?></p>
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
                </div>
            </div>
        </form>
    </div>
</main>

<?php require_once '../layout/footer.php';