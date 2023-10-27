<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
    .grid-container {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      /* Example: Three equal columns */
      grid-gap: 10px;
      /* Gap between grid items */
    }

    .grid-item {

      padding: 10px;
      text-align: center;
    }

    .right-align {
      justify-self: end;
      /* This aligns the item to the right within the grid cell */
    }
  </style>
</head>

<body style="background-color: white;">

  <main>
    <div class="container" style="background-color: white; background-image:url('assets/img/bg.png'); margin-left: -100px; ">

      <section class="section register ">
        <div class="container ">
          <div class="grid-container">
            <div class="grid-item">
              <br />
              <label class="form-label" style="color: white; font-weight: margin-left:200px ; 600; font-size: 18px;">monodome</label> <br />
              <label class="form-label" style="color: white; font-size: 11px; font-family: Poppins; font-style: normal; margin-top: -7px;">Admin
                Panel</label><br> <br><br> <br><br><br> <br> <br><br><br> <br>
              <br> <br><br> <br><br><br> <br> <br><br><br> <br><br> <br><br> <br><br><br> <br> <br><br><br> <br><br>
              <br><br> <br><br><br> <br> <br><br><br> <br><br> <br><br> <br><br><br> <br> <br><br><br> <br>
            </div>

            <div class="grid-item right-align" style="margin-right: -500px;"><img src="assets/img/agentellipsemob.png" height="250px" />
              <form id="signin_form" role="form">


                <div class="col-12">
                  <label for="yourUsername" class="form" style="margin-right:400px;">Username</label>
                  <div class="input-group has-validation">

                    <input type="text" value="admin" name="username" class="form-control" id="username" required>
                    <div class="invalid-feedback">Please enter your username.</div>
                  </div>
                </div>

                <div class="col-12">

                  <label for="yourUsername" class="form" style="margin-right:400px;">Password</label>
                  <input type="password" name="password" value="12345678" class="form-control" id="password" required>
                  <div class="invalid-feedback">Please enter your password!</div>
                  <label for="yourUsername" class="form" style="margin-right:-300px; color: green; font-size: smaller;">Use Phone
                    number</label>
                </div>

                <div class="col-12">

                  <label for="yourUsername" class="form" style="margin-right:400px;">Emai address</label>
                  <input type="email" name="email" class="form-control" id="email" value="lawalthb@gmail.com" required>
                  <div class="invalid-feedback">Please enter your email</div>
                </div>


                <div class="col-12">

                  <label for="yourUsername" class="form" style="margin-right:400px;">OTP-Number</label>
                  <input type="text" name="otp" value="000000" class="form-control" id="otp" required>
                  <div class="invalid-feedback">Please enter your password!</div>
                  <label for="yourUsername" class="form" id="sent_otp_btn" style="margin-right:-300px; color: green;  font-size: smaller;">Send OTP</label>

                  <label for="yourUsername" class="form" id="otp_suc_msg" style="margin-right:-300px; color: green;  font-size: smaller; display: none;">OTP send
                    successfully </label>
                  <label for="yourUsername" class="form" id="otp_err_msg" style="margin-right:-300px; color: red;  font-size: smaller; display: none;">Invalid email
                    address</label>
                  <br />
                  <br />
                </div>

                <div class="col-12">
                  <label for="yourUsername" class="form" id="login_err_msg" style=" color: red;  font-size: smaller; display: none;">Invalid OTP or Password</label>
                  <button class="btn btn-success w-100" type="submit" id="submit_btn">Sign In</button>
                </div>
                <div class="col-12 mt-20">
                  <br /><br />
                  <p class="small mb-0">© 2023 monodome. All rights reserved</a></p>
                </div>
              </form>



            </div>
          </div>

        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  @include('adminpanel.login_js')
</body>

</html>