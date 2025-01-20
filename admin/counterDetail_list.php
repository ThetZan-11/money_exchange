<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>


<?php
if (isset($_GET['deleteId'])) {
  if (delete_currency_counter($mysqli, $_GET['deleteId'])) {
    echo "<script>location.replace('./counterDetail_list.php')</script>";
  }
}

if (isset($_POST['status_on'])) {
  $currencyPairCounter_id = $_POST['status_on'];
  status_on($mysqli, $currencyPairCounter_id);
  echo "<script>location.replace('./counterDetail_list.php')</script>";
} 

if(isset($_POST['status_off'])){
  $currencyPairCounter_id = $_POST['status_off'];
  status_off($mysqli, $currencyPairCounter_id);
  echo "<script>location.replace('./counterDetail_list.php')</script>";
}

?>


<main id="main" class="main">
  <div class="container-fluid">
    <h3>Counter With Currency</h3>
    <div style="width:100%; height:55px;" class="mt-3" id="success-message">
      <?php if (isset($_GET['edit_success'])) { ?>
        <p class="alert alert-success"><?= $_GET['edit_success'] ?></p>
      <?php } else if (isset($_GET['add_success'])) { ?>
        <p class="alert alert-success"><?= $_GET['add_success'] ?></p>
      <?php } else if (!isset($_GET['edit_success']) && !isset($_GET['add_success'])) { ?>
        <p></p>
      <?php } ?>
    </div>
    <table class="table table-bordered datatable">
      <thead>
        <tr>
          <th>No</th>
          <th>Counter Name</th>
          <th>Available Currency</th>
          <th>Action </th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;

        if(isset($_POST['key']) && $_POST['key'] != ''){
          $currencyCounters = search_currency_pair_counter($mysqli , $_POST['key']);
         }else {
          $currencyCounters = show_currency_pair_counter($mysqli);
         }
       
        while ($currencyCounter = $currencyCounters->fetch_assoc()) { ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $currencyCounter['counter_name'] ?></td>
            <td><?= $currencyCounter['pair_name'] ?></td>
            <td class="d-flex justify-content-evenly">
              <form method="post">
              <?php 
                if($currencyCounter['status'] == true){ ?>
                 <button class="btn btn-sm btn-danger" name="status_off" value="<?= $currencyCounter['id']?>">
                  <i class="fa-solid fa-xmark"></i>
                </button>
                  
                <?php } else { ?>
                  <button class="btn btn-sm btn-success" name="status_on" value="<?= $currencyCounter['id']?>">
                  <i class="fa-solid fa-check"></i>
                </button>
              <?php } ?>
              </form>
            </td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
  </div>

</main>
<?php require_once '../layout/footer.php' ?>