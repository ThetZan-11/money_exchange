<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
<?php require_once '../db/user_crud.php' ?>
<?php 
if(isset($_GET['deleteId'])){
    if(user_softdelete ($mysqli , $_GET['deleteId'])){
      echo "<script>location.replace('./user_list.php')</script>";
    }
 }

 ?>
  <main id="main" class="main">
    <div class="container">  
    <h3>User List</h3>
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
      <th>Name</th>
      <th>Email</th>
      <th>Address</th>
      <th>Ph No</th>
      <th>Role</th>
      <th>Profile</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;

    if(isset($_POST['key'])){
        $key = $_POST['key'];
        $users = user_search ($mysqli , $_POST['key']);
    }else{
      $users = user_sd($mysqli);
    }
    

     while ($user = $users->fetch_assoc()) { ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['address'] ?></td>
        <td><?= $user['ph_no'] ?></td>
        <td><?php if($user['role']==1){
            echo "Admin";
        } else {
            echo "Staff";
        } ?></td>
        <td>
            <img src="../assets/img/<?= $user['user_img']?>" width="50px" height="50px">
        </td>
        <td>
          <?php if ($user['role']!=1) { ?>
              <a class="btn btn-primary btn-sm" href="./add_user.php?id=<?= $user['id'] ?>">
              <i class="fa-solid fa-pen"></i>
               <!-- Update -->
            </a>
          <?php } ?>
          
          <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $user['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
               <!-- Delete -->
            </a>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
</table>
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
<script>
let successMsg =document.getElementById("success-message");
// let role =document.getElementById("role");

setTimeout(() => {
    successMsg.innerHTML= "";
},2000);

function deleteFun(){
}


</script>
