<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/nav.php') ?>
<?php require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>
<?php  

    if(isset($_SESSION['order_detail'])){
        $trades = $_SESSION['order_detail'];
    } else {
        echo "<script>location.replace('./calculate_exchange.php')</script>";
    }

    $customer_email = $customer_emailErr = ""; 
    $counter_name = $counter_nameErr = "";  
    $invalid = false;

    if(isset($_POST['submit'])){
        $customer_email     = $_POST['customer'];
        $counter_name       = $_POST['counter_name'];
        $customer_id = get_customer_with_email($mysqli, $customer_email);

        if($customer_email == ""){
            $customer_emailErr = "can't be blank";
            $invalid = true;
        }
        if(!isset($customer_id['id'])){
            $invalid = true;
            echo "<script>location.replace('./add_customer.php')</script>";
        }
        

        if(!$invalid){
            add_trade($mysqli, $trades[0]['from_amount'], $trades[0]['to_amount'],
            $trades[0]['date'], $trades['0']['daily_exchange_id'],
            $customer_id['id'], $trades['0']['duty_id'], $trades['0']['currency_pair_counter_id']);
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
                <label class="label">From Amount</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= number_format($trades[0]['from_amount']) ?>" readonly> 
            </div>
            
            <div class="form-group mb-3">
                <label class="label">To Amount</label>
                <input type="text" class="form-control" name="converted_amount" value="<?= number_format($trades[0]['to_amount']) ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">From</label>
                <input type="text" class="form-control" value="<?= $trades[0]['buy_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">TO</label>
                <input type="text" class="form-control" value="<?= $trades[0]['sell_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label>Date</label>
                <select name="counter_name" class="form-control" readonly>
                    <option value=" <?= $trades[0]['date'] ?> "><?= $trades[0]['date'] ?></option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label class="label">Staff name</label>
                <input type="text" class="form-control" value="<?= $trades[0]['staff_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label>Counter Name</label>
                <select name="counter_name" class="form-control" readonly>
                    <option><?= $trades[0]['counter_name'] ?></option>
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