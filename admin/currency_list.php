<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php   
 if(isset($_GET['deleteId'])){
    if(delete_currency ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./currency_list.php')</script>";
    }
 }
?>
<style>
    table th{
        font-size: 15px;
    }
table{
        font-size: 14px;
    }
</style>
  <main id="main" class="main">
    <div class="container">
      <h3 class ="title">Currency List</h3>
    <div style="width:100%; height:55px;" class="mt-3" id="success-message">
        <?php if (isset($_GET['edit_success'])) { ?>
            <p class="alert alert-success"><?= $_GET['edit_success'] ?></p>    
        <?php } else if(isset($_GET['add_success'])){ ?>
            <p class="alert alert-success"><?= $_GET['add_success'] ?></p>
        <?php } else if(!isset($_GET['edit_success']) && !isset($_GET['add_success'])){ ?>
            <p></p>
        <?php } ?> 
     </div>
    <table class="table table-bordered  datatable">
  <thead>
    <tr>
        <th>No</th>
        <th>Currency Name</th>
        <th>Sell Currency Name</th>
        <th>Sell Currency Code</th>
        <th>Buy Currency Name</th>
        <th>Buy Currency Code</th>
        <th>Action </th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    $currencies = get_all_currency($mysqli);
     while ($currency = $currencies->fetch_assoc()) { ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $currency['currency_name'] ?></td>
        <td><?= $currency['sell_currency_name'] ?></td>
        <td><?= $currency['sell_currency_code'] ?></td>
        <td><?= $currency['buy_currency_name'] ?></td>
        <td><?= $currency['buy_currency_code'] ?></td>
        <td>
        <a class="btn btn-primary btn-sm" href="./add_currency.php?id=<?= $currency['id'] ?> "><i class="fa-solid fa-pen"></i></a>
        <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $currency['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
    </table>

    
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
