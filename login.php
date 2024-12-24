<?php require_once("./db/db.php") ?>
<?php require_once("./db/user_crud.php") ?>
<?php

if (isset($_COOKIE['user'])) {
    header("location:./role.php");
}

if (have_admin($mysqli)) {
    $admin_password = password_hash("password", PASSWORD_BCRYPT);
    save_user($mysqli, "admin", "admin@gmail.com", $admin_password, "YGN", "09942801162", 1, "admin.png");
}

$email = $emailErr = "";
$password = $passwordErr = "";
$formErr = "";
$invalid = false;

if (isset($_POST['email'])) {
    $email      =  $mysqli->real_escape_string($_POST['email']);
    $password   =  $mysqli->real_escape_string($_POST['password']);

    if ($email == "") {
        $emailErr   = "Can't be blank.";
        $invalid    = true;
    }
    if ($password == "") {
        $passwordErr   = "Can't be blank.";
        $invalid       = true;
    }

    if (!$invalid) {
        $users_with_email = get_user_with_email($mysqli, $email);
        if (!$users_with_email) {
            $emailErr = "Email Does Not match!";
        } else {
            if (password_verify($password, $users_with_email['password'])) {
                setcookie("user", json_encode($users_with_email), time() + 1000 * 60 * 60 * 24 * 14, "/");
                header("Location:./role.php ");
            } else {
                $passwordErr = "Password does not exits.";
            }
        }
    }
}

?>
<?php  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;

    }
</style>

<body>
    <div class="container-fluid p-5">
        <div class="p-5">
            <form method="post" id="form">
                <div class="container-form">
                    <?php
                    if (isset($_GET['login']) && $_GET['login'] == "Login Please") {
                        $formErr = "Login Again!"; ?>
                        <div class="alert alert-danger">
                            <?= $formErr ?>
                        </div>
                    <?php } ?>
                    <div class="form-group-input">
                        <h1>Login Here</h1>
                        <p class="para">Welcome back. Enter your Credentials to access your account.</p>
                    </div>

                    <div class="form-group-input">
                        <label for="email">Email Address</label>
                        <input type="text" placeholder="Enter your email address" id="email" name="email">
                        <small class="text-sm text-danger"><?= $emailErr ?></small>
                    </div>
                    <div class="form-group-input">
                        <!-- <i class="fa-solid fa-eye"></i> -->
                        <i class="fa-solid fa-eye-slash" style="font-size:20px;" id="showpsw"></i>
                        <label for="email">Password</label>
                        <input type="password" placeholder="Enter your password" id="password" name="password">
                        <small class="text-sm text-danger"><?= $passwordErr ?></small>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>

                    <button class="continue" id="login-btn">Continue</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        let showpsw = document.getElementById("showpsw")
        let password = document.getElementById("password")
        let remember = document.getElementById("remember")
        let login_btn = document.getElementById("login-btn")
        let form = document.getElementById("form")
        let email = document.getElementById("email");
        let status = true;

        showpsw.addEventListener("click", () => {
            if (showpsw.classList[1] == "fa-eye-slash") {
                password.type = "text";
                showpsw.classList.remove("fa-eye-slash")
                showpsw.classList.add("fa-eye");
            } else {
                showpsw.classList.remove("fa-eye")
                showpsw.classList.add("fa-eye-slash");
                password.type = "password";
            }
        })

        email.addEventListener("keyup", () => {
            if (status) {
                if (email.value == localStorage.getItem('email')) {
                    password.value = localStorage.getItem('password');
                } else {
                    password.value = "";
                }
            }

        })

        password.addEventListener("change", () => {
            status = false;
        })

        login_btn.addEventListener("click", (e) => {
            e.preventDefault();
            if (remember.checked == true) {
                const email_storage = document.getElementById("email").value
                const password_storage = document.getElementById("password").value
                if (email != "" && password != "") {
                    console.log(email_storage, password_storage)
                    localStorage.setItem('email', email_storage);
                    localStorage.setItem('password', password_storage);
                }
            }
            form.submit();
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>