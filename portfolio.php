
<!-- Page Title--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Portfolio</title>
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
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="portfolio.php">Portfolio</a>
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
      <section class="section-page-title context-dark" style="background-image: url(images/page-title-1920x427.jpg); background-size: cover;">
        <div class="container">
          <h1 class="page-title">Portfolio</h1>
        </div>
      </section>
      <section class="breadcrumbs-custom">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Portfolio</li>
          </ul>
        </div>
      </section>
      <section class="section section-lg bg-default text-center">
        <div class="container">
          <h2>Porfolio</h2>
          <p class="block-lg">Our studio provides tattoos of various complexity. From simple to highly creative artworks, we gather all our achievements in the portfolio. Feel free to take a look at the gallery below to discover our best works.</p>
          <div class="row row-30">
            <!-- Isotope Filters-->
            <div class="col-lg-12">
              <div class="isotope-filters isotope-filters-horizontal">
                <button class="isotope-filters-toggle button button-sm button-primary" data-custom-toggle="#isotope-filters" data-custom-toggle-disable-on-blur="true">Filter<span class="caret"></span></button>
                <ul class="isotope-filters-list" id="isotope-filters">
                  <li><a class="active" data-isotope-filter="*" data-isotope-group="gallery" href="#">All</a></li>
                  <li><a data-isotope-filter="filter-1" data-isotope-group="gallery" href="#">TRADITIONAL TATTOOs</a></li>
                  <li><a data-isotope-filter="filter-2" data-isotope-group="gallery" href="#">ORNAMENT TATTOOs</a></li>
                  <li><a data-isotope-filter="filter-3" data-isotope-group="gallery" href="#">MINIMALIStic</a></li>
                  <li><a data-isotope-filter="filter-4" data-isotope-group="gallery" href="#">BLACK AND WHITE</a></li>
                </ul>
              </div>
            </div>
            <!-- Isotope Content-->
            <div class="col-lg-12">
              <div class="isotope row row-condensed no-gutters justify-content-lg-center" data-isotope-layout="masonry" data-isotope-group="gallery" data-lightgallery="group" data-column-class=".col-sm-6.col-lg-4">
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-4"><a class="gallery-item" data-lightgallery="item" href="images/gallery-1-800x1200.jpg"><img src="images/gallery-1-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Black and gray</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-3"><a class="gallery-item" data-lightgallery="item" href="images/gallery-2-800x1200.jpg"><img src="images/gallery-2-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Classic Americana</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-2"><a class="gallery-item" data-lightgallery="item" href="images/gallery-3-800x1200.jpg"><img src="images/gallery-3-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Minimalism</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-1"><a class="gallery-item" data-lightgallery="item" href="images/gallery-5-800x1200.jpg"><img src="images/gallery-5-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Blackwork</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-2"><a class="gallery-item" data-lightgallery="item" href="images/gallery-6-1200x800.jpg"><img src="images/gallery-6-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Surrealism</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-3"><a class="gallery-item" data-lightgallery="item" href="images/gallery-4-800x1200.jpg"><img src="images/gallery-4-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">New School</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-2"><a class="gallery-item" data-lightgallery="item" href="images/gallery-7-800x1200.jpg"><img src="images/gallery-7-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Japanese</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-1"><a class="gallery-item" data-lightgallery="item" href="images/gallery-8-800x1200.jpg"><img src="images/gallery-8-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Portraiture</span><span class="gallery-item-button"></span></a>
                </div>
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="filter-2"><a class="gallery-item" data-lightgallery="item" href="images/gallery-9-1200x800.jpg"><img src="images/gallery-9-570x570.jpg" alt="" width="570" height="570"/><span class="gallery-item-title">Realism</span><span class="gallery-item-button"></span></a>
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
                  <li class="rd-nav-item"><a class="rd-nav-link" href="index.php">Home</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="our-team.php">About</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="services.php">Services</a></li>
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="portfolio.php">Portfolio</a></li>
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
  </body>
</html>