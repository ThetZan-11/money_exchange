<?php require_once '../layout/header.php' ?>
 <!-- ======= Header ======= -->
<?php require_once '../layout/nav.php' ?>
<!-- End Header -->
<!-- ======= Sidebar ======= -->
<?php require_once '../layout/sidebar.php' ?>
<!-- End Sidebar-->
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php');
//   $user_email = $user['email'];
//   $customer = "Today";
//   $sale   = "Today";

//   if(isset($_SESSION['date'])){
//     $date_compare = $_SESSION['date'];
// }
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php require_once '../layout/footer.php' ?>
<?php get_exchange_rate($mysqli); ?>
<!-- End footer-->
