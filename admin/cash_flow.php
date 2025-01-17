<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
    $counterName = $counterNameErr = "";
    $currencyName = $currencyNameErr = "";
    $total = $totalErr = "";
    $invalid = false;

    if (isset($_GET['id'])) {
        $cash_flow_with_id = cash_flow_with_id($mysqli, $_GET['id']);
        $id = $_GET['id'];
        $counterName = $cash_flow_with_id['counter_name'];
        $currencyName = $cash_flow_with_id['currency_name'];
        $total  = $cash_flow_with_id['total'];
    }

    if (isset($_POST['counter_name'])) {
        $counterName    = $_POST['counter_name'];
        $currencyName   = $_POST['currency_name'];
        $total          = trim($_POST['total']);
        $total_from_currency = get_currency_with_id($mysqli, $currencyName);    

        if($counterName == ""){
            $counterNameErr = "Can't be blank";
            $invalid = true;
        } 
        if($currencyName == ""){
            $currencyNameErr = "Can't be blank";
            $invalid = true;
        } else if ($total_from_currency['total'] < $total) {
            $totalErr = "Last Amount ".$total_from_currency['total']." ".$total_from_currency['currency_code'];
            $invalid = true;
        }
        if($total == ""){
            $totalErr = "can't be blank";
            $invalid = true;
        }
        if(!is_numeric($total)){
            $totalErr = "must be number";
            $invalid = true;
        }

        if(currency_with_counter($mysqli, $currencyName, $counterName)){
            $currencyNameErr = "Can't add same currency for same counter";
            $invalid = true;
        }

        if(!$invalid){
            if(isset($_GET['id'])){
                update_currency_total_for_update($mysqli, $total_from_currency['total'], $cash_flow_with_id['total'], $total, $currencyName);
                update_cash_flow($mysqli, $id, $counterName, $currencyName, $total);
                echo "<script>location.replace('./cashflow_list.php?edit_success=Edit Successfully')</script>";
            } else {
                update_currency_total_for_insert($mysqli, $total,$currencyName);
                save_cash_flow($mysqli, $counterName, $currencyName, $total);
                echo "<script>location.replace('./cashflow_list.php?add_success=Add Successfully')</script>";
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
                    <h3>Edit Cash Flow</h3>

                <?php } else { ?>
                    <h3>Add Cash Flow</h3>
                <?php } ?>
            </div>
            <div class="card-body mx-auto">
                 <form method="post">
                    <div class="input mx-auto">
                        <div class="form-group mb-4"> 
                            <label for="exampleDataList" class="form-label">Choose Counter</label>
                            <select id="datalistOptions" class="form-control" name="counter_name">
                                <?php if (isset($_GET['id'])) { ?>
                                    <option value="<?=$cash_flow_with_id['counter_id']?>"><?=$cash_flow_with_id['counter_name']?></option>
                                <?php } else{ ?>
                                    <option value="">Select One Counter</option>
                                <?php } ?>
                                <?php 
                                    $counters = get_counter($mysqli);
                                    while ($counter = $counters->fetch_assoc()) { ?>
                                    <option value="<?=$counter['id']?>"><?=$counter['counter_name']?></option>
                                <?php } ?>
                            </select> 
                            <small class="text-danger"><?= $counterNameErr ?></small>
                        </div>
                        <div class="form-group mb-4"> 
                            <label for="exampleDataList" class="form-label">Choose Currency</label>
                            <select id="datalistOptions" class="form-control" name="currency_name">
                                <?php if (isset($_GET['id'])) { ?>
                                    <option value="<?=$cash_flow_with_id['currency_id']?>"><?=$cash_flow_with_id['currency_name']?></option>
                                <?php } else{ ?>
                                    <option value="">Select One Currency</option>
                                <?php } ?>
                                <?php 
                                    $currencies = currency_sd($mysqli);
                                    while ($currency = $currencies->fetch_assoc()) { ?>
                                    <option value="<?=$currency['id']?>"><?=$currency['currency_name']?></option>
                                <?php } ?>
                            </select> 
                            <small class="text-danger"><?= $currencyNameErr ?></small>
                        </div>
                        <div class="form-group mb-4"> 
                            <label for="exampleDataList" class="form-label">Total</label>
                           <input type="text" class="form-control" name="total" value="<?= $total ?>" placeholder="Enter Amount">
                            <small class="text-danger"><?= $totalErr ?></small>
                        </div>
                        <button type="submit" value="submit" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>