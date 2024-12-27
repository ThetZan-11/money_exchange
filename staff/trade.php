<?php session_start()  ?>
<?php require_once('../layout/header.php') ?>
<?php //require_once('../layout/nav.php') ?>
<?php //require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>
<?php  
    if(isset($_SESSION['order_detail'])){
        $trades = $_SESSION['order_detail'];
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
            </div>
            
            <div class="form-group mb-3">
                <label class="label">Exchange Amount</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= number_format($trades[0]['amount']) ?>" readonly> 
            </div>
            
            <div class="form-group mb-3">
                <label class="label">Converted Amount</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= number_format($trades[0]['result']) ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">From</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= $trades[0]['buy_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group mb-3">
                <label class="label">TO</label>
                <input type="text" class="form-control" name="exchange_amount" value="<?= $trades[0]['sell_currency_name'] ?>" readonly> 
            </div>

            <div class="form-group">
                <button class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once('../layout/footer.php') ?>