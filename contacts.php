<?php 
include('core/config.php');
include('core/db.php');
include('core/functions.php');
?>

<!-- Page Title--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Contacts</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">

      <!--Sweet Alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://sweetalert2.all.min.js"></script>
    
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css2?family=Darker+Grotesque:wght@300;400;500;700;900&amp;display=swap">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <?php

    if(isset($_POST["submit"])){
      
      $subject = "New Contact";
      $subject2 = "[CONFIRMATION] Message was submitted successfully."; // for customer confirmation
      $body= "";
      $emailMyself = false;
      $emailUser = false;

      if(isset($_POST['email'])){// Validate customer email
        $clientEmail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        if(!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)){
          wrongCredential("Please input your Email.");
        }
    }

      if(isset($_POST['name'])){// Validate Customer name
        $name = $_POST['name'] . " " . $_POST['sec-name'];
        if(isBlankField($name) || preg_match('~[0-9]~',$name)){
          wrongCredential("Please input your name.");
        }
      }

      if(isset($_POST['phone'])){ //Validate Cust Phone
        $phone = $_POST['phone'];
        if(isBlankField($phone))
        {
          wrongCredential("Please input your phone.");
        }
      }

      if(isset($_POST['message'])){ //Check cust message input
        $clientMessage = $_POST['message'];
        if(isBlankField($clientMessage)){
          wrongCredential("Please input your message.");
        }
      }

      $message2 = "Dear " . $name . ", \n\n"
      . "Thank you for contacting us! We will get back to you shortly!" . "\n\n"
      . "You have submitted the following message: " . "\n" . $clientMessage . "\n\n"
      . "Regards," . "\n" . "J.A.B Ink Studio" . "\n"
      ."(+65) 6123–4567, (+65) 6765-4321";

      $mailto = "jabsinks@gmail.com"; // my email address

      // Email body I will receive
      $body .= "From: ".$name. "\r\n";
      $body .= "Email: ".$clientEmail. "\r\n";
      $body .= "Phone: ".$phone. "\r\n";
      $body .= "Message: ".$clientMessage. "\r\n";

      $emailMyself = mail($mailto,$subject,$body); //Message send to me
      $emailUser = mail($clientEmail, $subject2, $message2); //Message to User
    }
    ?>

    <div class="preloader">
      <div class="preloader-body"> 
        <div class="cssload-jumping"><span></span><span></span><span></span><span></span><span></span></div>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
            <div class="rd-navbar-aside-outer rd-navbar-collapse">
              <div class="rd-navbar-aside">
                <?php include 'templates/navbar-header-info.php'; ?>
              </div>
            </div>
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo-black-260x82.png" alt="" width="130" height="41"/><img class="brand-logo-inverse" src="images/logo-white-260x82.png" alt="" width="130" height="41"/></a></div>
                </div>
                <div class="rd-navbar-main-element">
                  <div class="rd-navbar-nav-wrap">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item"><a class="rd-nav-link" href="index.php">Home</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="our-team.php">About</a>
                        <!-- RD Navbar Dropdown -->
                        <ul class="rd-menu rd-navbar-dropdown">
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="our-team.php">Our Team</a></li>
                        </ul>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="services.php">Services</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="portfolio.php">Portfolio</a>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="appointment.php">Appointment</a>
                      </li>
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="contacts.php">Contacts</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <section class="section-page-title context-dark" style="background-image: url(images/page-title-1920x427.jpg); background-size: cover;">
        <div class="container">
          <h1 class="page-title">Contacts</h1>
        </div>
      </section>
      <section class="breadcrumbs-custom">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Contacts</li>
          </ul>
        </div>
      </section>
      <!-- Mailform-->
      <section class="section section-md">
        <div class="container">
          <div class="row row-50">
            <div class="col-lg-8">
              <h2>Contact us</h2>
              <p>You can contact us any way that is convenient for you. We are available 24/7 via fax or email. <br class="d-none d-lg-inline">You can also use a quick contact form below or visit our studio personally.</p>
              <!-- Contact Mailform-->
              <form class="rd-mailform text-left rd-form" data-form-output="form-output-global" data-form-type="contact" method="POST" action="contacts.php">
                <div class="row row-15 row-gutters-16">
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-name">First name</label>
                      <input class="form-input" id="contact-name" type="text" name="name">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-sec-name">Last name</label>
                      <input class="form-input" id="contact-sec-name" type="text" name="sec-name">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-phone">Phone</label>
                      <input class="form-input" id="contact-phone" type="text" name="phone">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-email">E-Mail</label>
                      <input class="form-input" id="contact-email" type="email" name="email">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-message">Message</label>
                      <textarea class="form-input" id="contact-message" name="message" ></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-button group-sm text-left">
                  <button class="button button-primary" name="submit" type="submit">Send message</button>
                </div>
              </form>
            </div>
            <div class="col-lg-4">
              <ul class="contact-list">
                <li> 
                  <p class="contact-list-title">Address</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-map-marker icon-primary"></span><a href="https://goo.gl/maps/oemfresz1gSRg39w8">545 Orchard Road Singapore 238882</a></div>
                </li>
                <li>
                  <p class="contact-list-title">Phones</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-phone icon-primary"></span><a href="tel:6123–4567">(+65) 6123–4567</a><span>, </span><a href="tel:#">(+65) 6765-4321 </a></div>
                </li>
                <li>
                  <p class="contact-list-title">E-mail</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-email-outline icon-primary"></span><a href="mailto:jabsinks@gmail.com">jabsinks@gmail.com</a></div>
                </li>
                <li>
                  <p class="contact-list-title">Opening Hours</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-clock icon-primary"></span>
                    <ul class="list-xs">
                      <li>Mon-Fri: 10 am – 8 pm</li>
                      <li>Saturday: 10 am – 6 pm</li>
                      <li>Sunday: Closed</li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      </section> -->
      <footer class="section bg-default section-xs-type-1 footer-minimal">
        <div class="container">
          <div class="row row-30 align-items-lg-center justify-content-lg-between">
            <div class="col-lg-10">
              <div class="footer-nav">
                <ul class="rd-navbar-nav">
                  <li class="rd-nav-item"><a class="rd-nav-link" href="index.php">Home</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="overview.php">About</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="services.php">Services</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="portfolio.php">Portfolio</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="appointment.php">Appointment</a></li>
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <?php include 'templates/footer-brand.php'; ?>
    </div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>