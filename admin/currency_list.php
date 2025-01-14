<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php   
 if(isset($_GET['deleteId'])){
    if(soft_delete_currency ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./currency_list.php')</script>";
    }
 }
?>

  <main id="main" class="main">
    <div class="container">
      <h3>Currency List</h3>
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
        <th>Currency Name</th>
        <th>Currency Code</th>
        <th>Total</th>
        <th>Flag</th>
        <th>Action </th>
  </thead>
  <tbody>
    <?php
    $i = 1;
    if(isset($_POST['key'])){
      $currencies = currency_search ($mysqli , $_POST['key']);
    }else {
      $currencies  =  currency_sd($mysqli);
    }

     while ($currency = $currencies->fetch_assoc()) { ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $currency['currency_name'] ?></td>
        <td><?= $currency['currency_code'] ?></td>
        <td class="text-end"><?= number_format($currency['total']) ?></td>
        <td><img src="../assets/flag/<?= $currency['flag']?>" width="50px" height="50px"></td>
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
