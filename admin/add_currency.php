<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
    $currencyName = $currencyNameErr = "";
    $currencyCode = $currencyCodeErr = "";
    $total = $totalErr = "";
    $flag = $flagErr = "" ; 
    $invalid = false;

    if(isset($_GET['id'])){
        $currency           = get_currency_with_id($mysqli,$_GET['id']);
        $id                 = $_GET['id'];
        $currencyName       = $currency['currency_name'];
        $currencyCode   = $currency['currency_code'];
        $total   = $currency['total'];
        $oldImage    = $currency['flag'];
    }

    if(isset($_POST['submit'])){
        $currencyName = $mysqli->real_escape_string(trim($_POST['currencyName']));
        $currencyCode = $mysqli->real_escape_string(trim(strtoupper($_POST['currencyCode'])));
        $total = $mysqli->real_escape_string(trim($_POST['total']));
        $flag = $_FILES['flag_img'];
        
        if($currencyName == ""){
            $currencyNameErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($currencyName)) {
            $currencyNameErr = "Can't be number";
            $invalid = true;
        }
        if($currencyCode == ""){
            $currencyCodeErr = "Can't be blank";
            $invalid = true;
        }
        if (is_numeric($currencyCode)) {
            $currencyCodeErr = "Can't be number";
            $invalid = true;
        }
        if($total == ""){
            $totalErr = "Can't be blank";
            $invalid = true;
        }
        if (!is_numeric($total)) {
            $totalErr = "Can't be number";
            $invalid = true;
        }


        if(!$invalid){
          if(isset($_GET['id'])){
            if($flag['name']==""){
                update_currency($mysqli, $id, $currencyName, $currencyCode, $total, $oldImage);
                echo "<script>location.replace('./currency_list.php?add_success=Edit Successfully')</script>";
              } else {
                $filePath = "../assets/img/".$oldImage;
                unlink($filePath);
                $tmp = $flag['tmp_name'];
                $flag_profile = date("YMDHS") . $flag['name'];
                update_currency($mysqli, $id, $currencyName, $currencyCode, $total, $flag_profile);
                move_uploaded_file($tmp, '../assets/flag/' . $flag_profile);
                echo "<script>location.replace('./currency_list.php?id=$id')</script>";
            }
          } else {
                $flag_profile = date('DMYHS').$flag['name'];
                $flag_tmp = $flag['tmp_name'];
                add_currency($mysqli, $currencyName, $currencyCode, $total, $flag_profile);
                move_uploaded_file($flag_tmp, '../assets/flag/'.$flag_profile);
                echo "<script>location.replace('./currency_list.php')</script>";
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
                 <form method="post" enctype="multipart/form-data">
                    <div class="input mx-auto">
                        <div class="form-group mb-3">
                            <label for="name">Currency Name</label>
                            <input type="text" class="form-control" name="currencyName" placeholder="Enter Currency Name" style="width: 300px;; height:50px;" value="<?= $currencyName ?>">
                            <div class="invalid"><?= $currencyNameErr ?></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Currency Code</label>
                            <input type="text" class="form-control" name="currencyCode" placeholder="Enter Currency Name" style="width: 300px;; height:50px;" value="<?= $currencyCode ?>">
                            <div class="invalid"><?= $currencyCodeErr ?></div>
                        </div>
                       
                        <div class="form-group mb-3">
                            <label for="name">Total</label>
                            <input type="text" class="form-control" name="total" placeholder="Enter Total" style="width:300px;height:50px;" value="<?= $total ?>">
                            <div class="invalid"><?= $totalErr ?></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Flag</label>
                            <input type="file" name="flag_img" class="form-control">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>