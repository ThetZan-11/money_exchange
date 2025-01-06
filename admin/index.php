<?php require_once '../layout/header.php' ?>
<!-- ======= Header ======= -->
<?php //require_once '../layout/nav.php' 
?>
<!-- End Header -->
<!-- ======= Sidebar ======= -->
<?php //require_once '../layout/sidebar.php' 
?>
<!-- End Sidebar-->
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php');

$customer = "Today";
$sale = "All sales";
$invalid = false; 
$counter_id  =  $counter_idErr = "";
$date = $dateErr = "";  
$total_sales = total_sale_admin($mysqli);


if(isset($_POST['submit'])){
  $counter_id = $_POST['counter_id'];
  $counter_name = get_counter_id($mysqli, $counter_id);
  $date = $_POST['date'];

  if($counter_id == "" && $date == ""){
    $invalid = true;
    $counter_idErr = "Choose one";
    $dateErr = "Choose one";
  }
  // var_dump($counter_id,$date);
  if(!$invalid){
    if($counter_id == 0 && $date == 0){
      $total_sales = total_sale_admin($mysqli);
      $sale = "All sales";
      
    } else if($counter_id != 0 && $date == 1 ){
      $total_sales = total_sale_admin_today_filter_counter($mysqli, $counter_id);
      $sale =  $counter_name['counter_name']."'s Today Sales";
    } else if ($counter_id != 0 && $date == 2){
      $total_sales = total_sale_admin_month_filter_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name']."'s This Month Sales";
    } else if ($counter_id != 0 && $date == 3){
      $total_sales = total_sale_admin_year_filter_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name']."'s This Year Sales";
    } else if ($counter_id == 0 && $date == 1){
      $total_sales = total_sale_admin_today($mysqli);
      $sale = "All sales of Today";
    } else if ($counter_id == 0 && $date == 2){
      $total_sales = total_sale_admin_month($mysqli);
      $sale =  "All sales of This Month";
    } else if ($counter_id == 0 && $date == 3){
      $total_sales = total_sale_admin_year($mysqli);
      $sale =  "All sales of This Year";
    } else if($counter_id != 0 && $date == 0 ){
      $total_sales = total_sale_from_counter($mysqli, $counter_id);
      $sale = $counter_name['counter_name']."'s All Sales";
    } else {
      $total_sales = total_sale_admin($mysqli);
      $sale = "All sales of Today";
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
      <div class="col-lg-8">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="filter ">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <form method="post" >
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
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Revenue <span>| This Month</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>$3,264</h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">
            <?php
            $user_email = $user['email'];
            //$customer_count = customer_count_from_counter($mysqli, $user_email) 
            ?>
            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Customers <span>| This Year</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>Hello</h6>
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->

          <!-- Top Selling -->
          <div class="col-12">
            <div class="card top-selling overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body pb-0">
                <h5 class="card-title">Top Selling <span>| Today</span></h5>

                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Preview</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col">Sold</th>
                      <th scope="col">Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                      <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                      <td>$64</td>
                      <td class="fw-bold">124</td>
                      <td>$5,828</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                      <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                      <td>$46</td>
                      <td class="fw-bold">98</td>
                      <td>$4,508</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                      <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                      <td>$59</td>
                      <td class="fw-bold">74</td>
                      <td>$4,366</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                      <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                      <td>$32</td>
                      <td class="fw-bold">63</td>
                      <td>$2,016</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                      <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                      <td>$79</td>
                      <td class="fw-bold">41</td>
                      <td>$3,239</td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Top Selling -->

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php require_once '../layout/footer.php' ?>
<!-- End footer-->