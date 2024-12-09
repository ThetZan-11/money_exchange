<?php require_once '../layout/header.php'  ?>
<?php require_once '../layout/nav.php'  ?>
<?php require_once '../layout/sidebar.php' ?>
<?php
$name = $nameErr = "";
$email = $emailErr = "";
$address = $addErr = "";
$phone = $phoneErr = "";
$profile = $profileErr = "";
$profileName = "";
$role = $roleErr = "";
$invalid = false;

if (isset($_GET['id'])) {
  $users = get_user_with_id($mysqli, $_GET['id']);
  $user = $users->fetch_assoc();
  $id = $_GET['id'];
  $name = $user['name'];
  $email = $user['email'];
  $address = $user['address'];
  $phone = $user['ph_no'];
  $role = $user['role'];
  $profile = $user['user_img'];
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

if ($role == "") {
  $roleErr = 'Please select one.';
  $invalid   = true;
} else if ($role != 1 && $role != 2) {
  $roleErr = "Please select available role";
  $invalid = true;
}
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $user['name'] ?>'s Profile</h1>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="../assets/img/<?= $user['user_img']  ?>" alt="Profile" class="rounded-circle">
            <h2><?= $user['name'] ?></h2>
            <h3><?php if ($user['role'] == 1) echo "Admin";
                else {
                  echo "Staff";
                }  ?></h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <!-- <h5 class="card-title">About</h5>
              <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"> <?= $user['name'] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8">Money Exchange Company</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Job</div>
                  <div class="col-lg-9 col-md-8"><?php if ($user['role'] == 1) echo "Admin";
                                                  else {
                                                    echo "Staff";
                                                  }  ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">Myanmar</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8"><?= $user['address'] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8"><?= $user['ph_no'] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?= $user['email'] ?></div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form method="post" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="../assets/img/<?= $profile ?>" alt="Profile" id="showimg" width="100px" height="100px">
                      <div class="pt-2 d-flex align-items-center">
                        <input type="file" name="profile" class="form-control me-3" style="width:80%;" value="<?= $profile ?>" id="img-input"></i></>
                        <a id="deleteImg" class="btn btn-danger" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="name" type="text" class="form-control" id="fullName" value="<?= $user['name'] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Role</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="role" value="<?= $role ?>" class="form-control">
                        <option
                          <?php if ($role == 1) {
                            echo "selected";
                          }  ?>
                          value="1">Admin</option>
                        <option
                          <?php if ($role == 2) {
                            echo "selected";
                          }  ?>
                          value="2">Staff</option>
                      </select>

                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="<?= $address ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value="<?= $phone ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="<?= $email ?>">
                    </div>
                  </div>
                  <!-- 
                <div class="row mb-3">
                  <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                  </div>
                </div> -->

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>


              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main>
<script>
  let input = document.getElementById("img-input");
  let deleteImg = document.getElementById("deleteImg");
  let img = document.getElementById("showimg");
  let inputVal =input.value;
  console.log(inputVal);
  
  input.addEventListener("change", () => {
    if (input.files && input.files['0']) {
      var reader = new FileReader();
      reader.addEventListener("load", (e) => {
        img.setAttribute('src', e.target.result);
        deleteImg.addEventListener("click", () => {
          img.setAttribute('src', '../assets/img/<?= $profile ?>');
          input.value = "";
        })
      })
      reader.readAsDataURL(input.files[0]);
    }
  })
</script>
<?php require_once '../layout/footer.php'  ?>