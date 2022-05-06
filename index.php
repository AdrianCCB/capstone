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

    if($formNamePass && $formPhonePass && $formEmailPass && $formDatePass && $formServicePass && $formArtistPass){
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

<!-- Page Title-->
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Home</title>
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
        <div class="rd-navbar-wrap rd-navbar-wrap-absolute">
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
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Home</a>
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
              <p class="text-spacing-60">Consistently upgrading their ability and knowledge through training and seminars keeps our artists well versed in the latest industry standards.</p><a class="button button-primary" href="services.php">learn more</a>
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
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-wrap">
                      <label class="form-label" for="contact-message">Your comment</label>
                      <textarea class="form-input" id="contact-message" name="message" ><?php echo $message ;?></textarea>
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
      <?php include 'templates/footer-brand.php'; ?>
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
      alertRedirect('success', 'Successfully booked' , $artistOption . ' on ' . $date , true, 'false', 'index.php');
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
