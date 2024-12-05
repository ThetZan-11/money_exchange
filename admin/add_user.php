<?php require_once '../layout/header.php' ?>
<?php require_once '../layout/nav.php' ?>
<?php require_once '../layout/sidebar.php' ?>
<?php 
$name = $nameErr = "";
$email = $emailErr = "";
$pwd = $pwdErr = "";
$address = $addErr = "";
$phone = $phoneErr = "";
$profile = $profileErr ="";
$select = $selectErr = "";
$inavlid = false;

if(isset($_POST['name'])){
    $name =trim($_POST['name']);
    $email =trim($_POST['email']);
    $pwd =trim($_POST['pwd']);
    $address =trim($_POST['address']);
    $phone =trim($_POST['phone']);
    $select = ($_POST['select']);

    if($name == ""){
       $nameErr ="name cann't be blank!";
       $inavlid = true;
    }

    if($email == ""){
      $emailErr ="email cann't be blank!";
      $inavlid = true;
   } else if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/ ", $email)) {
        $emailErr = "Please enter email format!";
        $invalid = true;
    }

   if($pwd == ""){
    $pwdErr ="password cann't be blank!";
    $inavlid = true;
    }else if( !preg_match( '/[^A-Za-z0-9]+/', $pwd) || strlen( $pwd) < 8)
    {
        $pwdErr ="Enter at least 8 digit!";
    }

  if($address == ""){
    $addErr ="address cann't be blank!";
    $inavlid = true;
  }

  if($phone == ""){
    $phoneErr ="address cann't be blank!";
    $inavlid = true;
  }else if(!preg_match('/^\S+@\S+\.\S+$/', $phone)){
   $phoneErr ="Enter only number";
  }

  if($profile == ""){
    $profileErr ="Please choos profile!";
    $inavlid = true;
  }

  if (isset($_POST['select']) && $_POST['select'] == '0') {
    $selectErr = 'Please select one.';
}

}



?>

  <main id="main" class="main">
   
      <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">
          <div class="card-title  mx-auto"><h3>Add User</h3></div>
          <div class="card-body mx-auto">
          <form method="post" enctype="multipart/form-data">
            <div class="input mx-auto">
                <div class="forname mb-4">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" style="width:100%; height:50px;" value="<?= $name ?>">
                    <div class="invalid" ><?= $nameErr ?></div>
                </div>
                <div class="foremail mb-4">
                    <label for="name">Email</label>
                    <input type="text" class="form-control" name="email"placeholder="Enter your email" style="width:100%; height:50px;" value="<?= $email ?>">
                    <div class="invalid"><?= $emailErr ?></div>
                </div>
                <div class="forpwd mb-4">
                    <label for="name">Password</label>
                    <input type="password" class="form-control pwd" name="pwd" placeholder="Enter your password" style="width:100%; height:50px;" value="<?= $pwd ?>">
                    <div class="invalid"><?= $pwdErr ?></div>
                    <input type="checkbox" class="check">
                    <label for="vehicle1">show password</label><br>
                </div>
                <div class="foraddress mb-4">
                    <label for="name">Address</label>
                    <input type="text" class="form-control" name="address"placeholder="Enter your address" style="width:100%; height:50px;"value="<?= $address ?>">
                    <div class="invalid"><?= $addErr ?></div>
                </div>
                <div class="forphno mb-4">
                    <label for="name">Phone Number</label>
                    <input type="text" class="form-control" name="phone"placeholder="Enter your phone number" style="width:100%; height:50px;"value="<?= $phone ?>">
                    <div class="invalid"><?= $phoneErr ?></div>
                </div>
                <div class="forselect mb-4">
                    <select class="form-select" name="select"style="width:100%; height:50px;" value ="<?= $select ?>">
                        <option selected value ="0">Open this select menu</option>
                        <option value="1">Admin</option>
                        <option value="2">staff</option>
                    </select>
                    <div class="invalid"><?= $selectErr ?></div>
                </div>
                <div class="forprofile mb-4">
                    <label for="name">Profile</label>
                    <input type="file" name="profile" class="form-control" name="phone"placeholder="please choose profile" style="width:500px; height:50px;"vlaue="<?= $profile ?>">
                    <div class="invalid"><?= $profileErr ?></div>
                </div>
                <button type="submit" value="submit" class="btn btn-primary">submit</button>
              </div>
            </form>
        </div>
   
      </div>
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