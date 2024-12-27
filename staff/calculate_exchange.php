<?php session_start()  ?>
<?php require_once('../layout/header.php') ?>
<?php //require_once('../layout/nav.php') ?>
<?php //require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>

<?php  
 $amount = $amountErr = "";
 $from   = $fromErr   = "";
 $to     = $toErr     =  "";
 $result = "";
 $invalid = false;
 
 $order_detail = [];

    if(isset($_POST['submit'])){
        $amount = $_POST['amount'];
        $from   = $_POST['from'];
        $to     = $_POST['to'];

        if($amount == ""){
            $amountErr = "can't be blank!";
            $invalid = true;           
        }
        if($from == ""){
            $fromErr = "can't be blank!";
            $invalid = true;           
        }
        if($to == ""){
            $toErr = "can't be blank!";
            $invalid = true;           
        }
        if(!is_numeric($amount)){
            $amountErr = "must be number";
            $invalid = true;  
        }

        if(!$invalid){
            $rate =  select_rates($mysqli, $from, $to);
            $change =  select_rates($mysqli, $to, $from);
            $result = $rate['buy_rate'] * $amount;
            array_push($order_detail, ['amount'=> $amount,'result'=>$result,'buy_currency_name'=> $rate['buy_currency_name'],'sell_currency_name'=> $rate['sell_currency_name']]);
            $_SESSION["order_detail"] = $order_detail;
            var_dump($_SESSION["order_detail"]);
        }
    }  
    $user = json_decode($_COOKIE['user'], true);
    $user_id = $user['id'];
    $counter_id = get_counter_id_with_user_id($mysqli, $user_id);
   
?>

<main id="main" class="main">
    <div class="card p-5 ">
        <h3>Currency Converter</h3>
       
        <form method="post">

            <div class="row mt-3" >
                <div class="form-group col-md-4" id="form-input">
                    <input type="text" class="form-control py-3" name="amount" id="floatingInput" placeholder="Enter currency name" value="1.0">
                    <label for="floatingInput">Amount</label>
                    <small class="text-danger"><?= $amountErr ?></small>
                </div>

               
                <div class="form-group col-md-4" id="form-input">
                <label for="exampleDataList" class="form-label ">From</label>
                    <input class="form-control py-3" list="datalistOptions" name="from" id="exampleDataList" placeholder="Type to search..."> 
                     <datalist id="datalistOptions">
                    <?php 
                     $counter_filter  = filter_currency_with_counter($mysqli, $counter_id['id']);   

                    while ($buy_name_code = $counter_filter->fetch_assoc()) { ?>
                            <option value="<?= $buy_name_code['buy_currency_code'] ?>" >
                            <span class="flag-icon flag-icon-us"></span>
                             <?= $buy_name_code['buy_currency_name'] ?>
                            </option>
                        <?php  } ?>
                    </datalist>
                </div>
                <div class="form-group col-md-4" id="form-input">
                <label for="exampleDataList" class="form-label ">To</label>
                    <input class="form-control py-3" list="datalistOptions2" name="to" id="exampleDataList" placeholder="Type to search...">
                    <datalist id="datalistOptions2">
                    <?php 
                    $counter_filter  = filter_currency_with_counter($mysqli, $counter_id['id']);   
                    // $get_all_currency = get_sell_name_code($mysqli);
                        
                    while ($sell_name_code = $counter_filter->fetch_assoc()) { ?>
                          <option class="flag-icon flag-icon-us" value="<?= $sell_name_code['sell_currency_code'] ?>"><?= $sell_name_code['sell_currency_name'] ?> </option>
                        <?php   } ?>
                    </datalist>
                </div>
            </div>
            <div class="row d-flex align-items-center ">
                <?php if(isset($rate)) { ?>
                     <div class="para col-md-6 mt-4">
                        <p class="para-mid"><?= number_format($amount) ?> <?= $rate['buy_currency_name'] ?> = </p>
                        <p class="para-large"><?php echo number_format($result); ?>  <?= $rate['sell_currency_name'] ?></p>
                        <p class="para-small">1 <?= $rate['buy_currency_code'] ?> = <?= $rate['buy_rate'] ?> <?= $rate['sell_currency_code'] ?></p>
                        <p class="para-small">1 <?= $rate['sell_currency_code'] ?> = <?= $change['buy_rate'] ?> <?= $rate['buy_currency_code'] ?></p>
                    </div>
                 <?php } else { ?>
                    <div class="para col-md-6 mt-4" style="height: 165px;"></div>
                <?php } ?>
               
                <div class="form-group mb-3 col-md-6">
                    <button type="submit" name="submit" class="btn_converter">
                        CONVERT
                    </button>
                    <?php if(isset($rate)){ ?>
                        <div class="mt-3">
                        <button name="trade" class="btn_converter">
                        Trade
                    </button>
                    </div>
                    <?php }
                        if(isset($_POST['trade'])){
                            echo "<script>location.replace('./trade.php')</script>";
                        }
                    ?>
                </div>
            </div>
        </form>
    </div>
    
</main>

<?php require_once '../layout/footer.php';
//get_exchange_rate($mysqli); ?>