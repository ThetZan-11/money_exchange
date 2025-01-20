<?php require_once ("../layout/header.php") ?>
<?php require_once ("../layout/sidebar.php") ?>
<?php require_once ("../layout/nav.php") ?>

<?php 

if(isset($_GET['deleteId'])){
    delete_customer($mysqli,($_GET['deleteId']));
    echo "<script>location.replace('./customer_list.php')</script>";
}

if(isset($_POST['filter'])){
    $counter_id = $_POST['filter'];
    $trades = show_trades_with_counter($mysqli, $counter_id);
    if($counter_id == ""){
        $trades= show_trades($mysqli);
    }
} else {
    if(isset($_POST['key']) && $_POST['key'] != ''){
        $key = $_POST['key'];
        $trades =  search_show_trade($mysqli, $key);
    } else {
        $trades= show_trades($mysqli);
    }
}

?>
<main id="main" class="main">
    <div class="container">
        <h3>Sales Record</h3>
    <div style="width:100%; height:55px;" class="mt-3" id="success-message">
        <?php if (isset($_GET['edit_success'])) { ?>
            <p class="alert alert-success"><?= $_GET['edit_success'] ?></p>    
        <?php } else if(isset($_GET['add_success'])){ ?>
            <p class="alert alert-success"><?= $_GET['add_success'] ?></p>
        <?php } else if(!isset($_GET['edit_success']) && !isset($_GET['add_success'])){ ?>
            <p></p>
        <?php } ?> 
     </div>
     <div>
        <form method="post" id="filter_counter_form">
            <select name="filter" class="form-control" id="counter_select" value="<?= $counter_id ?>">
                <option value="">All Counter</option>

                <?php  
                $counters = get_counter($mysqli); 
                while($counter = $counters->fetch_assoc()){ 
                if(isset($counter_id) && $counter_id==$counter['id']){
                    $selected = "selected";
                } else {
                    $selected = "";
                } ?>
                    <option value="<?= $counter['id'] ?>" <?= $selected ?> ><?= $counter['counter_name'] ?></option>
                <?php } ?>
            </select>
        </form>
    </div>
        <table class="table table-bordered datatable">
            <thead>
            <tr>
                    <th>No</th>
                    <th>Customers</th>
                    <th>Buy Currency</th>
                    <th>Sell Currency</th>
                    <th>From Amount</th>
                    <th>To Amount</th>
                    <th>Counter Name</th>
                    <th>Staff Name</th>
                    <th>Rate</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while($trade = $trades->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $trade['customer_name'] ?></td>
                        <td><?= $trade['buy_currency'] ?></td>
                        <td><?= $trade['sell_currency'] ?></td>
                        <td><?= number_format($trade['from_amount'] )?> </td>
                        <td><?= number_format($trade['to_amount'] )?> </td>
                        <td><?= $trade['counter_name'] ?></td>
                        <td><?= $trade['staff_name'] ?></td>
                        <td><?= $trade['rate'] ?></td>
                        <td><?= $trade['date'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="./receipt.php?id=<?= $trade['trade_id'] ?>"><i class="fa-solid fa-circle-info"></i></a>
                        </td>
                    </tr>
                    <?php $i++;} ?>

            </tbody>
        </table>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>