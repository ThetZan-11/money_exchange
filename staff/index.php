<?php require_once '../layout/header.php' ?>
 <!-- ======= Header ======= -->
<?php require_once '../layout/nav.php' ?>
<!-- End Header -->
<!-- ======= Sidebar ======= -->
<?php require_once '../layout/sidebar.php' ?>
<!-- End Sidebar-->
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php');
  $user_email = $user['email'];
  $customer = "Today";
  $sale   = "Today";

  if(isset($_SESSION['date'])){
    $date_compare = $_SESSION['date'];
}
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <form method="post">
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
                      <li><button class="dropdown-item" name="today_sale">Today</button></li>
                      <li><button class="dropdown-item" name="month_sale">This Month</button></li>
                      <li><button class="dropdown-item" name="year_sale">This Year</button></li>
                    </ul>
                  </form>
                </div>

                <div class="card-body">
                <?php   
                        if(isset($_POST['month_sale'])){
                          $sale_count = total_sale_counter_month_filter($mysqli, $user_email,  $date_compare['from_date'], $date_compare['to_date']);
                          $sale = "This Month";
                        } else if(isset($_POST['today_sale'])){
                          $sale_count = total_sale_counter_today_filter($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                        } else if(isset($_POST['year_sale'])){
                          $sale_count = total_sale_counter_year_filter($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                          $sale = "This Year";
                        } else {
                          $sale_count = total_sale_counter_today_filter($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                        }
                  ?>
                  <h5 class="card-title">Sales <span>| <?= $sale ?></span></h5>
                  
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $sale_count['sale_count'] ?></h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
          

            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-6">
             
              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <form method="post">
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><button class="dropdown-item" name="today_customer">Today</button></li>
                      <li><button class="dropdown-item" name="month_customer">This Month</button></li>
                      <li><button class="dropdown-item" name="year_customer">This Year</button></li>
                    </ul>
                  </form>
                </div>

                <div class="card-body">
                <?php 
                      if(isset($_POST['month_customer'])){
                        $customer_count = customer_count_from_counter_month($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                        $customer = "This Month"; 
                      } else if(isset($_POST['today_customer'])){
                        $customer_count = customer_count_from_counter_today($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                      } else if(isset($_POST['year_customer'])){
                        $customer_count = customer_count_from_counter_year($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                        $customer = "This Year";
                      } else {
                        $customer_count = customer_count_from_counter_today($mysqli, $user_email, $date_compare['from_date'], $date_compare['to_date']);
                      } 
                    ?>
                  <h5 class="card-title">Customers <span>| <?= $customer ?></span></h5>
                 
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $customer_count['customer_count'] ?></h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php require_once '../layout/footer.php' ?>
<?php get_exchange_rate($mysqli); ?>
<!-- End footer-->
