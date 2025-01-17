<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
$name = $nameErr = $nameWarn  = "";
$location = $locationErr = "";

$invalid = true;

if (isset($_GET['id'])) {
    $counters = get_counter_id($mysqli, $_GET['id']);
    $name = $counters['counter_name'];
    $location = $counters['location'];

    if($name != $_POST['name']){
        $nameWarn = "You can't change the counter";
        $invalid = false;
    }
}

if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
     
    if(!isset($_GET['id'])){
        $allcounters = get_counter($mysqli);
        while($counterNmae = $allcounters ->fetch_assoc()){
         if($counterNmae['counter_name'] == $name){
               $nameErr = "This counter is already exists!";
              $invalid = false;
         }
       }
    }

    if ($name == "") {  
        $nameErr = "Please enter counter";
        $invalid = false;
    } else if (!preg_match('/^Counter-\d{2}$/', $name)) {
        $nameErr = "Valid format eg - Counter-01";
        $invalid = false;
    }

    if ($location == "") {
        $locationErr = "Please enter location";
        $invalid = false;
    }

    if ($invalid) {
        if (isset($_GET['id'])) {
            update_counter($mysqli, $_GET['id'], $name, $location);
            echo "<script>location.replace('../admin/counter_list.php?edit_success=Edit Successfully')</script>";
        } else {
            add_counter($mysqli, $name, $location);
            echo "<script>location.replace('../admin/counter_list.php?edit_success=Edit Successfully')</script>";
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
                    <h3>Edit counter</h3>

                <?php } else { ?>
                    <h3>Add counter</h3>
                <?php } ?>
            </div>
            <div class="card-body mx-auto">
                 <form method="post">
                    <div class="input mx-auto">
                        <div class="forname mb-4">
                            <label for="name">Counter Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter counter name" style="width: 300px;; height:50px;" value="<?= $name ?>">
                            <div class="invalid"><?= $nameErr ?></div>
                            <div class="text-warning"><?= $nameWarn ?></div>
                        </div>
                        <div class="foremail mb-4">
                            <label for="name">Location</label>
                            <input type="text" class="form-control" name="location" placeholder="Enter Location" style="width:300px;height:50px;" value="<?= $location ?>">
                            <div class="invalid"><?= $locationErr ?></div>
                        </div>
                        <button type="submit" value="submit" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>