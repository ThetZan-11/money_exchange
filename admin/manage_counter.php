<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php

  
  $counterName = $counterNameErr = "";
  $currencyPair = $currencyPairErr = "" ;
  $FormErr = "";
  $invalid = false;

  if(isset($_GET['id'])){
    $currency_pair_counter_id = select_currencypair_counter_with_id($mysqli, $_GET['id']);
    $id = $_GET['id'];
    $counterName = $currency_pair_counter_id['counter_name'];
    $currencyPair = $currency_pair_counter_id['pair_name'];
  }

  if(isset($_POST['submit'])){
    $counterName = $_POST['counterName'];
    $currencyPair = $_POST['currency_pair'];
    $currency_pair_counter =  count_currencypair_with_counter($mysqli, $counterName, $currencyPair);
    
    if($counterName == ""){
        $counterNameErr = "Choose one";
        $invalid = true;
    }
    if($currencyPair == ""){
        $currencyPairErr = "Choose one";
        $invalid = true;
    }
    if($currency_pair_counter['count']>=1){
        $counterNameErr = "These counter already have that currency";
        $invalid = true;
    }
    
    if(!$invalid){
        if (isset($_GET['id'])) {
            update_currency_pair_counter($mysqli, $id, $currencyPair, $counterName);
            echo "<script>location.replace('./counterDetail_list.php?edit_success=Edit Successfully')</script>";
        } else {
            add_currency_pair_counter($mysqli, $currencyPair, $counterName);
            echo "<script>location.replace('./counterDetail_list.php?add_success=Add Successfully')</script>";
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
                    <h3>Edit Counter Detail</h3>

                <?php } else { ?>
                    <h3>Manage Counter</h3>
                <?php } ?>
            </div>

            <div class="card-body mx-auto">
            <p class="text-danger" style="font-size:16px; font-weight:800;"><?= $FormErr ?></p>
                    <form method="post" class="mt-3">
                        <div class="input mx-auto">
                            <div class="form-group mb-4"> 
                                 <label for="exampleDataList" class="form-label">Choose Counter</label>
                                <select id="datalistOptions" class="form-control" name="counterName" value="<?= $counterName ?>">
                                <?php if (isset($_GET['id'])) { ?>
                                    <option value="<?=$currency_pair_counter_id['counter_id']?>"><?=$currency_pair_counter_id['counter_name']?></option>
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
                                <label for="exampleDataList" class="form-label">Currency Pair</label>
                                <select id="datalistOptions" class="form-control" name="currency_pair">
                                <?php if (isset($_GET['id'])) { ?>
                                    <option value="<?=$currency_pair_counter_id['currency_pair_id']?>"><?=$currency_pair_counter_id['pair_name']?></option>
                                <?php } else{ ?>
                                    <option value="">Select One Counter</option>
                                <?php } ?>
                                <?php  
                                    $currency_pairs = get_all_currency_pair($mysqli);
                                    while ($currencypair = $currency_pairs->fetch_assoc()) { ?>
                                    <option value="<?=$currencypair['pair_id']?>">
                                        <?= $currencypair['pair_name'] ?>
                                    </option>
                                <?php } ?>
                                </select> 
                                <small class="text-danger"><?= $currencyPairErr ?></small>
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
<?php require_once '../layout/footer.php' ?>