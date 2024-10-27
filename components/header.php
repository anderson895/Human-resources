<?php 
include 'conn/conn.php';
$db = new DatabaseHandler();
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
         <title>OpenCifra </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/logo.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<!-- CSS here -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
            <link rel="stylesheet" href="assets/css/price_rangs.css">
            <link rel="stylesheet" href="assets/css/flaticon.css">
            <link rel="stylesheet" href="assets/css/slicknav.css">
            <link rel="stylesheet" href="assets/css/animate.min.css">
            <link rel="stylesheet" href="assets/css/magnific-popup.css">
            <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="assets/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/slick.css">
            <link rel="stylesheet" href="assets/css/nice-select.css">
            <link rel="stylesheet" href="assets/css/style.css">
   </head>
<style>
    .header-sticky {
    z-index: 1000; /* Or another lower value */
}

.modal {
    z-index: 1050; /* Ensure this is higher than .header-sticky */
}

.bg-green{
    background-color: #256f3f!important;
}

.text-green{
    color: #256f3f!important;
    font-weight: 700!important;
}


</style>
   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="downloaded_assets/logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
       <div class="header-area header-transparrent">
           <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center ">
                        <div class="col-lg-3 col-md-2">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="index.php"><img width="130px" src="assets/img/logo/logo.png" alt=""></a>
                            </div>  
                        </div>
                        <div class="col-lg-9 col-md-9 ">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                        <li><a class="text-green" href="index.php">HOME</a></li>
                                        <li><a class="text-green" href="index.php#about">ABOUT</a></li>
                                        <li><a class="text-green" href="find_job.php">FIND A JOB</a></li>
                                        <li><a class="text-green" href="index.php#contact">CONTACT US</a></li>
                                        
                                        <li class="d-lg-none " data-bs-toggle="modal" data-bs-target="#staticBackdrop"><a  class="text-green" href="#">LOGIN</a></li>
                                        <!-- <a href="#" class="btn py-4 head-btn1">Register</a> -->
                                       
                                    </nav>
                                </div>          
                                <!-- Header-btn -->
                                <div class="header-btn d-none f-right d-lg-block">
                                    <!-- <a href="#" class="btn head-btn1">Register</a> -->
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  class="btn head-btn1 bg-green">Login</a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                                <ul>
                                <div class="mobile_menu d-block d-lg-none">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
        <!-- Header End -->
    </header>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-1" id="staticBackdropLabel">Login</h3>
      </div>
      <div class="modal-body">
        <!-- Login Form -->
        <form id="loginForm">
          <div class="mb-3">
            <label for="emailInput" class="form-label">Email address</label>
            <input value="admin@gmail.com" type="email" class="form-control" name="email_Login" id="email_Login" placeholder="Enter your email">
          </div>
          <div class="mb-3">
            <label for="passwordInput" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" value="admin@gmail.com" name="password_Login" class="form-control" id="password_Login" required autocomplete="off">
                <div class="input-group-append">
                    <button type="button" class="input-group-text" id="toggleNewPassword">
                        <i class="material-icons">visibility</i>
                    </button>
                </div>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <a href="#" class="text-dark" id="forgot">Forgot Password?</a>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn head-btn2" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn loginBtn head-btn1">Login</button>
      </div>
    </div>
  </div>
</div>



<style>
    /* Chatbot Icon Style */
.chatbot-icon {
    position: fixed;
    bottom: 20px;
    right: 100px;
    cursor: pointer;
    z-index: 1000; /* Make sure it stays on top of other elements */
}

.chatbot-icon img {
    width: 60px; /* Adjust size as needed */
    height: auto;
}

/* Chatbot Popup Style */
.chatbot-popup {
    display: none; /* Initially hidden */
    position: fixed;
    bottom: 100px; /* Adjust based on icon size */
    right: 20px;
    width: 300px; /* Adjust size as needed */
    height: 400px; /* Adjust size as needed */
    border: 1px solid #ddd;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* Make sure it stays on top of other elements */
}

.chatbot-popup iframe {
    width: 100%;
    height: 100%;
    border: none;
}

#close-chatbot {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #f00;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

</style>