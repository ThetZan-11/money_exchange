<?php require_once('./db/db.php') ?>
<?php require_once('./db/currency_crud.php') ?>
<?php require_once('./db/daily_exchange_crud.php') ?>
<?php require_once('./db/rate.php') ?>

<?php
$amount = $amountErr = "";
$from  = $fromErr = "";
$to  = $toErr = "";
$result = "";
$invalid = false;

if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];
    $from = $_POST['from'];
    $to = $_POST['to'];

    if ($amount == "") {
        $amountErr = "can't be blank!";
        $invalid = true;
    } else if (!is_numeric($amount)) {
        $amountErr = "must be number";
        $invalid = true;
    }
    if ($from == $to) {
        $fromErr = "can't be same";
        $toErr = "can't be same";
        $invalid = true;
    }

    if (!$invalid) {
        $rate = calculate_exchange($mysqli, $from, $to);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Currency Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free HTML5 Website Template by FreeHTML5.com" />
    <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="FreeHTML5.com" />
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="./assets_for_index/css/bootstrap.css">
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="./assets_for_index/css/owl.carousel.css">
    <link rel="stylesheet" href="./assets_for_index/css/owl.theme.default.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="./assets_for_index/css/animate.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- Theme style  -->
    <link rel="stylesheet" href="./assets_for_index/css/style.css">
</head>

<body>


    <div id="page-wrap">
        <!-- ==========================================================================================================
													   HERO
		 ========================================================================================================== -->

        <div id="fh5co-hero-wrapper">
            <nav class="container navbar navbar-expand-lg main-navbar-nav navbar-light">
                <a class="navbar-brand" href="./">Currency Exchange</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-items-center ml-auto mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login For Admins</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container fh5co-hero-inner">
                <h1 class="animated fadeIn wow mb-3" data-wow-delay="0.4s">Your Exchange Rate is Here!</h1>
                <img class="fh5co-hero-smartphone animated fadeInRight wow" data-wow-delay="1s" src="./assets_for_index/img/money_exchange.gif" alt="Smartphone">
                <div class="card p-5" style="width: 65%; border:none; background-color: #99e3f3; border-radius:30px;">
                    <h3>Currency Converter</h3>
                    <form method="post">

                        <div class="row mt-3">
                            <div class="form-floating  col-md-4">
                            <label for="floatingInput">Amount</label>
                                <input type="text" class="form-control" name="amount" id="floatingInput" placeholder="Enter Amount" value="<?= $amount ?>">
                            
                                <small class="text-danger"><?= $amountErr ?></small>
                            </div>


                            <div class="form-floating  col-md-4">
                                <label for="floatingSelect">From</label>
                                <select class="form-control" id="floatingSelect" name="from" aria-label="Floating label select example">
                                <?php
                        $currencies = get_all_currency($mysqli);
                            while ($currency = $currencies->fetch_assoc()) { 
                                if(isset($from) && $from==$currency['currency_code']){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                } ?>
                                <option value="<?= $currency['currency_code'] ?>"  <?= $selected ?>>
                                    <?= $currency['currency_name'] ?>
                                </option>
                        <?php  } ?>
                                </select>
                                
                                <small class="text-danger"><?= $fromErr ?></small>
                            </div>
                            <div class="form-floating col-md-4">
                                 <label for="floatingSelect">To</label>
                                <select class="form-control" id="floatingSelect" name="to" aria-label="Floating label select example">
                                <?php
                      $currencies = get_all_currency($mysqli);
                            while ($currency = $currencies->fetch_assoc()) { 
                                if(isset($to) && $to==$currency['currency_code']){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }  ?>
                            <option value="<?= $currency['currency_code'] ?>"  <?= $selected ?>>
                                <?= $currency['currency_name'] ?>
                            </option>
                        <?php  } ?>

                                </select>
                               
                                <small class="text-danger"><?= $toErr ?></small>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <?php if (isset($rate)) { ?>
                                <div class="para col-md-6 mt-4">
                                    <p class="para-mid"><?= number_format($amount) ?> <?= $rate['buy_currency_name'] ?> = <?php $result = $rate['buy_rate'] * $amount;
                                                                                                                            echo number_format($result); ?> <?= $rate['sell_currency_name'] ?></p>
                                    <p class="para-small">1 <img src="./assets/flag/<?= $rate['buy_flag'] ?>" width="25px" height="25px"> = <?= $rate['buy_rate'] ?> <img src="./assets/flag/<?= $rate['sell_flag'] ?>" width="25px" height="25px"></p>
                                    <p class="para-small">1 <img src="./assets/flag/<?= $rate['sell_flag'] ?>" width="25px" height="25px"> = <?= $rate['buy_rate'] ?> <img src="./assets/flag/<?= $rate['buy_flag'] ?>" width="25px" height="25px"></p>
                                </div>
                            <?php } else { ?>
                                <div class="para col-md-6 mt-4" style="height: 165px;"></div>
                            <?php } ?>


                            <div class="form-group mb-3 col-md-6">
                                <button type="submit" name="submit" class="btn_converter">
                                    CONVERT
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div> <!-- first section wrapper -->

        <div class="fh5co-advantages-outer" id="about">
            <div class="container">
                <div class="col-sm-3">
                    <h1 style="font-weight:900;">Service</h1>
                </div>
                <div class="row fh5co-advantages-grid-columns wow animated fadeIn" data-wow-delay="0.36s">
                    <div class="col-sm-4">
                        <img class="grid-image" src="./assets_for_index/img/icon-1.png" alt="Icon-1">
                        <h1 class="grid-title">Usability</h1>
                        <p class="grid-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem cupiditate.</p>
                    </div>

                    <div class="col-sm-4">
                        <img class="grid-image" src="./assets_for_index/img/icon-2.png" alt="Icon-2">
                        <h1 class="grid-title">Parallax Effect</h1>
                        <p class="grid-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem cupiditate.</p>
                    </div>

                    <div class="col-sm-4">
                        <img class="grid-image" src="./assets_for_index/img/icon-3.png" alt="Icon-3">
                        <h1 class="grid-title">Unlimited Colors</h1>
                        <p class="grid-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem cupiditate.</p>
                    </div>


                </div>
            </div>
        </div>

        <div class="container">

        </div>

        <footer class="footer-outer">
            <div class="container footer-inner">

                <div class="footer-three-grid wow fadeIn animated" data-wow-delay="0.66s">
                    <div class="column-1-3">
                        <h1>Currency Counter</h1>
                    </div>
                    <div class="column-2-3">
                        <nav class="footer-nav">
                            <ul>
                                <a href="#" onclick="$('#fh5co-hero-wrapper').goTo();return false;">
                                    <li>Home</li>
                                </a>
                                <a href="#" onclick="$('#fh5co-features').goTo();return false;">
                                    <li>Login For Admins</li>
                                </a>
                            </ul>
                        </nav>
                    </div>
                    <div class="column-3-3">
                        <div class="social-icons-footer">
                            <a href="https://www.facebook.com/fh5co"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://freehtml5.co"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.twitter.com/fh5co"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <span class="border-bottom-footer"></span>

            </div>
        </footer>

    </div> <!-- main page wrapper -->

    <script src="./assets_for_index/js/jquery.min.js"></script>
    <script src="./assets_for_index/js/bootstrap.js"></script>
    <script src="./assets_for_index/js/owl.carousel.js"></script>
    <script src="./assets_for_index/js/wow.min.js"></script>
    <script src="./assets_for_index/js/main.js"></script>
</body>

</html>