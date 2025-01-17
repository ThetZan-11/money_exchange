<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
$buy_currency      = $buy_currencyErr = "";
$sell_currency     = $sell_currencyErr = "";
$invalid = false;

// if (isset($_GET['id'])) {
//     $duties         = get_duites_with_id($mysqli, $_GET['id']);
//     $duty           = $duties->fetch_assoc();
//     $counterName    = $duty['counter_id'];
// }

if (isset($_POST['submit'])) {
    $buy_currency      = $mysqli->real_escape_string($_POST['buy_currency']);
    $sell_currency     = $mysqli->real_escape_string($_POST['sell_currency']);

    if ($buy_currency == "") {
        $buy_currencyErr = "Can't be blank";
        $invalid = true;
    }
    if ($sell_currency == "") {
        $sell_currencyErr = "Can't be blank";
        $invalid = true;
    }

    if($buy_currency == $sell_currency){
        $buy_currencyErr = "can't be same";
        $sell_currencyErr = "can't be same";
        $invalid = true;
    }

    if(!$invalid){
        if(isset($_GET['id'])){
            echo "Hello";
        } else {
            add_currency_pair($mysqli, $buy_currency, $sell_currency);
            echo "<script>location.replace('../admin/currencyPair_list.php?add_success=Added Successfully')</script>";
        }
    }
}
?>

<main id="main" class="main">
    <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">
            <div class="card-title  mx-auto">
                <?php if (isset($_GET['id'])) { ?>
                    <h3>Edit Currency Pair</h3>
                <?php } else { ?>
                    <h3>Add Currency Pair</h3>
                <?php } ?>
            </div>
            <div class="card-body mx-auto">
                <form method="post">
                    <div class="input mx-auto">
                        <div class="form-group mb-4">
                            <label for="exampleDataList" class="form-label">Choose Buy Currency</label>
                                <select name="buy_currency" class="form-control">
                                     <?php $currencies = get_all_currency($mysqli);
                                     while ($currency = $currencies->fetch_assoc()) { ?> 
                                        <option value="<?= $currency['id'] ?>"><?= $currency['currency_code'] ?></option> 
                                    <?php }  ?>
                                     
                                </select>
                            <small class="text-danger"><?= $buy_currencyErr ?></small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleDataList" class="form-label">Choose Sell Currency</label>
                                <select name="sell_currency" class="form-control">
                                     <?php $currencies = get_all_currency($mysqli);
                                     while ($currency = $currencies->fetch_assoc()) { ?> 
                                        <option value="<?= $currency['id'] ?>"><?= $currency['currency_code'] ?></option> 
                                    <?php }  ?>
                                     
                                </select>
                            <small class="text-danger"><?= $sell_currencyErr ?></small>
                        </div>

                        <div>
                            <button class="btn btn-primary" name="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once('../layout/footer.php'); ?>