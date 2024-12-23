<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

  <main id="main" class="main">
    <div class="container">
    <table class="table table-bordered datatable">
  <thead>
    <tr>
        <th>No</th>
      <th>Currency Name</th>
      <th>Sell Rate</th>
      <th>Buy Rate</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    
     ?>
     <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        <a class="btn btn-primary btn-sm" href="./add_duty.php?id="><i class="fa-solid fa-pen"></i></a>
        <button class="btn btn-sm btn-danger counterDelete" data-value="" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
   
  </tbody>
</table>
    </div>
  </main>
<?php require_once '../layout/footer.php' ?>
