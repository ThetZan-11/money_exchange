<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>


<?php
if (isset($_GET['deleteId'])) {
  if (delete_currency_counter($mysqli, $_GET['deleteId'])) {
    echo "<script>location.replace('./counter_detail_list.php')</script>";
  }
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
        $currencyCounters = get_currency_counter($mysqli);
        while ($currencyCounter = $currencyCounters->fetch_assoc()) { ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $currencyCounter['counter_name'] ?></td>
            <td><?= $currencyCounter['currency_name'] ?></td>
            <td>
              <a class="btn btn-primary btn-sm" href="./manage_counter.php?id=<?= $currencyCounter['id'] ?> "><i class="fa-solid fa-pen"></i></a>
              <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $currencyCounter['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
  </div>

</main>
<?php require_once '../layout/footer.php' ?>