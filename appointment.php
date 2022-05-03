<?php

  include('core/config.php');
  include('core/db.php');
  include('core/functions.php');

  $artistCount = $isSuccess = "";
  $name = $email = $phone = $message = "";

  if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $serviceOption = $_POST['serviceOption'];
    $artistOption = $_POST['artistOption'];
    $message = $_POST['message'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $dateAlert = date('dS M', strtotime($_POST['date']));

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
?>

<!-- Page Title--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Make an Appointment</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <!-- <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
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
                <div class="header-info">
                  <ul class="list-inline list-inline-md">
                    <li>
                      <div class="unit unit-spacing-xs align-items-center">
                        <div class="unit-left">Call Us:</div>
                        <div class="unit-body"><a href="tel:#">(+65) 6123-4567</a></div>
                      </div>
                    </li>
                    <li>
                      <div class="unit unit-spacing-xs align-items-center">
                        <div class="unit-left">Opening Hours:</div>
                        <div class="unit-body"> Mn-Fr: 10am - 8pm</div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="social-block">
                  <ul class="list-inline">
                    <li><a class="icon fa-facebook" href="#"></a></li>
                    <li><a class="icon fa-twitter" href="#"></a></li>
                    <li><a class="icon fa-google-plus" href="#"></a></li>
                    <li><a class="icon fa-vimeo" href="#"></a></li>
                    <li><a class="icon fa-youtube" href="#"></a></li>
                    <li><a class="icon fa-pinterest-p" href="#"></a></li>
                  </ul>
                </div>
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
                          <!-- <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="testimonials.html">Testimonials</a></li> -->
                        </ul>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="services.php">Services</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="portfolio.php">Portfolio</a>
                        <!-- RD Navbar Dropdown
                        <ul class="rd-menu rd-navbar-dropdown">
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="cobbles-gallery.html">Cobbles Gallery</a></li>
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="gallery-without-padding.html">Gallery without padding</a></li>
                        </ul>
                      </li> -->
                      <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a>
                        <!-- RD Navbar Dropdown-->
                        <!-- <ul class="rd-menu rd-navbar-dropdown">
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="blog-post.html">Single Post</a></li>
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="blog-without-sidebar.html">Blog Without Sidebar</a></li>
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="blog-modern.html">Blog Modern</a></li>
                        </ul> -->
                      </li>
                      <!-- <li class="rd-nav-item"><a class="rd-nav-link" href="#">Pages</a>
                        RD Navbar Megamenu
                        <ul class="rd-menu rd-navbar-megamenu">
                          <li class="rd-megamenu-item">
                            <h6 class="rd-megamenu-title">Pages 1</h6>
                            <ul class="rd-megamenu-list">
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="typography.html">Typography</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="buttons.html">Buttons</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="forms.html">Forms</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="tabs-and-accordions.html">Tabs and Accordions</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="grid-system.html">Grid System</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="tables.html">Tables</a></li>
                            </ul>
                          </li>
                          <li class="rd-megamenu-item">
                            <h6 class="rd-megamenu-title">Pages 2</h6>
                            <ul class="rd-megamenu-list">
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="appointment.html">Appointment</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="privacy-policy.html">Privacy policy</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="pricing.html">Pricing</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="careers.html">Careers</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="team-member-profile.html">Team Member Profile</a></li>
                            </ul>
                          </li>
                          <li class="rd-megamenu-item">
                            <h6 class="rd-megamenu-title">Pages 3</h6>
                            <ul class="rd-megamenu-list">
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="login-register.html">Login-Register</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="coming-soon.html">Coming Soon</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="404.html">404</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="search-results.html">Search results</a></li>
                              <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="faq.html">FAQ</a></li>
                            </ul>
                          </li>
                        </ul>
                      </li> -->
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
            <!-- <li><a href="#">Pages</a></li> -->
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
              <form class=" text-left" method="post">
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
                      <option value="Tattooing">Tattooing</option>
                      <option value="Piercing">Piercing</option>
                      <option value="Tattoo cover up">Tattoo cover up</option>
                      <option value="Tattoo design">Tattoo design</option>
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
                      <option value="Adrian">Adrian</option>
                      <option value="Barry">Barry</option>
                      <option value="Jack">Jack</option>
                      <!-- <option value="Peter Adams">Peter Adams</option> -->
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-message">Your comment</label>
                      <textarea class="form-input" id="contact-message" name="message" value="<?php echo $message; ?>" data-constraints="@Required"></textarea>
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
      <!-- Page Footer-->
      <!--Please, add the data attribute data-key="YOUR_API_KEY" in order to insert your own API key for the Google map.-->
      <!--Please note that YOUR_API_KEY should replaced with your key.-->
      <!--Example: <div class="google-map-container" data-key="YOUR_API_KEY">-->
      <!-- <section class="section google-map-container" data-center="9870 St Vincent Place, Glasgow, DC 45 Fr 45." data-zoom="5" data-icon="images/gmap_marker.png" data-icon-active="images/gmap_marker_active.png" data-styles="[{&quot;featureType&quot;:&quot;water&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#e9e9e9&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;landscape&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:29},{&quot;weight&quot;:0.2}]},{&quot;featureType&quot;:&quot;road.arterial&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:18}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;featureType&quot;:&quot;poi&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:21}]},{&quot;featureType&quot;:&quot;poi.park&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#dedede&quot;},{&quot;lightness&quot;:21}]},{&quot;elementType&quot;:&quot;labels.text.stroke&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;on&quot;},{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;elementType&quot;:&quot;labels.text.fill&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:36},{&quot;color&quot;:&quot;#333333&quot;},{&quot;lightness&quot;:40}]},{&quot;elementType&quot;:&quot;labels.icon&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;transit&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f2f2f2&quot;},{&quot;lightness&quot;:19}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:17},{&quot;weight&quot;:1.2}]}]">
        <div class="google-map"></div>
        <ul class="google-map-markers">
          <li data-location="9870 St Vincent Place, Glasgow, DC 45 Fr 45." data-description="9870 St Vincent Place, Glasgow"></li>
        </ul>
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
                  <li class="rd-nav-item"><a class="rd-nav-link" href="gallery-without-padding.php">Portfolio</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a></li>
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="appointment.php">Appointment</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <section class="bg-primary section-xs text-center">
        <div class="container">
          <div class="row row-20 align-items-lg-center">
            <div class="col-md-3 text-md-left">
              <div class="footer-brand"><a href="index.php"><img src="images/logo-white-260x82.png" alt="" width="130" height="41"/></a></div>
            </div>
            <div class="col-md-6">
              <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>All Rights Reserved</span><span>&nbsp;</span><a href="privacy-policy.php">Privacy Policy</a></p>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 


    <?php 
    if($artistCount == 1){
      alert1('info', $artistOption . ' not available on ' . $dateAlert , 'Please choose another date', true, 'false');
    }
    if($isSuccess){
      alert1('success', 'Successfully booked' , $artistOption . ' on ' . $date , true, 'false');
    }

    ?>

  </body>
</html>