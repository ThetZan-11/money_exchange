<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <section id="header" class="header d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
            </ul>
        </nav><!-- End Icons Navigation -->

    </section>

    <div class="container-fluid">
    <div class="text-white text-center mt-5 mb-3">
            <h1>Exchange Rate</h1>
        </div>

        <div class="card mx-atuo p-5" id="card">


            <form action="post">
                <div class="d-flex justify-content-between gap-3">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" style="width:300px; height:70px;">
                        <label for="amount">Amount</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" list="datalistOptions" style="width:300px; height:70px;">
                        <label for="amount">From</label>
                        <datalist id="datalistOptions">
                            <option value="USD TO Myannmar Kyat">
                        </datalist>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="text" list="datalistOptions" class="form-control" style="width:300px; height:70px;">
                        <label for="amount">To</label>
                        <datalist id="datalistOptions">
                            <option value="USD TO Myannmar Kyat">
                        </datalist>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <div>
                        Currency exchange rate calculate
                    </div>
                    <button class="btn btn-primary">
                        Convert
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>



</body>

</html>