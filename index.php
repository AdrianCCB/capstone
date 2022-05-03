<?php

  include('core/config.php');
  include('core/db.php');
  include('core/functions.php');

  // $artistCount = $isSuccess = "";

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
          echo "<script>alert('Success');</script>";
          // sweetalert to notify customer booking successful
      } else {
          $rollBackError = DB::rollback();
      }
    } else {
      
      echo "<script>alert('Name and/or password mismatch');</script>";
    }
  }
?>

<!-- Page Title-->
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Home</title>
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
        <div class="rd-navbar-wrap rd-navbar-wrap-absolute">
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
                        <div class="unit-body"> Sat: 10am - 6pm</div>
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
                  <!-- <div class="rd-navbar-brand"><a class="brand" href="index.html"><img class="brand-logo-dark" src="images/logo-default-260x82.png" alt="" width="130" height="41"/><img class="brand-logo-inverse" src="images/logo-inverse-260x82.png" alt="" width="130" height="41"/></a></div> -->
                  <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo-black-260x82.png" alt="" width="130" height="41"/><img class="brand-logo-inverse" src="images/logo-white-260x82.png" alt="" width="130" height="41"/></a></div>
                </div>
                <div class="rd-navbar-main-element">
                  <div class="rd-navbar-nav-wrap">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Home</a>
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
                      <li class="rd-nav-item"><a class="rd-nav-link" href="appointment.php">Appointment</a>
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
      <!-- Swiper-->
      <section class="section swiper-container swiper-slider swiper-slider-1 slider-scale-effect bg-primary" data-loop="false" data-autoplay="5500" data-simulate-touch="false" data-slide-effect="fade">
        <div class="swiper-wrapper">
          <div class="swiper-slide slide-bg-1">
            <div class="slide-bg" style="background-image: url(&quot;images/slide-1-1920x879.jpg&quot;)"></div>
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-sm-10 col-lg-9 col-xl-8">
                    <h1 data-caption-animate="fadeInUp" data-caption-delay="100"><span>Reliable & affordable</span><span class="title-big">TATTOO SERVICES</span></h1>
                    <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="250">Welcome to J.A.B Ink Studio, a class-leading tattoo studio providing top-notch tattooing services. We provide all tattoo lovers the opportunity to enjoy a wide range of styles from Neo Traditional tattoos to Colour realism tattoos to Dotwork tattoos. With us, you can be sure of the result.</p><a class="button button-primary" href="services.php" data-caption-animate="fadeInUp" data-caption-delay="450">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide slide-bg-2"> 
            <div class="slide-bg" style="background-image: url(&quot;images/slide-2-1920x879.jpg&quot;)"></div>
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-md-10 col-lg-9 col-xl-8">
                    <h1 data-caption-animate="fadeInUp" data-caption-delay="100"><span>Professional</span><span class="title-big">TATTOOISTS</span></h1>
                    <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="250">Our highly qualified team of tattooists is always ready to help you make even the wildest ideas come true. The level of our artists’ creativity & skills allows them to work on the most stunning artworks. Our team ensures that you will get what you want for you body to look exceptional.</p><a class="button button-primary" href="our-team.php" data-caption-animate="fadeInUp" data-caption-delay="450">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide slide-bg-3">
            <div class="slide-bg" style="background-image: url(&quot;images/slide-3-1920x879.jpg&quot;)"></div>
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-md-10 col-lg-9 col-xl-8">
                    <h1 data-caption-animate="fadeInUp" data-caption-delay="100"><span>100% safe & painless</span><span class="title-big">TATTOOING</span></h1>
                    <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="250">At J.A.B Ink Studio, safety and sanitation is our priority. First timers and the experienced can rest assured that our artists will uphold class leading standards, ensuring a healthy tattooing and recovery process catered to your skin type.</p><a class="button button-primary" href="testimonials.php" data-caption-animate="fadeInUp" data-caption-delay="450">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Swiper Pagination -->
        <div class="swiper-pagination"></div>
        <div class="swiper-counter"></div>
        <!-- Swiper Navigation-->
        <div class="swiper-button-prev">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="17px" height="30px" viewbox="0 0 17 30" enable-background="new 0 0 17 30" xml:space="preserve">
            <g>
              <defs>
                <rect id="SVGID_111_" width="17" height="30"></rect>
              </defs>
              <clippath id="SVGID_2222_">
                <use xlink:href="#SVGID_111_" overflow="visible"></use>
              </clippath>
              <line clip-path="url(#SVGID_2222_)" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="8.5" y1="0.833" x2="8.5" y2="29.167"></line>
              <polyline clip-path="url(#SVGID_2222_)" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="									    16.15,20.833 8.5,29.167 0.85,20.833 	"></polyline>
            </g>
          </svg>
        </div>
        <div class="swiper-button-next">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="17px" height="30px" viewbox="0 0 17 30" enable-background="new 0 0 17 30" xml:space="preserve">
            <g>
              <defs>
                <rect id="SVGID_1_" width="17" height="30"></rect>
              </defs>
              <clippath id="SVGID_2_">
                <use xlink:href="#SVGID_1_" overflow="visible"></use>
              </clippath>
              <line clip-path="url(#SVGID_2_)" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="8.5" y1="29.167" x2="8.5" y2="0.833"></line>
              <polyline clip-path="url(#SVGID_2_)" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="									    0.85,9.167 8.5,0.833 16.15,9.167 	"></polyline>
            </g>
          </svg>
        </div>
      </section>
      <section class="section section-xl bg-image bg-mask" style="background-image:url(images/home-01-1920x662.jpg)">
        <div class="container">
          <div class="row justify-content-md-end">
            <div class="col-lg-6 col-xl-5">
              <h2>A few words about our studio</h2>
              <p class="big text-gray-800">We are recognised as #1 tattoo studio in Singapore. We aim to deliver the best tattooing services you can find on our sunny island.</p>
              <p class="text-spacing-60">Consistently upgrading their ability and knowledge through training and seminars keeps our artists well versed in the latest industry standards.</p><a class="button button-primary" href="overview.php">learn more</a>
            </div>
          </div>
        </div>
      </section>
      <section class="section section-lg bg-gray-100">
        <div class="container">
          <div class="row row-50">
            <div class="col-lg-6">
              <div class="row row-50 row-lg-70">
                <div class="col-md-6 col-lg-12">
                  <h2>Our advantages</h2>
                  <p class="big text-gray-800">For over 10 years of constant improvement, we have become one of the most successful tattoo studio. Here’s why people choose us.</p>
                  <p>Continuous learning and advanced training is essential in the tattoo industry. That’s why by constantly evolving, acquiring new equipment and learning new techniques, every tattoo artist at J.A.B Ink Studio holds a place as a leader in this field. We are also dedicated to delivering you the best possible result at an affordable price.</p>
                </div>
                <div class="col-md-6 col-lg-12">
                  <div class="quote-with-image">
                    <figure class="quote-img"><img src="images/home-1-7-534x406.jpg" alt="" width="534" height="406"/>
                    </figure>
                    <div class="quote-caption">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="88.34px" height="65.34px" viewBox="0 0 88.34 65.34" enable-background="new 0 0 88.34 65.34" overflow="scroll" xml:space="preserve" preserveAspectRatio="none">
                        <path d="M49.394,65.34v-4.131c12.318-7.088,19.924-16.074,22.811-26.965c-3.125,2.032-5.968,3.051-8.526,3.051																	c-4.265,0-7.864-1.721-10.803-5.168c-2.937-3.444-4.407-7.654-4.407-12.64c0-5.511,1.932-10.142,5.791-13.878																	C58.123,1.873,62.873,0,68.51,0c5.639,0,10.354,2.379,14.143,7.137c3.793,4.757,5.688,10.678,5.688,17.758																	c0,9.977-3.814,18.912-11.443,26.818C69.268,59.613,60.101,64.156,49.394,65.34z M0.923,65.34v-4.131																	c12.321-7.088,19.926-16.074,22.813-26.965c-3.126,2.032-5.993,3.051-8.598,3.051c-4.219,0-7.794-1.721-10.734-5.168																	C1.467,28.683,0,24.473,0,19.487C0,13.976,1.919,9.346,5.757,5.609C9.595,1.873,14.334,0,19.971,0																	c5.685,0,10.41,2.379,14.178,7.137c3.767,4.757,5.652,10.678,5.652,17.758c0,9.977-3.805,18.912-11.409,26.818																	C20.787,59.613,11.632,64.156,0.923,65.34z"></path>
                      </svg>
                      <h3 class="quote-text text-right">The stories in your heart, written on your skin.</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row row-50 row-lg-70">
                <div class="col-md-6 col-lg-12">
                  <figure class="block-image"><img src="images/home-1-9-541x369.jpg" alt="" width="541" height="369"/>
                  </figure>
                  <p>Every artist at J.A.B Ink Studio understands that safety always comes first. That’s why the team of our studio uses only the best tattoing equipment and consumables. Moreover, we guarantee 100% sterility and complete medical care in each and after each procedure. Tattoo artists at our studio will make every effort to provide you with a painless experience.</p>
                </div>
                <div class="col-md-6 col-lg-12">
                  <div class="box-video" data-lightgallery="group"><img src="images/home-1-8-541x369.jpg" alt="" width="541" height="369"/><a class="button-play" data-lightgallery="item" href="https://www.youtube.com/watch?v=m10Vl9TXpec"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- <section class="section section-lg bg-default text-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-9 col-lg-7">
              <h2>Our Services</h2>
              <p>We provide a wide variety of tattooing services to both regular and new clients. At J.A.B Ink Studio, you can expect first-class treatment as well as 100% safe and sterile environment & equipment.</p>
            </div>
          </div>
          <div class="row icon-modern-list no-gutters">
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-01-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Tattooing</a></h4>
                <p>At our tattoo studio, we combine modern technics with traditional ones for a premium result.</p>
              </article>
            </div>
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-02-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Piercing</a></h4>
                <p>Want some extra holes in your body? Our piercing masters will make some for you.</p>
              </article>
            </div>
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-03-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Tattoo cover up</a></h4>
                <p>Got some old tattoos that you don’t find pretty? Our talented artists will cover them up for you.</p>
              </article>
            </div>
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-04-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Tattoo design</a></h4>
                <p>Nothing can beat the challenge of creating a design that initially is only in your imagination.</p>
              </article>
            </div>
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-05-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Permanent makeup</a></h4>
                <p>Permanent makeup is a cosmetic technique which employs tattoos as a means of producing designs.</p>
              </article>
            </div>
            <div class="col-sm-6 col-lg-4">
              <article class="box-icon-modern modern-variant-2">
                <div class="icon-modern"><img src="images/icon-06-80x80.png" alt="" width="80" height="80"/>
                </div>
                <h4 class="box-icon-modern-title"><a href="services.php">Laser removal</a></h4>
                <p>Laser tattoo removal offers an effective solution to your unwanted tattoos as a simple outpatient procedure.</p>
              </article>
            </div>
          </div>
        </div>
      </section> -->
      <!-- <section class="section section-lg bg-primary text-center text-lg-left">
        <div class="container">
          <div class="row row-50 justify-content-center justify-content-lg-between">
            <div class="col-md-10 col-lg-6">
              <h2>Our art showcase</h2>
              <p class="big">Inkvo Tattoo Salon is a place where the best tattoo artists showcase their work. We welcome you to take a look at our best artworks.</p>
              <p>Our tattoo salon provides creative space for every tatto artist to show their skills and unique ideas. Our clients and visitors are always welcome to take a look at our most impressive tattoos and artworks submitted by the artists of Inkvo. Feel free to take a look at our gallery to discover your future tattoo.</p><a class="button-link button-link-icon" href="gallery-without-padding.html">See All Works<span class="icon fa-arrow-right"></span></a>
            </div>
            <div class="col-lg-6"> -->
              <!-- Owl Carousel-->
              <!-- <div class="block-sm">
                <div class="owl-carousel carousel-modern" data-items="1" data-dots="true" data-nav="false" data-stage-padding="0" data-loop="true" data-margin="0" data-mouse-drag="false" data-autoplay="true"><img src="images/home-1-4-549x422.jpg" alt="" width="549" height="422"/><img src="images/home-1-5-549x422.jpg" alt="" width="549" height="422"/><img src="images/home-1-6-549x422.jpg" alt="" width="549" height="422"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
     <!-- <section class="section section-lg bg-default text-center">
        <div class="container">
          <h2>Our amazing artists</h2>
          <p class="block-lg">J.A.B Ink Studio has a team of talented and highly creative artists whose main goal is not just to keep you satisfied but also impress you with a unique art that will help you stand out from the crowd. The experience and unmatched skills of our tattooists are reasons of our studio’s success.</p>
        </div>
        <div class="container">
          <div class="row row-20">
            <div class="col-12">-->
              <!-- Owl Carousel-->
             <!-- <div class="owl-carousel owl-carousel-center" data-items="1" data-md-items="3" data-xl-items="3" data-dots="false" data-nav="true" data-stage-padding="0" data-loop="true" data-margin="0" data-mouse-drag="false" data-center="true" data-autoplay="false">
                <div class="team-minimal">
                  <figure><img src="images/team-2-370x370.jpg" alt="" width="370" height="370"></figure>
                  <div class="team-minimal-caption">
                    <h4 class="team-title"><a href="team-member-profile.php">Sam Williams</a></h4>
                    <p>Junior Tattoo Artist</p>
                  </div>
                </div>
                <div class="team-minimal">
                  <figure><img src="images/team-1-370x370.jpg" alt="" width="370" height="370"></figure>
                  <div class="team-minimal-caption">
                    <h4 class="team-title"><a href="team-member-profile.php">Mary Lucas</a></h4>
                    <p>Tattoo Artist</p>
                  </div>
                </div>
                <div class="team-minimal">
                  <figure><img src="images/team-3-370x370.jpg" alt="" width="370" height="370"></figure>
                  <div class="team-minimal-caption">
                    <h4 class="team-title"><a href="team-member-profile.php">George Adams</a></h4>
                    <p>Receptionist</p>
                  </div>
                </div>
                <div class="team-minimal">
                  <figure><img src="images/team-4-370x370.jpg" alt="" width="370" height="370"></figure>
                  <div class="team-minimal-caption">
                    <h4 class="team-title"><a href="team-member-profile.php">Sarah Peterson</a></h4>
                    <p>Founder, Senior Tattoo Artist</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12"><a class="button button-primary" href="our-team.php">View all team</a></div>
          </div>
        </div>
      </section> 
      <section class="section section-lg bg-default text-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-10 col-xl-9">
              <h2>Portfolio</h2>
              <p>Our studio provides tattoos of various complexity. From simple to highly creative artworks, we gather all our achievements in the portfolio. Feel free to take a look at the gallery below to discover our best works.</p>
            </div>
          </div>
          <div class="row row-30"> -->
            <!-- Isotope Filters-->
          <!--  <div class="col-lg-12">
              <div class="isotope-filters isotope-filters-horizontal">
                <button class="isotope-filters-toggle button button-sm button-primary" data-custom-toggle="#isotope-filters" data-custom-toggle-disable-on-blur="true">Filter<span class="caret"></span></button>
                <ul class="isotope-filters-list" id="isotope-filters">
                  <li><a class="active" data-isotope-filter="*" data-isotope-group="gallery" href="#">All</a></li>
                  <li><a data-isotope-filter="filter-1" data-isotope-group="gallery" href="#">TRADITIONAL TATTOOs</a></li>
                  <li><a data-isotope-filter="filter-2" data-isotope-group="gallery" href="#">ORNAMENT TATTOOs</a></li>
                  <li><a data-isotope-filter="filter-3" data-isotope-group="gallery" href="#">MINIMALIStic</a></li>
                  <li><a data-isotope-filter="filter-4" data-isotope-group="gallery" href="#">BLACK AND WHITE</a></li>
                  <li><a data-isotope-filter="filter-5" data-isotope-group="gallery" href="#">other</a></li>
                </ul>
              </div>
            </div>-->
            <!-- Isotope Content-->
           <!--  <div class="col-lg-12">
              <div class="isotope row" data-isotope-layout="masonry" data-isotope-group="gallery" data-lightgallery="group" data-column-class=".col-sm-6.col-md-6.col-lg-3">
                <div class="col-sm-6 isotope-item" data-filter="filter-1"><a class="gallery-item" data-lightgallery="item" href="images/gallery-1-800x1200.jpg"><img src="images/gallery-1-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Black and gray</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 isotope-item" data-filter="filter-2"><a class="gallery-item" data-lightgallery="item" href="images/gallery-2-800x1200.jpg"><img src="images/gallery-2-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Classic Americana</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 isotope-item" data-filter="filter-3"><a class="gallery-item" data-lightgallery="item" href="images/gallery-3-800x1200.jpg"><img src="images/gallery-3-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Minimalism</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 isotope-item" data-filter="filter-4"><a class="gallery-item" data-lightgallery="item" href="images/gallery-4-800x1200.jpg"><img src="images/gallery-4-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Blackwork</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 isotope-item" data-filter="filter-5"><a class="gallery-item" data-lightgallery="item" href="images/gallery-5-800x1200.jpg"><img src="images/gallery-5-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Surrealism</span><span class="gallery-item-button"></span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12"><a class="button button-primary" href="portfolio.php">View all</a></div>
          </div>
        </div>
      </section> -->
      <section class="section section-lg bg-primary text-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-10 col-xl-9">
              <h2>Make an Appointment</h2>
              <p class="text-contrast">The best way to enjoy a treatment at our studio is to book an appointment with the desired tattoo artist. Fill in the form below and we will contact you to discuss your appointment.</p>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-md-10 col-xl-8">
              <!-- RD Mailform-->
              <form class="text-left" method="post">
                <div class="row row-20 row-gutters-16 justify-content-center">
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-name">Your Name</label>
                      <input class="form-input" id="contact-name" type="text" name="name"  data-constraints="@Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-email">Your E-mail</label>
                      <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-phone">Your Phone</label>
                      <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Numeric @Required">
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
                      <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
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
      <section class="section section-lg bg-default">
        <div class="container">
          <div class="row row-50">
            <div class="col-lg-6">
              <div class="block-xs"> 
                <h2>Testimonials of Our Clients</h2>
                <p class="big text-gray-800">Thanks to our clients’ regular reviews, testimonials, and comments, we are able to improve our studio.</p>
                <p>Unlike other studios, we prefer to maintain a constant connection with our customers and receive feedback on every service, whether it’s a simple tattoo or a permanent makeup service. If you’ve already visited J.A.B Ink Studio, feel free to contact us and send your testimonial.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <!-- Owl Carousel-->
              <div class="owl-carousel carousel-corporate" data-items="1" data-dots="true" data-nav="false" data-stage-padding="10px" data-loop="true" data-autoplay="true" data-margin="25px" data-mouse-drag="false">
                <div class="quote-corporate">
                  <div class="quote-header">
                    <h4>Amanda Smith</h4>
                    <p class="big mt-1">Client</p>
                  </div>
                  <div class="quote-body">
                    <div class="quote-text">
                      <p>I visited J.A.B Ink Studio about a month ago to get a tattoo. The salon has a very laid-back atmosphere while also staying very professional. Everyone was very nice and welcoming. James is not just an awesome artist, but a pretty cool guy to hang out with while getting tattooed.</p>
                    </div>
                    <svg class="quote-body-mark" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="66px" height="49px" viewbox="0 0 66 49" enable-background="new 0 0 66 49" xml:space="preserve">
                      <g></g>
                      <path d="M36.903,49v-3.098c9.203-5.315,14.885-12.055,17.042-20.222c-2.335,1.524-4.459,2.288-6.37,2.288						c-3.186,0-5.875-1.29-8.071-3.876c-2.194-2.583-3.293-5.74-3.293-9.479c0-4.133,1.443-7.605,4.327-10.407						C43.425,1.405,46.973,0,51.185,0c4.213,0,7.735,1.784,10.566,5.352C64.585,8.919,66,13.359,66,18.669						c0,7.482-2.85,14.183-8.549,20.112C51.751,44.706,44.902,48.112,36.903,49z M0.69,49v-3.098						c9.205-5.315,14.887-12.055,17.044-20.222c-2.335,1.524-4.478,2.288-6.423,2.288c-3.152,0-5.823-1.29-8.02-3.876						C1.096,21.51,0,18.353,0,14.614c0-4.133,1.434-7.605,4.301-10.407C7.168,1.405,10.709,0,14.92,0c4.247,0,7.778,1.784,10.592,5.352						c2.814,3.567,4.223,8.007,4.223,13.317c0,7.482-2.843,14.183-8.524,20.112C15.53,44.706,8.69,48.112,0.69,49z"></path>
                    </svg>
                  </div>
                  <div class="quote-image"><img src="images/home-1-10-90x90.jpg" alt="" width="90" height="90"/>
                  </div>
                </div>
                <div class="quote-corporate">
                  <div class="quote-header">
                    <h4>Michael Wood</h4>
                    <p class="big mt-1">Client</p>
                  </div>
                  <div class="quote-body">
                    <div class="quote-text">
                      <p>If there is a place in my city where I would like to be tattooed next time, it is your tattoo studio. You guys are doing amazing job spreading the quality tattoos in the area, and I really like what you do! I will definitely tell my friends about your studio and your artists!</p>
                    </div>
                    <svg class="quote-body-mark" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="66px" height="49px" viewbox="0 0 66 49" enable-background="new 0 0 66 49" xml:space="preserve">
                      <g></g>
                      <path d="M36.903,49v-3.098c9.203-5.315,14.885-12.055,17.042-20.222c-2.335,1.524-4.459,2.288-6.37,2.288						c-3.186,0-5.875-1.29-8.071-3.876c-2.194-2.583-3.293-5.74-3.293-9.479c0-4.133,1.443-7.605,4.327-10.407						C43.425,1.405,46.973,0,51.185,0c4.213,0,7.735,1.784,10.566,5.352C64.585,8.919,66,13.359,66,18.669						c0,7.482-2.85,14.183-8.549,20.112C51.751,44.706,44.902,48.112,36.903,49z M0.69,49v-3.098						c9.205-5.315,14.887-12.055,17.044-20.222c-2.335,1.524-4.478,2.288-6.423,2.288c-3.152,0-5.823-1.29-8.02-3.876						C1.096,21.51,0,18.353,0,14.614c0-4.133,1.434-7.605,4.301-10.407C7.168,1.405,10.709,0,14.92,0c4.247,0,7.778,1.784,10.592,5.352						c2.814,3.567,4.223,8.007,4.223,13.317c0,7.482-2.843,14.183-8.524,20.112C15.53,44.706,8.69,48.112,0.69,49z"></path>
                    </svg>
                  </div>
                  <div class="quote-image"><img src="images/home-1-11-90x90.jpg" alt="" width="90" height="90"/>
                  </div>
                </div>
                <div class="quote-corporate">
                  <div class="quote-header">
                    <h4>Eva Garcia</h4>
                    <p class="big mt-1">Client</p>
                  </div>
                  <div class="quote-body">
                    <div class="quote-text">
                      <p>J.A.B Ink Studio is a place where you can get a high-quality tattoo, and even order a custom design based on your wishes and expectations. This is exactly what I received during my first visit to the studio, and I will certainly come here again to have another tattoo done.</p>
                    </div>
                    <svg class="quote-body-mark" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="66px" height="49px" viewbox="0 0 66 49" enable-background="new 0 0 66 49" xml:space="preserve">
                      <g></g>
                      <path d="M36.903,49v-3.098c9.203-5.315,14.885-12.055,17.042-20.222c-2.335,1.524-4.459,2.288-6.37,2.288						c-3.186,0-5.875-1.29-8.071-3.876c-2.194-2.583-3.293-5.74-3.293-9.479c0-4.133,1.443-7.605,4.327-10.407						C43.425,1.405,46.973,0,51.185,0c4.213,0,7.735,1.784,10.566,5.352C64.585,8.919,66,13.359,66,18.669						c0,7.482-2.85,14.183-8.549,20.112C51.751,44.706,44.902,48.112,36.903,49z M0.69,49v-3.098						c9.205-5.315,14.887-12.055,17.044-20.222c-2.335,1.524-4.478,2.288-6.423,2.288c-3.152,0-5.823-1.29-8.02-3.876						C1.096,21.51,0,18.353,0,14.614c0-4.133,1.434-7.605,4.301-10.407C7.168,1.405,10.709,0,14.92,0c4.247,0,7.778,1.784,10.592,5.352						c2.814,3.567,4.223,8.007,4.223,13.317c0,7.482-2.843,14.183-8.524,20.112C15.53,44.706,8.69,48.112,0.69,49z"></path>
                    </svg>
                  </div>
                  <div class="quote-image"><img src="images/home-1-12-90x90.jpg" alt="" width="90" height="90"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section section-md bg-primary text-center">
        <div class="container"> 
          <div class="row justify-content-md-center row-30 row-lg-40">
            <div class="col-md-9 col-lg-8">
              <h2>Subscribe to the Newsletter</h2>
              <p class="big">Be the first to know about our promotions and discounts!</p>
            </div>
            <div class="col-md-9 col-lg-6">
              <!-- RD Mailform-->
              <form class="rd-form rd-mailform rd-form-inline" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="bat/rd-mailform.php">
                <div class="form-wrap">
                  <input class="form-input" id="subscribe-form-0-email" type="email" name="email" data-constraints="@Email @Required"/>
                  <label class="form-label" for="subscribe-form-0-email">Your E-mail</label>
                </div>
                <div class="form-button">
                  <button class="button button-primary" type="submit">Subscribe</button>
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
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Home</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="our-team.php">About</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="services.php">Services</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="portfolio.php">Portfolio</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="testimonials.php">Testimonials</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="appointment.php">Appointment</a></li>
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
  </body>
</html>