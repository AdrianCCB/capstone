<?php

if(isset($_POST["submit"])){
  // if($_POST["name"] || $_POST["sec-name"] || $_POST["phone"] || $_POST["email"] || $_POST["message"] == "") {
  //   echo
  // }
  $mailto = "adrianchai88@gmail.com"; // my email address
  $name = $_POST['name'] . $_POST['sec-name'];
  $phone = $_POST['phone']; // getting customer phone
  $clientEmail = $_POST['email']; // getting customer email
  $clientMessage = $_POST['message'];
  $subject = "";
  $subject2 = "Confirmation: Message was submitted successfully."; // for customer confirmation

  // Email body I will receive
  $message = "Client Name: " . $name . "\n"
  . "Phone Number: " . $phone . "\n\n"
  . "Client Message: ". "\n" . $clientMessage;

  // Message for client confirmation
  $message2 = "Dear" . $name . "\n"
  . "Thank you for contacting us! We will get back to you shortly!" . "\n\n"
  . "You submitted the following message: " . "\n" . $clientMessage . "\n\n"
  . "Regards," . "\n" . "J.A.B Ink Studio";

  // Email headers
  $headers = "From: " . $clientEmail; // Client email, I will receive
  $headers2 - "From: " . $mailto; // This will receive client

  // PHP mailer function

  $results = mail($mailto, $subject, $message, $headers); // this emaill will send to me
  $results2 = mail($clientEmail, $subject2, $message2, $headers2); //THis confirmation email to client

  // checking if the email has sent successful

  if ($results && $results2) {
    $sucess = "Your message was sent sucessfully!";
  } else {
    $fail = "Sorry! Message was not sent successfully!";
  }

}

?>

<!-- Page Title--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Contacts</title>
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
                      <li class="rd-nav-item"><a class="rd-nav-link" href="overview.php">About</a>
                        <!-- RD Navbar Dropdown -->
                        <ul class="rd-menu rd-navbar-dropdown">
                          <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="overview.php">Overview</a></li>
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
              <p>You can contact us any way that is convenient for you. We are available 24/7 via fax or email. <br class="d-none d-lg-inline">You can also use a quick contact form below or visit our salon personally.</p>
              <!-- RD Mailform-->
              <form class="rd-mailform text-left rd-form" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                <div class="row row-15 row-gutters-16">
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-name">First name</label>
                      <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-sec-name">Last name</label>
                      <input class="form-input" id="contact-sec-name" type="text" name="sec-name" data-constraints="@Required">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-phone">Phone</label>
                      <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Numeric @Required">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-email">E-Mail</label>
                      <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-message">Message</label>
                      <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-button group-sm text-left">
                  <button class="button button-primary" type="submit">Send message</button>
                </div>
              </form>
            </div>
            <div class="col-lg-4">
              <ul class="contact-list">
                <li> 
                  <p class="contact-list-title">Address</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-map-marker icon-primary"></span><a href="#">545 Orchard Road Singapore 238882</a></div>
                </li>
                <li>
                  <p class="contact-list-title">Phones</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-phone icon-primary"></span><a href="tel:#">(+65) 6123–4567</a><span>, </span><a href="tel:#">(+65) 6765-4321 </a></div>
                </li>
                <li>
                  <p class="contact-list-title">E-mail</p>
                  <div class="contact-list-content"><span class="icon mdi mdi-email-outline icon-primary"></span><a href="mailto:#">jabinkstudio@demolink.org</a></div>
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
  </body>
</html>