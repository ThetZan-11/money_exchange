<?php require_once ("../layout/header.php") ?>
<?php require_once ("../layout/sidebar.php") ?>
<?php require_once ("../layout/nav.php") ?>

<?php 

if(isset($_GET['deleteId'])){
    delete_customer($mysqli,($_GET['deleteId']));
    echo "<script>location.replace('./customer_list.php')</script>";
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
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customers</th>
                    <th>Buy Currency</th>
                    <th>Sell Currency</th>
                    <th>From Amount</th>
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
                if(isset($_POST['key']) && $_POST['key'] != ''){
                    $key = $_POST['key'];
                    $customer =  search_query_for_customer($mysqli, $key);
                } else {
                    $trades= show_trades($mysqli);
                }

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