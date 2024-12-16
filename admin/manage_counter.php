<?php require_once '../layout/header.php' ?>
<?php //require_once '../layout/nav.php' ?>
<?php //require_once '../layout/sidebar.php' ?>

<?php

  $sellName = $sellNameErr = "" ;
  $counterName = $counterNameErr = "";
  $FormErr = "";
  $invalid = false;

  if(isset($_GET['id'])){
    $currency_counters = get_currency_counter_with_id($mysqli, $_GET['id']);
    $currency_counter = $currency_counters->fetch_assoc();
    $id = $currency_counter['id'];
    $counterName = $currency_counter['counter_name'];
    $sellName = $currency_counter['currency_name'];
  }

  if(isset($_POST['submit'])){
    $counterName = $_POST['counterName'];
    $sellName = $_POST['sell_name'];
    $counterValidates = get_counter_id($mysqli, $counterName);
    $sellNamevalidates = get_currency_with_id($mysqli,$sellName);

    // $currency_id_with_query = get_currency_id_with_counter_id($mysqli, $counterName);
    // var_dump($counterName);
    // var_dump($currency_id_with_query['currency_id'],  $sellName);
    // if($currency_id_with_query['currency_id'] == $sellName){
    //     $sellNameErr = "This currency exchange is  already exists!";
    //     $invalid = true;
    // }
    
    if($counterName == ""){
        $counterNameErr = "Choose one";
        $invalid = true;
    }
    if($sellName == ""){
        $sellNameErr = "Choose one";
        $invalid = true;
    }
   

    if($counterValidates == ""){
        $counterNameErr = "Choose available counter";
        $invalid = true;
    }

    if($sellNamevalidates == ""){
        $sellNameErr = "Choose available currency";
        $invalid = true;
    }

    if(!$invalid){
        if (isset($_GET['id'])) {
            edit_currency_counter($mysqli, $id, $counterName, $sellName);
            echo "<script>location.replace('./counter_detail_list.php?add_success=Edit Successfully')</script>";
        } else {
            add_currency_counter($mysqli, $counterName, $sellName);
            //echo "<script>location.replace('./counter_detail_list.php?add_success=Edit Successfully')</script>";
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
            <p class="text-danger card" style="font-size:16px; font-weight:800;"><?= $FormErr ?></p>
                    <form method="post" class="mt-3">
                        <div class="input mx-auto">
                            <div class="form-group mb-4"> 
                                 <label for="exampleDataList" class="form-label">Choose Counter</label>
                                <select id="datalistOptions" class="form-control" name="counterName" value="<?php echo $counterName ?>">
                                <?php
                                    if($_GET['id']){ ?>

                                    <option value="<?=$currency_counter['id_for_counter']?>"><?=$currency_counter['counter_name']?></option>
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
                                <label for="exampleDataList" class="form-label">Sell Currency Name</label>
                                <select id="datalistOptions" class="form-control" name="sell_name" value="<?= $sellName ?>">
                                <?php
                                    if($_GET['id']){ ?>
                                    <option value="<?=$currency_counter['id_for_currency']?>"><?=$currency_counter['currency_name']?></option>
                                <?php } ?>
                                <?php  
                                    $currencies = get_all_currency(mysqli: $mysqli);
                                    while ($currency = $currencies->fetch_assoc()) { ?>
                                    <option value="<?=$currency['id']?>"><?=$currency['currency_name']?></option>
                                <?php } ?>
                                </select> 
                                <small class="text-danger"><?= $sellNameErr ?></small>
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