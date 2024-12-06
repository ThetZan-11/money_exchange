<?php require_once '../db/db.php' ?>
<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
<?php require_once '../db/user_crud.php' ?>


  <main id="main" class="main">
    <div class="container">
    <table class="table table-dark">
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
    $users = get_all_user($mysqli);
     while ($user = $users->fetch_assoc()) { ?>
     <tr>
        <td><?= $i ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['address'] ?></td>
        <td><?= $user['ph_no'] ?></td>
        <td><?= $user['role'] ?></td>
        <td>
            <img src="../assets/img/<?= $user['user_img']?>" width="50px" height="50px">
        </td>
        <td>
            <a class="btn btn-primary btn-sm" href="./add_user.php?id=<?= $user['id'] ?>"><i class="fa-solid fa-pen"></i></a>
            <a class="btn btn-danger btn-sm" ><i class="fa-solid fa-trash"></i></a>
        </td>
    </tr>
    <?php $i++;} ?>
  </tbody>
</table>
    </div>
    
  </main>
<?php require_once '../layout/footer.php' ?>
<script>
const checkTag =document.getElementsByClassName("check")[0];
const pwdTag =document.getElementsByClassName("pwd")[0];
console.log(checkTag);
checkTag.addEventListener("click", () => {
  if(pwdTag.type == "password"){
     pwdTag.type = "text";
  }else {
    pwdTag.type = "password";
  }
});

</script>