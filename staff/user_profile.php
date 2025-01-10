<?php require_once '../layout/header.php'  ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
<?php
$name = $nameErr = "";
$email = $emailErr = "";
$address = $addErr = "";
$phone = $phoneErr = "";
$profile = $profileErr = "";
$role = $roleErr = "";
$currentPsw = $currentPswErr = "";
$newpsw = $newPswErr = "";


$users = get_user_with_id($mysqli, $_GET['id']);
$user = $users->fetch_assoc();


if ($_GET['id'] == '') {
  echo "<script>location.replace('./index.php')</script>";
} else {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $user['name'];
    $email = $user['email'];
    $address = $user['address'];
    $phone = $user['ph_no'];
    $role = $user['role'];
    $oldImage = $user['user_img'];

    var_dump($oldImage);
  }
}

if (isset($_POST['name'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $user_img = $_FILES['profile'];
  $invalid = false;

  if($name == "") {
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

  if ($address == "") {
    $addErr = "address cann't be blank!";
    $inavlid = true;
  }

  if($phone == "") {
    $phoneErr = "Phone cann't be blank!";
    $inavlid = true;
  } else if (!is_numeric($phone)) {
    $phoneErr = "Enter only number";
  }

  if (!$invalid) {

      if($user_img['name']==""){
        update_user_profile($mysqli, $id, $name, $email, $address, $phone, $oldImage);
        echo "<script>location.replace('./user_profile.php?id=$id')</script>";
      } else {
        $filePath = "../assets/img/".$oldImage;
        unlink($filePath);
        $tmp = $user_img['tmp_name'];
        $user_profile_name = date("YMDHS") . $user_img['name'];
        update_user_profile($mysqli, $id, $name, $email, $address, $phone, $user_profile_name);
        move_uploaded_file($tmp, '../assets/img/' . $user_profile_name);
        echo "<script>location.replace('./user_profile.php?id=$id')</script>";
      }
    }
}

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $user['name'] ?>'s Profile</h1>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-5">
          <div class="profile-card pt-4 d-flex flex-column align-items-center">

            <img src="../assets/img/<?= $user['user_img']  ?>" alt="Profile" class="rounded-circle">
            <h2><?= $user['name'] ?></h2>
            <h3><?php if ($user['role'] == 1) echo "Admin";
                else {
                  echo "Staff";
                }  ?></h3>
            <div style="width: 100%;">
              <h5 class="card-title">Profile Details</h5>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label ">Full Name</div>
                <div class="col-lg-7 col-md-6"> <?= $user['name'] ?></div>
                
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Company</div>
                <div class="col-lg-7 col-md-6">Money Exchange Company</div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Job</div>
                <div class="col-lg-7 col-md-6"><?php if ($user['role'] == 1) echo "Admin";
                                                else {
                                                  echo "Staff";
                                                }  ?></div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Country</div>
                <div class="col-lg-7 col-md-6">Myanmar</div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Address</div>
                <div class="col-lg-7 col-md-6"><?= $user['address'] ?></div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Phone</div>
                <div class="col-lg-7 col-md-6"><?= $user['ph_no'] ?></div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-5 col-md-6 label">Email</div>
                <div class="col-lg-7 col-md-6"><?= $user['email'] ?></div>
              </div>                            
            </div>
          </div>
        

      </div>

      <div class="col-xl-7">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
           <!-- <h3>Edit Profile</h3> -->
           
            <div class="pt-2">

              <div class="tab-pane " id="profile-edit">

                <!-- Profile Edit Form -->
                <h5 class="card-title">Edit  Details</h5>
                <form method="post" enctype="multipart/form-data" id="edit-form">
                  <div class="row mb-3" id="uploadContainer">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9" id="uploadContainer">
                      <img src="../assets/img/<?= $user['user_img'] ?>" alt="Profile" id="showimg" width="100px" height="100px">
                      <div class="pt-2 d-flex align-items-center">
                        <input type="file" name="profile" class="form-control me-3" style="width:80%;" id="img-input"></i></>
                      </div>
                      <span class="text-danger"><?= $profileErr ?></span>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="name" type="text" class="form-control" id="fullName" value="<?= $name ?>">
                      <span class="text-danger"><?= $nameErr ?></span>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="<?= $address ?>">
                      <span class="text-danger"><?= $addErr ?></span>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value="<?= $phone ?>">
                      <span class="text-danger"><?= $phoneErr ?></span>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="<?= $email ?>">
                      <span class="text-danger text-1"><?= $emailErr ?></span>
                    </div>
                  </div>
             
                  <div class="text-center">
                    <button type="submit" id="editbtn" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>

              </div>

            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>
<script>
  let input = document.getElementById("img-input");
  let img = document.getElementById("showimg");
  let uploadContainer = document.getElementById("uploadContainer");
  let changePassword = document.getElementById("changePassword");


  input.addEventListener("change", () => {
    if (input.files && input.files['0']) {
      var reader = new FileReader();
      reader.addEventListener("load", (e) => {
        img.setAttribute('src', e.target.result);
      })
      reader.readAsDataURL(input.files[0]);
    }
  })
</script>

<?php require_once '../layout/footer.php'  ?>