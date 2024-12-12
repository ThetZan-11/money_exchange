<?php require_once '../db/db.php' ?>
<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
<?php require_once '../db/counter_crud.php' ?>

<?php   
 if(isset($_GET['deleteId'])){
    if(delete_counter ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./counter_list.php')</script>";
    }

 }
?>

  <main id="main" class="main">
    <div class="container">
    <table class="table table-bordered">
  <thead>
    <tr>
        <th>No</th>
      <th>Counter-Name</th>
      <th>Location</th>
      <th>Action </th>
          </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    $counters = get_counter($mysqli);
     while ($counter = $counters->fetch_assoc()) { ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $counter['counter_name'] ?></td>
        <td><?= $counter['location'] ?></td>
        <td>
        <a class="btn btn-primary btn-sm" href="./add_counter.php?id=<?= $counter['id'] ?> "><i class="fa-solid fa-pen"></i></a>
        <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $counter['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
</table>
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
