<?php require_once '../layout/header.php' ?>
<!-- ======= Header ======= -->
<?php require_once '../layout/nav.php' 
?>
<!-- End Header -->
<!-- ======= Sidebar ======= -->
<?php require_once '../layout/sidebar.php' 
?>
<!-- End Sidebar-->
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php');


$sale = "All sales";
$invalid = false;
$counter_id  =  $counter_idErr = "";
$date = $dateErr = "";
$total_sales = total_sale_admin($mysqli);
$total_customer = total_tradeCustomer($mysqli);
$customer = "All Customer";

if (isset($_POST['submit'])) {
  $counter_id = $_POST['counter_id'];
  $counter_name = get_counter_id($mysqli, $counter_id);
  $date = $_POST['date'];

  if ($counter_id == "" && $date == "") {
    $invalid = true;
  }
  if($counter_name == NULL){
    $invalid = true;
  }

  if (!$invalid) {
    if ($counter_id == 0 && $date == 0) {
      $total_sales = total_sale_admin($mysqli);
      $sale = "All sales";
    } else if ($counter_id != 0 && $date == 1) {
      $total_sales = total_sale_admin_today_filter_counter($mysqli, $counter_id);
      $sale =  $counter_name['counter_name'] . "'s Today Sales";
    } else if ($counter_id != 0 && $date == 2) {
      $total_sales = total_sale_admin_month_filter_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name'] . "'s This Month Sales";
    } else if ($counter_id != 0 && $date == 3) {
      $total_sales = total_sale_admin_year_filter_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name'] . "'s This Year Sales";
    } else if ($counter_id == 0 && $date == 1) {
      $total_sales = total_sale_admin_today($mysqli);
      $sale = "All sales of Today";
    } else if ($counter_id == 0 && $date == 2) {
      $total_sales = total_sale_admin_month($mysqli);
      $sale =  "All sales of This Month";
    } else if ($counter_id == 0 && $date == 3) {
      $total_sales = total_sale_admin_year($mysqli);
      $sale =  "All sales of This Year";
    } else if ($counter_id != 0 && $date == 0) {
      $total_sales = total_sale_from_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name'] . "'s All Sales";
    } else {
      $total_sales = total_sale_admin($mysqli);
      $sale = "All sales of Today";
    }
  }
}

if (isset($_POST['customer_filter'])) {
  $counter_id = $_POST['counter_id'];
  $counter_name = get_counter_id($mysqli, $counter_id);
  $date = $_POST['date'];

  if ($counter_id == "" && $date == "") {
    $invalid = true;
  }
  if($counter_name == NULL){
    $invalid = true;
  }
  if ($counter_id == 0 && $date == 0) {
    $total_customer = total_tradeCustomer($mysqli);
    $customer = "All Customer";
  } else if ($counter_id != 0 && $date == 1) {
    $total_customer = total_trade_customer_with_today($mysqli, $counter_id);
    $customer = $counter_name['counter_name']. "'s Today Sales";
  } else if ($counter_id != 0 && $date == 2) {
    $total_customer = total_trade_customer_with_month($mysqli, $counter_id);
    $customer = $counter_name['counter_name'] . "'s This Month Sales";
  } else if ($counter_id != 0 && $date == 3) {
    $total_customer = total_trade_customer_with_year($mysqli, $counter_id);
    $customer = $counter_name['counter_name'] . "'s This Year Sales";
  } else if ($counter_id == 0 && $date == 1) {
    $total_customer = total_tradeCustomer_today($mysqli);
    $customer = "All Customer of Today";
  } else if ($counter_id == 0 && $date == 2) {
    $total_customer = total_tradeCustomer_month($mysqli);
    $customer = "All Customer of This Month";
  } else if ($counter_id == 0 && $date == 3) {
    $total_customer = total_tradeCustomer_year($mysqli);
    $customer = "All Customer of This Year";
  } else if ($counter_id != 0 && $date == 0) {
    $total_customer = total_tradeCustomer_alltime($mysqli, $counter_id);
    $customer = $counter_name['counter_name'] . "'s All Sales";
  } else {
    $customer = "All Customer of Today";
  }
}


