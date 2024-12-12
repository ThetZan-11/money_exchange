<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
    $currencyName       = $currencyNameErr = "";
    $sellCurrencyName   = $sellCurrencyNameErr ="";
    $sellCurrencyCode   = $sellCurrencyCodeErr ="";
    $buyCurrencyName    = $buyCurrencyNameErr ="";
    $buyCurrencyCode    = $buyCurrencyCodeErr ="";
    $invalid = false;

    if(isset($_GET['id'])){
        $currency           = get_currency_with_id($mysqli,$_GET['id']);
        $id                 = $_GET['id'];
        $currencyName       = $currency['currency_name'];
        $sellCurrencyName   = $currency['sell_currency_name'];
        $sellCurrencyCode   = $currency['sell_currency_code'];
        $buyCurrencyName    = $currency['buy_currency_name'];
        $buyCurrencyCode    = $currency['buy_currency_code'];
    }

    if(isset($_POST['submit'])){
        $currencyName     = $mysqli->real_escape_string(trim($_POST['currencyName']));
        $sellCurrencyName = $mysqli->real_escape_string(trim($_POST['sellCurrencyName']));
        $sellCurrencyCode = $mysqli->real_escape_string(trim(strtoupper($_POST['sellCurrencyCode'])));
        $buyCurrencyName  = $mysqli->real_escape_string(trim($_POST['buyCurrencyName']));
        $buyCurrencyCode  = $mysqli->real_escape_string(trim(strtoupper($_POST['buyCurrencyCode'])));

        if($currencyName == ""){
            $currencyNameErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($currencyName)) {
            $currencyNameErr = "Can't be number";
            $invalid = true;
        }
        if($sellCurrencyName == ""){
            $sellCurrencyNameErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($sellCurrencyName)) {
            $sellCurrencyNameErr = "Can't be number";
            $invalid = true;
        }
        if($sellCurrencyCode == ""){
            $sellCurrencyCodeErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($sellCurrencyCode)) {
            $sellCurrencyCodeErr = "Can't be number";
            $invalid = true;
        }
        if($buyCurrencyName == ""){
            $buyCurrencyNameErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($buyCurrencyName)) {
            $buyCurrencyNameErr = "Can't be number";
            $invalid = true;
        }
        if($buyCurrencyCode == ""){
            $buyCurrencyCodeErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($buyCurrencyCode)) {
            $buyCurrencyCodeErr = "Can't be number";
            $invalid = true;
        }

        if(!$invalid){
            if(isset($_GET['id'])){
                update_currency($mysqli, $id ,$currencyName,$sellCurrencyName,$sellCurrencyCode,$buyCurrencyName,$buyCurrencyCode);
                echo "<script>location.replace('../admin/currency_list.php?edit_success=Edited Successfully')</script>";
            } else {
                add_currency($mysqli,$currencyName,$sellCurrencyName,$sellCurrencyCode,$buyCurrencyName,$buyCurrencyCode);
                echo "<script>location.replace('../admin/currency_list.php?add_success=Added Successfully')</script>";
            }
            
        }
    }
?>

<main id="main" class="main">
    <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">
            <div class="card-title  mx-auto">
                <?php
                if (isset($_GET['id'])) { ?>
                    <h3>Edit Currency</h3>

                <?php } else { ?>
                    <h3>Add Currency</h3>
                <?php } ?>
            </div>
            <div class="card-body mx-auto">
                 <form method="post">
                    <div class="input mx-auto">
                        <div class="forname mb-4">
                            <label for="name">Currency Name</label>
                            <input type="text" class="form-control" name="currencyName" placeholder="Enter Currency Name" style="width: 300px;; height:50px;" value="<?= $currencyName ?>">
                            <div class="invalid"><?= $currencyNameErr ?></div>
                        </div>
                        <div class="foremail mb-4">
                            <label for="name">Sell Currency Name</label>
                            <input type="text" class="form-control" name="sellCurrencyName" placeholder="Enter Location" style="width:300px;height:50px;" value="<?= $sellCurrencyName ?>">
                            <div class="invalid"><?= $sellCurrencyNameErr ?></div>
                        </div>
                        <div class="foremail mb-4">
                            <label for="name">Sell Currency Code</label>
                            <input type="text" class="form-control" name="sellCurrencyCode" placeholder="Enter Location" style="width:300px;height:50px;" value="<?= $sellCurrencyCode ?>">
                            <div class="invalid"><?= $sellCurrencyCodeErr ?></div>
                        </div>
                        <div class="foremail mb-4">
                            <label for="name">Buy Currency Name</label>
                            <input type="text" class="form-control" name="buyCurrencyName" placeholder="Enter Buy Currency Name" style="width:300px;height:50px;" value="<?= $buyCurrencyName ?>">
                            <div class="invalid"><?= $buyCurrencyNameErr ?></div>
                        </div>
                        <div class="foremail mb-4">
                            <label for="name">Buy Currency Code</label>
                            <input type="text" class="form-control" name="buyCurrencyCode" placeholder="Enter Buy Currency Code" style="width:300px;height:50px;" value="<?= $buyCurrencyCode ?>">
                            <div class="invalid"><?= $buyCurrencyCodeErr ?></div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>