<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
$counterName       = $counterNameErr = "";
$userName          = $userNameErr = "";
$from_date         = $from_dateErr = "";
$to_date           = $to_dateErr = "";
$invalid = false;

if (isset($_GET['id'])) {
    $duties         = get_duites_with_id($mysqli, $_GET['id']);
    $duty           = $duties->fetch_assoc();
    $counterName    = $duty['counter_id'];
    $userName       = $duty['user_id'];
    $from_date      = $duty['from_date'];
    $to_date        = $duty['to_date'];
}

if (isset($_POST['submit'])) {
    $counterName      = $mysqli->real_escape_string(trim($_POST['counterName']));
    $userName         = $mysqli->real_escape_string(trim($_POST['userName']));
    $from_date        = $mysqli->real_escape_string(trim($_POST['from_date']));
    $to_date          = $mysqli->real_escape_string(trim(string: $_POST['to_date']));
    $dateFormat       = 'Y-m-d';
    $from_date_format = DateTime::createFromFormat($dateFormat, $from_date);
    $to_date_format   = DateTime::createFromFormat($dateFormat, $to_date);
    $date_now         = date("Y-m-d");

    if ($counterName == "") {
        $counterNameErr = "Can't be blank";
        $invalid = true;
    }
    if ($userName == "") {
        $userNameErr = "Can't be blank";
        $invalid = true;
    }
    if ($from_date == "") {
        $from_dateErr = "Can't be blank";
        $invalid = true;
    }
    if ($to_date == "") {
        $to_dateErr = "Can't be blank";
        $invalid = true;
    }
    if (!$from_date_format) {
        $from_dateErr = "date format is year-month-date";
        $invalid      = true;
    }
    if (!$to_date_format) {
        $to_dateErr = "date format is year-month-date";
        $invalid      = true;
    }
    if ($to_date <= $from_date) {
        $from_dateErr = "From date must be smaller than To date";
        $to_dateErr   = "From date must be smaller than To date";
        $invalid = true;
    }
    if ($from_date < $date_now) {
        $from_dateErr = "Invalid Date";
        $invalid      =  true;
    }
    if ($to_date < $date_now) {
        $to_dateErr = "Invalid Date";
        $invalid      =  true;
    }

    if(duty_validate_with_date($mysqli, $counterName, $userName, $from_date)){
        $from_dateErr = "Duty taken by other staff in this period";
        $invalid      =  true;
    }

    if(duty_validate_with_date($mysqli, $counterName, $userName, $to_date)){
        $to_dateErr = "Duty taken by other staff in this period";
        $invalid      =  true;
    }

    $duty_validate_from = duty_validate_date_counter($mysqli, $from_date, $userName);
    if($duty_validate_from['count'] > '1' ){
        $counterNameErr = "Assign conflit";
        $invalid = true;
    }

    $duty_validate_to = duty_validate_date_counter($mysqli, $to_date, $userName);
    if($duty_validate_to['count'] > '1' ){
        $userNameErr = "Assign conflit";
        $invalid = true;
    }

$duty_validates_counter_from = duty_validate_counter_id($mysqli, $from_date, $userName, $counterName);
$duty_validates_counter_to = duty_validate_counter_id($mysqli, $to_date, $userName, $counterName);
    while($duty_validate = $duty_validates_counter_from->fetch_assoc()){
        if($counterName = $duty_validate['counter_id']){
            $invalid = true;
            $counterNameErr = "Assign conflit";
        }
    }

    while($duty_validate = $duty_validates_counter_to->fetch_assoc()){
        if($counterName = $duty_validate['counter_id']){
            $invalid = true;
            $userNameErr = "Assign conflit";
        }
    }

    if (!$invalid) {
        if (isset($_GET['id'])) {
            update_duty($mysqli, $_GET['id'], $counterName, $userName, $from_date, $to_date);
            echo "<script>location.replace('../admin/duty_list.php?edit_success=Added Successfully')</script>";
        } else {
            add_duty($mysqli, $userName, $counterName, $from_date, $to_date);
            echo "<script>location.replace('../admin/duty_list.php?add_success=Added Successfully')</script>";
        }   
    }
}
?>

<main id="main" class="main">
    <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">
            <div class="card-title  mx-auto">
                <?php if (isset($_GET['id'])) { ?>
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
                            <!-- <input class="form-control" list="datalistOptions" placeholder="Search Counter...." name="counterName"> -->
                            <select id="datalistOptions" class="form-control" name="counterName" value="<?= $counterName ?>">
                                <?php
                                $counters = get_counter($mysqli);
                                while ($counter = $counters->fetch_assoc()) { ?>
                                    <option value="<?= $counter['id'] ?>"><?= $counter['counter_name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="text-danger"><?= $counterNameErr ?></small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleDataList" class="form-label">Choose Staff</label>
                            <select name="userName" class="form-control" value="<?= $userName ?>">
                                <?php
                                $staffs = get_staff($mysqli);
                                while ($staff = $staffs->fetch_assoc()) { ?>
                                    <option value="<?= $staff['id'] ?>"><?= $staff['name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="text-danger"><?= $userNameErr ?></small>
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
<?php require_once('../layout/footer.php'); ?>