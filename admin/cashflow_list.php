<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
 

<?php
$search_result = "";
if (isset($_GET['deleteId'])) {
  if (soft_delete($mysqli, $_GET['deleteId'])) {
    echo "<script>location.replace('./counter_list.php')</script>";
  }
}

?>
<main id="main" class="main">

  <div class="container">
    <h3>Counter List</h3>
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
          <th>Counter-Name</th>
          <th>Currency Name</th>
          <th>Total</th>
          <th>Action </th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;

        if(isset($_POST['key'])){
         $counters = counter_search ($mysqli , $_POST['key']);
        }else {
          $cash_flows = select_cash_flow($mysqli);
        }
       
        while ($cash_flow = $cash_flows->fetch_assoc()) { ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $cash_flow['counter_name'] ?></td>
            <td><?= $cash_flow['currency_name'] ?></td>
            <td class="text-end"><?= number_format($cash_flow['total'])." ".$cash_flow['currency_code'] ?></td>
            <td>
              <a class="btn btn-primary btn-sm" href="./cash_flow.php?id=<?= $cash_flow['id'] ?> "><i class="fa-solid fa-pen"></i></a>
              <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $cash_flow['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
  </div>
</main>
<?php require_once '../layout/footer.php' ?>