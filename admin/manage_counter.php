<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
   
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
                    <form method="post">
                        <div class="input mx-auto">
                            <div class="form-group mb-4"> 
                                 <label for="exampleDataList" class="form-label">Choose Counter</label>
                                <select id="datalistOptions" class="form-control" name="counterName" value="<?= $counterName ?>">
                                <?php  
                                    $counters = get_counter($mysqli);
                                    while ($counter = $counters->fetch_assoc()) { ?>
                                    <option value="<?=$counter['id']?>"><?=$counter['counter_name']?></option>
                                <?php } ?>
                                </select> 
                            </div>

                            <div class="form-group mb-4"> 
                                <label for="exampleDataList" class="form-label">Available Currency</label>
                                <select id="datalistOptions" class="form-control" name="counterName" value="<?= $counterName ?>">
                                <?php  
                                    $counters = get_counter($mysqli);
                                    while ($counter = $counters->fetch_assoc()) { ?>
                                    <option value="<?=$counter['id']?>"><?=$counter['counter_name']?></option>
                                <?php } ?>
                                </select> 
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