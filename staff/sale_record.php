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
        <h3 class ="title">Sales Record</h3>
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
                    <th>Email</th>
                    <th>Exchange Amount</th>
                    <th>Convert Amount</th>
                    <th>Buy Currency</th>
                    <th>Sell Currency</th>
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
                        <td><?= $trade['name'] ?></td>
                        <td><?= $trade['email'] ?></td>
                        <td><?= number_format($trade['exchange_amount'] )?> </td>
                        <td><?= number_format($trade['converted_amount'] )?> </td>
                        <td><?= $trade['buy_currency_name'] ?></td>
                        <td><?= $trade['sell_currency_name'] ?></td>
                        <td><?= $trade['date'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="./receipt.php?id=<?= $trade['id'] ?>"><i class="fa-solid fa-circle-info"></i></a>
                        </td>
                    </tr>
                    <?php $i++;} ?>

            </tbody>
        </table>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>