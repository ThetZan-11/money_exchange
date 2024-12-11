<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
    $counterName       = $counterNameErr = "";
    $userName          = $userNameErr ="";
    $from_date         = $from_dateErr ="";
    $to_date           = $to_dateErr ="";
    $invalid = false;

    if(isset($_POST['submit'])){
        $counterName      = $mysqli->real_escape_string(trim($_POST['counterName']));
        $userName         = $mysqli->real_escape_string(trim($_POST['userName']));
        $from_date        = $mysqli->real_escape_string(trim(strtoupper($_POST['from_date'])));
        $to_date          = $mysqli->real_escape_string(trim($_POST['to_date']));

        if($counterName == ""){
            $counterNameErr = "Can't be blank";
            $invalid = true;
        }
        if($userName == ""){
            $userNameErr = "Can't be blank";
            $invalid = true;
        }
        if($from_date == ""){
            $from_dateErr = "Can't be blank";
            $invalid = true;
        }
        if($to_date == ""){
            $to_dateErr = "Can't be blank";
            $invalid = true;
        }
        if($to_date < $from_date){
            $from_dateErr = "From date must be smaller than To date";
            $to_dateErr   = "From date must be smaller than To date";
            $invalid = true;
        }


        if(!$invalid){
            
        }
    }
?>

<main id="main" class="main">
    <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">
            <div class="card-title  mx-auto">
                <?php
                if (isset($_GET['id'])) { ?>
                    <h3>Edit Duty</h3>

                <?php } else { ?>
                    <h3>Add Duty</h3>
                <?php } ?>
            </div>

            <div class="card-body mx-auto">
                    <form method="post">
                        <div class="input mx-auto">
                            <div class="form-group mb-4"> 
                                 <label for="exampleDataList" class="form-label">Choose Counter</label>
                                <input class="form-control" list="datalistOptions" placeholder="Search Counter...." name="counterName">
                                <datalist id="datalistOptions">
                                    <option value="San Francisco">
                                </datalist>
                            </div>

                            <div class="form-group mb-4"> 
                                 <label for="exampleDataList" class="form-label">Choose Staff</label>
                                 <input class="form-control" list="datalistOptions" placeholder="Search Counter...." name="userName">
                                <datalist id="datalistOptions">
                                    <option value="San Francisco">
                                </datalist>
                            </div>

                            <div class="form-group mb-4">
                                <label for="" class="form-label">From Date</label>
                                <input type="date" class="form-control" name="from_date">
                                <small class="text-danger"><?= $from_dateErr ?></small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="" class="form-label">To Date</label>
                                <input type="date" class="form-control" name="to_date">
                                <small class="text-danger"><?= $to_dateErr ?></small>
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