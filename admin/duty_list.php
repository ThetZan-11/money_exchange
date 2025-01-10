<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php   
  if(isset($_GET['deleteId'])){
    if(duty_soft_delete ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./duty_list.php')</script>";
    }
 }
?>
  <main id="main" class="main">
    <div class="container">
      <h3>Duty Schedule</h3>
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
      <th>Staff Name</th>
      <th>Counter Name</th>
      <th>Location</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Action </th>
    </tr>
  </thead>
  <tbody>
    <?php

if(isset($_POST['key']) && $_POST['key'] != ''){
    $key = $_POST['key'];
    $duties =  search_duty($mysqli, $key);
  } else {
    $duties = select_duty($mysqli);
}
    $i = 1;
     while ($duty = $duties->fetch_assoc()) { 
          ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $duty['name'] ?></td>
        <td><?= $duty['counter_name'] ?></td>
        <td><?= $duty['location'] ?></td>
        <td><?= $duty['from_date'] ?></td>
        <td><?= $duty['to_date'] ?></td>
        <td>
        <a class="btn btn-primary btn-sm" href="./add_duty.php?id=<?= $duty['id'] ?> "><i class="fa-solid fa-pen"></i></a>
        <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $duty['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
</table>
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
