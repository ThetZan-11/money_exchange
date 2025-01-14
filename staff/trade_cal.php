<?php require_once('../layout/header.php') ?>
<?php //require_once('../layout/nav.php') ?>
<?php //require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>
<?php  

    if(isset($_SESSION['order_detail'])){
        $trades = $_SESSION['order_detail'];
    } else {
        echo "<script>location.replace('./calculate_exchange.php')</script>";
    }

    var_dump($trades);

    $exchange_amount = $exchange_amountErr = "";
    $converted_amount = $converted_amountErr = "";
    $from = $fromErr = "";
    $to = $toErr =  ""; 
    $customer_email = $customer_emailErr = ""; 
    $counter_name = $counter_nameErr = "";  
    $invalid = false;

    if(isset($_POST['submit'])){
        $exchange_amount    = $_POST['exchange_amount']; 
        $converted_amount   = $_POST['converted_amount'];
        $from               = $_POST['from'];
        $to                 = $_POST['to'];  
        $date_now           = date('Y-m-d'); 
        $customer_email     = $_POST['customer'];
        $counter_name       = $_POST['counter_name'];
        $customer_id = get_customer_with_email($mysqli, $customer_email);

        if($exchange_amount == ""){
            $exchange_amountErr = "can't be blank!";
            $invalid = true;           
        } 
        if($converted_amount == ""){
            $converted_amountErr = "can't be blank!";
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
        if($counter_name == ""){
            $counter_nameErr = "can't be blank";
            $invalid = true;
        }

        if(!$invalid){
            add_trade($mysqli, $trades[0]['amount'], $trades[0]['result'], $date_now, $counter_name,$customer_id['id']);
            echo "<script>location.replace('./saleRecord_list.php')</script>";
            unset($_SESSION['order_detail']);
        }
    }
?>

<main id="main" class="main">
    <div class="container mx-auto">
    <h3>Trade</h3>
        <form method="post" class="mt-3">
            
            <div class="form-group mb-3">
                <label class="label">Customer</label>
                <input type="text" list="customer" class="form-control" name="customer" placeholder="Select Customer email">
                <datalist id="customer">
                    <?php $customers = get_customer($mysqli);
                    while ($customer = $customers->fetch_assoc()) { ?>
                        <option value="<?= $customer['email'] ?>"><?= $customer['name'] ?></option>    
                    <?php } ?>
                </datalist>
                <small class="text-danger"><?= $customer_emailErr ?></small>
            </div>
            
            <div class="form-group mb-3">
                <label class="label">Exchange Amount</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= number_format($trades[0]['amount']) ?>" readonly> 
            </div>
            
            <div class="form-group mb-3">
                <label class="label">Converted Amount</label>
                <input type="text" class="form-control" name="converted_amount" value="<?= number_format($trades[0]['result']) ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">From</label>
                <input type="text" class="form-control" name="from" value="<?= $trades[0]['buy_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">TO</label>
                <input type="text" class="form-control" name="to" value="<?= $trades[0]['sell_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label>Counter</label>
                <select name="counter_name" class="form-control" readonly>
                    <option value="<?= $trades[0]['currency_counter_id'] ?>" >  <?= $trades[0]['counter_name'] ?> </option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" name="submit">
                    Save Order
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once('../layout/footer.php') ?>