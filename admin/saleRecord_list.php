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
    $trades = sale_record_filter_counter($mysqli, $counter_id);
} else {
    if(isset($_POST['key']) && $_POST['key'] != ''){
        $key = $_POST['key'];
        $trades =  search_query_for_sale_record($mysqli, $key);
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
                <option value="">Select Counter</option>
                <?php  
                $counters = get_counter($mysqli); 
                while($counter = $counters->fetch_assoc()){ ?>
                    <option value="<?= $counter['id'] ?>"><?= $counter['counter_name'] ?></option>
                <?php } ?>
            </select>
        </form>
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