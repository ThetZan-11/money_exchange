<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>

<?php
$name = $nameErr = "";
$email = $emailErr = "";
$pwd = $pwdErr = "";
$address = $addErr = "";
$phone = $phoneErr = "";
$profile = $profileErr = "";
$select = $selectErr = "";
$profileName = "";
$invalid = false;

if (isset($_GET['id'])) {
  $users = get_user_with_id($mysqli, $_GET['id']);
  $user = $users->fetch_assoc();
  $id = $_GET['id'];
  $name = $user['name'];
  $email = $user['email'];
  $address = $user['address'];
  $phone = $user['ph_no'];
  $select = $user['role'];
}

if (isset($_POST['name'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $address = trim($_POST['address']);
  $phone = trim($_POST['phone']);
  $select = $_POST['select'];
  $profile = $_FILES['profile'];
  $profileName = date('DMYHS') . $profile['name'];
  $tmp = $profile['tmp_name'];

  $allEmails = get_email_of_user($mysqli);

  if (!isset($_GET['id'])) {
    $pwd = $pwd = trim($_POST['pwd']);
  }

  if ($name == "") {
    $nameErr = "name cann't be blank!";
    $inavlid = true;
  }

  if ($email == "") {
    $emailErr = "email cann't be blank!";
    $invalid = true;
  } else if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/ ", $email)) {
    $emailErr = "Please enter email format!";
    $invalid = true;
  }

  if ($pwd == "") {
    $pwdErr = "password cann't be blank!";
    $inavlid = true;
  } else if (strlen($pwd) < 8) {
    $pwdErr = "Enter at least 8 digit!";
  }

  if ($address == "") {
    $addErr = "address cann't be blank!";
    $inavlid = true;
  }

  if ($phone == "") {
    $phoneErr = "Phone cann't be blank!";
    $inavlid = true;
  } else if (!is_numeric($phone)) {
    $phoneErr = "Enter only number";
  }

  if ($profile == "") {
    $profileErr = "Please choose profile!";
    $invalid    = true;
  }

  if ($select == "") {
    $selectErr = 'Please select one.';
    $invalid   = true;
  } else if ($select != 1 && $select != 2) {
    $selectErr = "Please select available role";
    $invalid = true;
  }

  if ($profile['name'] == "") {
    $profileErr = "Please insert images";
    $invalid = true;
  }

  if (!$invalid) {
    if (isset($_GET['id'])) {
      $profile = $_FILES['profile'];
      $profileName = $profile['name'];
      update_user($mysqli, $id, $name, $email, $address, $phone, $select, $profileName);
      move_uploaded_file($profile['tmp_name'], '../assets/img/' . $profileName);
      echo "<script>location.replace('./user_list.php?edit_success=Edit Successfully')</script>";
    } else {
      $hash_password = password_hash($pwd, PASSWORD_BCRYPT);
      save_user($mysqli, $name, $email, $hash_password, $address, $phone, $select, $profileName);
      move_uploaded_file($tmp, '../assets/img/' . $profileName);
      echo "<script>location.replace('./user_list.php?add_success=Edit Successfully')</script>";
    }
  }
}
?>

<main id="main" class="main">
  <div class="conatiner">
    <div class="card p-3 mx-auto" style="width:60%;">
      <?php if (!isset($_GET['id'])) { ?>
        <div class="card-title  mx-auto">
          <h3>Add User</h3>
        </div>
      <?php } else { ?>
        <div class="card-title  mx-auto">
          <h3>Edit User</h3>
        </div>
      <?php } ?>
      <div class="card-body mx-auto">
        <form method="post" enctype="multipart/form-data">
          <div class="input mx-auto">
            <div class="forname mb-4">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter your name" style="width:100%; height:50px;" value="<?= $name ?>">
              <div class="invalid"><?= $nameErr ?></div>
            </div>
            <div class="foremail mb-4">
              <label for="name">Email</label>
              <input type="text" class="form-control" name="email" placeholder="Enter your email" style="height:50px;" value="<?= $email ?>">
              <div class="invalid"><?= $emailErr ?></div>
            </div>

            <?php if (!isset($_GET['id'])) { ?>
              <div class="forpwd mb-4">
                <label for="name">Password</label>
                <input type="password" class="form-control pwd" name="pwd" placeholder="Enter your password" style="height:50px;" value="<?= $pwd ?>">
                <div class="invalid"><?= $pwdErr ?></div>
                <input type="checkbox" class="check" id="show">
                <label for="show">show password</label><br>
              </div>
            <?php } else { ?>
              <div></div>
            <?php } ?>


            <div class="foraddress mb-4">
              <label for="name">Address</label>
              <input type="text" class="form-control" name="address" placeholder="Enter your address" style="height:50px;" value="<?= $address ?>">
              <div class="invalid"><?= $addErr ?></div>
            </div>
            <div class="forphno mb-4">
              <label for="name">Phone Number</label>
              <input type="text" class="form-control" name="phone" placeholder="Enter your phone number" style="height:50px;" value="<?= $phone ?>">
              <div class="invalid"><?= $phoneErr ?></div>
            </div>
            <div class="forselect mb-4">
              <label for="name">Role</label>
              <select class="form-select" name="select" style="height:50px;" value="<?= $select ?>">
                <option value="">Open this select menu</option>
                <option <?php if ($select == 1) {
                          echo "selected";
                        } ?> value="1">Admin</option>
                <option <?php
                        if ($select == 2) {
                          echo "selected";
                        }
                        ?> value="2">Staff</option>
              </select>
              <div class="invalid"><?= $selectErr ?></div>
            </div>
            <div class="forprofile mb-4">
              <label for="name">Profile</label>
              <input type="file" name="profile" class="form-control" placeholder="please choose profile" style="height:50px;" value="<?= $profile ?>">
              <div class="invalid"><?= $profileErr ?></div>
            </div>
            <button type="submit" value="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>

</main>
<?php require_once '../layout/footer.php' ?>
<script>
  const checkTag = document.getElementsByClassName("check")[0];
  const pwdTag = document.getElementsByClassName("pwd")[0];
  console.log(checkTag);
  checkTag.addEventListener("click", () => {
    if (pwdTag.type == "password") {
      pwdTag.type = "text";
    } else {
      pwdTag.type = "password";
    }
  });
</script>