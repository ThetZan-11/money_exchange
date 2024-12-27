<?php
 require_once '../layout/header.php'
?>
<?php
require_once '../layout/nav.php'
?>
<?php
 require_once '../layout/sidebar.php'
?>
<?php 
$name = $email = $address = $phone = "";
$name_err = $email_err = $adderss_err = $phone_err ="";
$invalid = false;

if (isset($_GET['id'])) {
    $customers =get_customer_with_id($mysqli, $_GET['id']);
    $customer = $customers->fetch_assoc();
    $id = $_GET['id'];
    $name = $customer['name'];
    $email = $customer['email'];
    $address = $customer['address'];
    $phone = $customer['ph_no'];
    
}
if(isset($_POST['name'])){
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['ph_no'];

    if($name == ""){
        $name_err = "Name cann't be blank";
        $invalid = true;
    }

    if($email == ""){
        $email_err = "Email cann't be blank";
        $invalid = true;
    }

    if($address == ""){
        $adderss_err = "Address can't be blank";
        $invalid = true;
    }

    if($phone == ""){
        $phone_err = "Phone number can't be blank";
        $invalid = true;
    }


    if(!$invalid){
         
        if(get_customer_with_email($mysqli, $email)){
            $email_err = "Email already exists";
            $invalid = true;
        }else {   
            if(isset($_GET['id'])){
                update_customer($mysqli , $id , $name ,  $email , $address , $phone);
                echo "<script>location.replace('./customer_list.php?edit_success=Edit Successfully')</script>";
            } else {
                add_customer($mysqli , $name , $email , $address , $phone);
                echo "<script>location.replace('./customer_list.php?edit_success=Edit Successfully')</script>";
            }
        }
    }
}
?>

<main id="main" class="main">

    <div class="conatiner">
        <div class="card p-3 mx-auto" style="width:60%;">\
            <?php if(isset($_GET['id'])) { ?>
                <div class="text-center mb-3">
                <h3>Edit Customer</h3>
            </div>
           <?php }else { ?>
            <div class="text-center mb-3">
                <h3>add Customer</h3>
            </div>

          <?php } ?>
           
            <div class="card-body mx-auto">
                <form method="post" enctype="multipart/form-data">
                    <div class="input mx-auto">
                        <div class="forname mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="name" style="width:100%; height:50px;" value="<?= $name ?>">
                            <div class="invalid"><?= $name_err ?></div>
                        </div>

                        <div class="foremail mb-4">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="email" style="height:50px;" value="<?= $email ?>">
                            <div class="invalid"><?= $email_err ?></div>
                        </div>

                        <div class="foraddress mb-4">
                            <label for="name">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" style="height:50px;" value="<?= $address ?>">
                            <div class="invalid"><?= $adderss_err ?></div>
                        </div>

                        <div class="forphno mb-4">
                            <label for="name">Phone Number</label>
                            <input type="text" class="form-control" name="ph_no" placeholder="phone number" style="height:50px;" value="<?= $phone ?>">
                            <div class="invalid"><?= $phone_err ?></div>
                        </div>
                        <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>