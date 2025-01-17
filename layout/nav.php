<section id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="./index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Currency Exchange</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->
  <?php
  $url = explode('/', $_SERVER['REQUEST_URI']);
  $path = explode('_', $url[3]);
  if ($path[0] == "index.php" ||  isset($_GET['id'])) { ?>
    <div></div>
    <?php  } else { 
     if ($path[1] == 'list.php') { ?>
      <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST">
          <input type="text" name="key" placeholder="Search" title="Enter search keyword">
          <button type="submit" name="search" title="Search"><i class="bi bi-search"></i></button>
        </form>
      </div>
      
    <?php } else { ?>
      <div></div>
    <?php } ?>
  <?php } ?>



  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->


      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="../assets/img/<?= $user['user_img'] ?>" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['name'] ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?= $user['name'] ?></h6>
            <span><?php if ($user['role'] == 1) echo "Admin";
                  else {
                    echo "Staff";
                  } ?> </span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="./user_profile.php?id=<?= $user['id'] ?>">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <form method="post">
              <button class="dropdown-item d-flex align-items-center" name="logout" type="submit">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
                </>
            </form>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</section>