$sell_rate_label = "All Trades";
$sell_rate_show = "0";
$sell_currency_code = "";
if(isset($_POST['sell_filter'])){
  $counter_id = $_POST['counter_id'];
  $counter_name = get_counter_id($mysqli, $counter_id);
  $date = $_POST['date'];
  $sell_currency_code = $_POST['sell_currency_code'];

  if ($counter_id == "" && $date == "") {
    $invalid = true;
  }
  if($date == NULL){
    $invalid = true;
  }

  if (!$invalid) {
    if($counter_id == 0 && $date == 0 && $sell_currency_code != "") {
      $sell_rate = total_amount_of_sell_currency($mysqli,  $sell_currency_code);
    } else if($counter_id != 0 && $date == 1 && $sell_currency_code != ""){
      $sell_rate = total_amount_of_sell_currency_today($mysqli, $counter_id, $sell_currency_code);
    } else if($counter_id != 0 && $date == 2){
      $sell_rate = total_amount_of_sell_currency_month($mysqli, $counter_id, $sell_currency_code);
    } else if($counter_id != 0 && $date == 3){
      $sell_rate = total_amount_of_sell_currency_year($mysqli, $counter_id, $sell_currency_code);
    } else if($counter_id == 0 && $date == 1){
      $sell_rate = total_amount_of_sell_currencyToday($mysqli, $sell_currency_code);
    } else if($counter_id == 0 && $date == 2){
      $sell_rate = total_amount_of_sell_currencyMonth($mysqli, $sell_currency_code);
    } else if($counter_id == 0 && $date == 3){
      $sell_rate = total_amount_of_sell_currencyYear($mysqli, $sell_currency_code);
    } else if($counter_id != 0 && $date == 0){
      $sell_rate = toal_amount_of_sell_currency_counter($mysqli, $counter_id, $sell_currency_code);
    } else if($counter_id == 0 && $date == 0 && $sell_currency_code != ""){
      $sell_rate = toal_amount_of_sell_currency_alltime($mysqli, $sell_currency_code);
    } else {
      $invalid = true;
    }
  }

}

$buy_rate_label = "All Trades";
$buy_rate_show = "0";
$buy_currency_code = "";
if(isset($_POST['buy_filter'])){
  $counter_id = $_POST['counter_id'];
  $counter_name = get_counter_id($mysqli, $counter_id);
  $date = $_POST['date'];
  $buy_currency_code = $_POST['buy_currency_code'];

  if ($counter_id == "" && $date == "") {
    $invalid = true;
  }

  if (!$invalid) {
    if($counter_id == 0 && $date == 0 && $buy_currency_code != "") {
      $buy_rate = total_amount_of_buy_currency($mysqli,  $buy_currency_code);
    } else if($counter_id != 0 && $date == 1 && $buy_currency_code != ""){
      $buy_rate = total_amount_of_buy_currency_today($mysqli, $counter_id, $buy_currency_code);
      echo "Hello";
    } else if($counter_id != 0 && $date == 2){
      $buy_rate = total_amount_of_buy_currency_month($mysqli, $counter_id, $buy_currency_code);
    } else if($counter_id != 0 && $date == 3){
      $buy_rate = total_amount_of_buy_currency_year($mysqli, $counter_id, $buy_currency_code);
    } else if($counter_id == 0 && $date == 1){
      $buy_rate = total_amount_of_buy_currencyToday($mysqli, $buy_currency_code);
    } else if($counter_id == 0 && $date == 2){
      $buy_rate = total_amount_of_buy_currencyMonth($mysqli, $buy_currency_code);
    } else if($counter_id == 0 && $date == 3){
      $buy_rate = total_amount_of_buy_currencyYear($mysqli, $buy_currency_code);
    } else if($counter_id != 0 && $date == 0){
      $buy_rate = toal_amount_of_buy_currency_counter($mysqli, $counter_id, $buy_currency_code);
    } else if($counter_id == 0 && $date == 0 && $buy_currency_code != ""){
      $buy_rate = toal_amount_of_buy_currency_alltime($mysqli, $buy_currency_code);
    } else {
      $invalid = true;
    }
  }

}


