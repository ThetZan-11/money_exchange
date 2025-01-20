<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php   
 if(isset($_GET['deleteId'])){
    if(soft_delete_currency_pair ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./currencypair_list.php')</script>";
    }
 }
?>

  <main id="main" class="main">
    <div class="container">
      <h3>Currency Pair List</h3>
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
        <th>No</th>
        <th>Buy Currency Name</th>
        <th>Sell Currency Name</th>
        <th>Action </th>
  </thead>
  <tbody>
    <?php
    $i = 1;
    if(isset($_POST['key']) && $_POST['key'] != ''){
      $currencypairs = currency_pair_search ($mysqli , $_POST['key']);
    }else {
      $currencypairs  =  get_all_currency_pair_separate($mysqli);
    }
    while ($currencypair = $currencypairs->fetch_assoc()) { ?>   
     <tr>
        <td><?= $i ?></td>
        <td><?php 
            echo $currencypair['buy_currency_name'];
            ?>
        </td>
        <td><?php 
            echo $currencypair['sell_currency_name'];
            ?></td>
        <td>
        <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $currencypair['pair_id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
    </table>

    
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
