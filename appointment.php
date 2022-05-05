<?php

  include('core/config.php');
  include('core/db.php');
  include('core/functions.php');

  $artistCount = $isSuccess = "";
  $name = $email = $phone = $message = "";
  $formNameError = $formNamePass = "";
  $formPhoneError = $formPhonePass = "";
  $formEmailError = $formEmailPass= "";
  $formDateError = $formDatePass = "";
  $formArtistError = $formArtistPass = "";
  $formServiceError = $formServicePass = "";
  $formMessageError = $formMessagePass = "";

  if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $serviceOption = $_POST['serviceOption'];
    $artistOption = $_POST['artistOption'];
    $message = $_POST['message'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $dateAlert = date('dS M', strtotime($_POST['date']));

    // Start of validation for the form
    # Check for Name input
    if (empty($name)) {
      $formNameError = true;
    } else {
      $formNamePass = true;
    }

    # Check for Phone input
    if (empty($phone)) {
    $formPhoneError = true;
    } else {
      $formPhonePass = true;
    }

    # Check for E-mail input
    if (empty($email)) {
      $formEmailError = true;
    } else {
      $formEmailPass = true;
    }

    # Check for Date input
    if (empty($date) || $date == "1970-01-01") {
      $formDateError = true;
    } else {
      $formDatePass = true;
    }

    # Check for Service Option input
    if (empty($serviceOption)) {
      $formServiceError = true;
    } else {
      $formServicePass = true;
    }

    # Check for Artist Option input
    if (empty($artistOption)) {
      $formArtistError = true;
    } else {
      $formArtistPass = true;
    }

    # Check for Artist Option input
    if (empty($message)) {
      $formMessageError = true;
    } else {
      $formMessagePass = true;
    }

    if($formNamePass && $formPhonePass && $formEmailPass && $formDatePass && $formServicePass && $formArtistPass && $formMessagePass== true){
      // enquire if email registered before
      $userQuery = DB::query("SELECT * FROM user WHERE userEmail = %s", $email);
      $userCount = DB::count();
      // if there do not have any email registered, insert new user data
      if($userCount == 0){
        DB::startTransaction();
        DB::insert("user", [
          'userName' => $name,
          'userEmail' => $email,
          'userPhone' => $phone
        ]);
        DB::commit();
      } 

      // re-enquire for email registration.
      $userQuery = DB::query("SELECT * FROM user WHERE userEmail = %s", $email);
      foreach($userQuery as $userResult){
        $userID = $userResult['userID'];
      }

      // combine artist and start date as condition
      $where = new WhereClause('and'); 
      $where->add('appointmentArtist=%s', $artistOption);
      $where->add('appointmentStartDate=%t', $date);
      
      // check if artist was booked on the date which customer selected
      $artistQuery = DB::query("SELECT * FROM appointment WHERE %l", $where);
      $artistCount = DB::count();
      
      // if the date do not have the artist, will start register booking
      if($artistCount == 0){
      
        DB::startTransaction();
        DB::insert("appointment", [
          'appointmentStartDate' => $date,
          'appointmentArtist' => $artistOption,
          'appointmentComments' => $message,
          'appointmentService' => $serviceOption,
          'userID' => $userID
        ]);
          
        $newUserID = DB::insertId();
        $isSuccess = DB::affectedRows();
        
        if ($isSuccess) {
            DB::commit();
            // sweetalert to notify customer booking successful
        } else {
            $rollBackError = DB::rollback();
        }
      }
    }
  }
?>

<!-- Page Title--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Make an Appointment</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css2?family=Darker+Grotesque:wght@300;400;500;700;900&amp;display=swap">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body>
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
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a>
                      </li>
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="appointment.php">Appointment</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.php">Contacts</a>
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
          <h1 class="page-title">Make an Appointment</h1>
        </div>
      </section>
      <section class="breadcrumbs-custom">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Make an Appointment</li>
          </ul>
        </div>
      </section>
      <section class="section section-lg bg-default text-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-9 col-xl-7">
              <h2>Make an Appointment</h2>
              <p>The best way to enjoy a treatment at our salon is to book an appointment with the desired tattoo artist. Fill in the form below and we will contact you to discuss your appointment.</p>
            </div>
          </div>
          <div class="row justify-content-center">
            
            <div class="col-md-10 col-xl-8">
              <!-- RD Mailform-->
              <form id="appointment-form" class="text-left" method="post">
                <div class="row row-20 row-gutters-16 justify-content-center">
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-name">Your Name</label>
                      <input class="form-input" id="contact-name" type="text" name="name" value="<?php echo $name; ?>" data-constraints="@Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-email">Your E-mail</label>
                      <input class="form-input" id="contact-email" type="email" name="email" value="<?php echo $email; ?>" data-constraints="@Email @Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-phone">Your Phone</label>
                      <input class="form-input" id="contact-phone" type="text" name="phone" value="<?php echo $phone; ?>" data-constraints="@Numeric @Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <!--Select 2-->
                    <select name="serviceOption" class="form-input select-filter" data-placeholder="Select a service.."  data-constraints="@Required">
                      <option label="1"></option>
                      <option value="Tattooing" <?php if(isset($serviceOption) && $serviceOption == "Tattooing") echo "selected" ?>>Tattooing</option>
                      <option value="Piercing" <?php if(isset($serviceOption) && $serviceOption == "Piercing") echo "selected" ?>>Piercing</option>
                      <option value="Tattoo cover up" <?php if(isset($serviceOption) && $serviceOption == "Tattoo cover up") echo "selected" ?>>Tattoo cover up</option>
                      <option value="Tattoo design" <?php if(isset($serviceOption) && $serviceOption == "Tattoo design") echo "selected" ?>>Tattoo design</option>
                    </select>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="date">Date</label>
                      <input class="form-input" id="date" type="text" name="date" data-time-picker="date" data-constraints="@Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <select name="artistOption" class="form-input select-filter" data-placeholder="Select an artist..."  data-constraints="@Required">
                      <option label="1"></option>
                      <option value="Adrian" <?php if(isset($artistOption) && $artistOption == "Adrian") echo "selected" ?> >Adrian</option>
                      <option value="Barry" <?php if(isset($artistOption) && $artistOption == "Barry") echo "selected" ?>>Barry</option>
                      <option value="Jack" <?php if(isset($artistOption) && $artistOption == "Jack") echo "selected" ?>>Jack</option>
                      <!-- <option value="Peter Adams">Peter Adams</option> -->
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-message">Your comment</label>
                      <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"><?php echo $message ;?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-button group-sm text-center">
                  <button class="button button-primary" name="register" type="submit">make an appointment now</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
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
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="appointment.php">Appointment</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <?php include 'templates/footer-brand.php'; ?>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 


    <?php 
    if($artistCount == 1){
      alert1('info', $artistOption . ' not available on ' . $dateAlert , 'Please choose another date', true, 'false');
    }
    if($isSuccess){
      alertReset('success', 'Successfully booked' , $artistOption . ' on ' . $date , true, 'false');
    }

    if($formDateError == true){
      alert1('error', 'Missing Date' , 'Please select a date', true, 'false');
    }

    if($formMessageError == true){
      alert1('error', 'Missing Message' , 'Please leave us a message for us to serve you better', true, 'false');
    }

    if($formServiceError == true || $formArtistError == true){
      alert1('error', 'Missing Service and/or Artist' , 'Please make selection', true, 'false');
    }

    if($formNameError || $formPhoneError || $formEmailError == true){
      alert1('error', 'Missing Details' , 'Please fill up your contact details', true, 'false');
    }

    ?>

  </body>
</html>