?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>

  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-10">
        <div class="row">
          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card" style="background-color: #9ef01a;">

              <div class="filter ">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-filter"></i></i></a>
                <form method="post">
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow p-2 rounded-4" style="background-color: #012970;">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <form method="post">

                      <div class="form-group mb-2">
                        <select name="counter_id" class="form-control">
                          <option value="0" select>All Sales</option>
                          <?php
                          $counters = get_counter($mysqli);
                          while ($counter = $counters->fetch_assoc()) {  ?>
                            <option value="<?= $counter['id'] ?>"><?= $counter['counter_name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group mb-2">
                        <select name="date" class="form-control">
                          <option value="0" select>All time</option>
                          <option value="1">Today</option>
                          <option value="2">This Month</option>
                          <option value="3">This Year</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn" style="background-color: #caf0f8;" name="submit">Filter</button>
                      </div>

                    </form>

                  </ul>
                </form>
              </div>

              <div class="card-body">
                <h5 class="card-title">Sales <span>| <?= $sale ?></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo  $total_sales['sales'] ?></h6>
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card" style="background-color: #83c5be;">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-filter"></i></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow rounded-4 p-2" style="background-color: #012970;">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <form method="post">

                    <div class="form-group mb-2">
                      <select name="counter_id" class="form-control">
                        <option value="0" select>All Counter</option>
                        <?php
                        $counters = get_counter($mysqli);
                        while ($counter = $counters->fetch_assoc()) {  ?>
                          <option value="<?= $counter['id'] ?>"> <?= $counter['counter_name'] ?> </option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-2">
                      <select name="sell_currency_code" class="form-control">
                        <?php
                        $currencies = get_sell_name_code($mysqli);
                        while ($currency = $currencies->fetch_assoc()) {  ?>
                          <option value="<?= $currency['sell_currency_code'] ?>"><?= $currency['sell_currency_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-2">
                      <select name="date" class="form-control">
                        <option value="0" select>All time</option>
                        <option value="1">Today</option>
                        <option value="2">This Month</option>
                        <option value="3">This Year</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn" style="background-color: #caf0f8;" name="sell_filter">Filter</button>
                    </div>

                  </form>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Sell Rate <span>| <?= $sell_rate_label ?></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php if(!isset($sell_rate['sell_rate'])){
                    echo $sell_rate_show." ".$sell_currency_code;
                    } else {
                      echo number_format($sell_rate['sell_rate']); echo " ".$sell_currency_code;
                    }  ?></h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-6">
            <?php
            $user_email = $user['email'];
            ?>
            <div class="card info-card customers-card" style="background-color: #ffe6a7;">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-filter"></i></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow rounded-4 p-2" style="background-color: #012970;">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <form method="post">

                    <div class="form-group mb-2">
                      <select name="counter_id" class="form-control">
                        <option value="0" select>All Customer</option>
                        <?php
                        $counters = get_counter($mysqli);
                        while ($counter = $counters->fetch_assoc()) {  ?>
                          <option value="<?= $counter['id'] ?>"><?= $counter['counter_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-2">
                      <select name="date" class="form-control">
                        <option value="0" select>All time</option>
                        <option value="1">Today</option>
                        <option value="2">This Month</option>
                        <option value="3">This Year</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn" style="background-color: #caf0f8;" name="customer_filter">Filter</button>
                    </div>

                  </form>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Customers <span>| <?php $customer = "All Customer";
                                                          echo $customer ?> </span> </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $total_customer['customer_count'] ?></h6>
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customerps Card -->

          
          <!-- buy Rate Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card" style="background-color: #fec5bb ;">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-filter"></i></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow rounded-4 p-2" style="background-color: #012970;">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <form method="post">

                    <div class="form-group mb-2">
                      <select name="counter_id" class="form-control">
                        <option value="0" select>All Counter</option>
                        <?php
                        $counters = get_counter($mysqli);
                        while ($counter = $counters->fetch_assoc()) {  ?>
                          <option value="<?= $counter['id'] ?>"> <?= $counter['counter_name'] ?> </option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-2">
                      <select name="buy_currency_code" class="form-control">
                        <?php
                        $currencies = get_buy_name_code($mysqli);
                        while ($currency = $currencies->fetch_assoc()) {  ?>
                          <option value="<?= $currency['buy_currency_code'] ?>"><?= $currency['buy_currency_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-2">
                      <select name="date" class="form-control">
                        <option value="0" select>All time</option>
                        <option value="1">Today</option>
                        <option value="2">This Month</option>
                        <option value="3">This Year</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn" style="background-color: #caf0f8;" name="buy_filter">Filter</button>
                    </div>

                  </form>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Buy Rate <span>| <?= $buy_rate_label ?></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-hand-holding-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php if(!isset($buy_rate['buy_rate'])){
                    echo $buy_rate_show." ".$buy_currency_code;
                    } else {
                      echo number_format($buy_rate['buy_rate']); echo " ".$buy_currency_code;
                    }  ?></h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End buy rate Card -->

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php require_once '../layout/footer.php' ?>
<!-- End footer-->