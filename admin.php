<?php 
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(isLoggedIn() == 0){
    header("Location: " . SITE_URL . "admin-login.php"); // if there are no cookies, redirect to login
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/tooltip.css">
    <link rel="stylesheet" href="css/admin-page.css">
</head>

<body id="admin-bg">
    <div class="row  align-items-stretch d-flex">
        <!-- start of left side navbar -->
        <div class="col-lg-2 col-md-3 col-sm-3 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="height: 100vh;">
            <a href="admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="20" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
                <span class="fs-4">Admin Page</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin.php" class="nav-link text-white active" aria-current="page">
                        <svg class="bi me-2" width="8" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="admin-calendar.php" class="nav-link text-white">
                        <svg class="bi me-2" width="8" height="16">
                            <use xlink:href="#table" />
                        </svg>
                        Calendar
                    </a>
                </li>
                <li>
                    <a href="admin-customers.php" class="nav-link text-white">
                        <svg class="bi me-2" width="8" height="16">
                            <use xlink:href="#grid" />
                        </svg>
                        Customers
                    </a>
                </li>
                <li>
                    <a href="admin-logout.php" class="nav-link text-white">
                        <svg class="bi me-2" width="4" height="16">
                            <use xlink:href="#grid" />
                        </svg>
                        <button class="btn btn-light">Logout</button>
                    </a>
                </li>
            </ul>
          
        </div>
        <!-- end of left side navbar -->

        <!-- start of main content -->
        <div class="container-fluid col-6 text-center mt-2">
            <div class="row">
                <!-- number of active customers -->
                <div class="col-sm-6 mt-2">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <i class="far fa-user fa-2x"></i>
                            <h5 class="card-title">Registered Customers</h5>
                            <p class="card-text">
                                <!-- using count() to count no of users -->
                                <?php 
                                    $userQuery = DB::query("SELECT * FROM user");
                                    $userCount = DB::count();
                                    
                                    echo '<h1>' . $userCount . '</h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of most recent customers -->
                <div class="col-sm-6 mt-2">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <i class="far fa-user fa-2x"></i>
                            <h5 class="card-title">Recent Registered Customer</h5>
                            <p class="card-text">
                                <!-- retrieve last register user details -->
                                <?php 
                                    $userQuery = DB::query("SELECT * FROM user WHERE userID = (SELECT MAX(userID) FROM user)");
                                    // $userCount = DB::count();
                                    foreach($userQuery as $userResult){
                                        $userName = $userResult["userName"];
                                        $userEmail = $userResult["userEmail"];
                                        $userPhone = $userResult["userPhone"];
                                    }
                                    echo '<span> Name: ' . ucwords($userName) . '</span> <br>';
                                    echo '<span> Email: ' . $userEmail . '</span> <br>';
                                    echo '<span> Phone: ' . $userPhone . '</span> <br>';
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Total number of Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2">
                    <div class="card bg-info">
                        <div class="card-body">
                        <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Total number of Appointments booked</h5>
                            <p class="card-text">
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentID");
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of completed Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2">
                    <div class="card bg-info">
                        <div class="card-body">
                        <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Total Completed Appointments till date</h5>
                            <p class="card-text">
                                <!-- using count() to count those Appointments whom are 1 (admin) -->
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentStartDate < %t", $currentDate);
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of outstanding Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2">
                    <div class="card bg-info">
                        <div class="card-body">
                            <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Outstanding Appointments after today </h5>
                            <p class="card-text">
                                <!-- using count() to calculate how many Appointments are there -->
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentStartDate >= %t", $currentDate);
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of Adrian's Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2 mb-2">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Total Appointment by <b>Adrian</b> </h5>
                            <p class="card-text">
                                <!-- using count() to calculate how many Appointments are there -->
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentArtist = %s", "Adrian");
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of Barry's Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2 mb-2">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Total Appointment by <b>Barry</b> </h5>
                            <p class="card-text">
                                <!-- using count() to calculate how many Appointments are there -->
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentArtist = %s", "Barry");
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- number of Jack's Appointments -->
                <div class="col-sm-6 col-lg-4 mt-2 mb-2">
                    <div class="card bg-success">
                        <div class="card-body">
                            <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <h5 class="card-title">Total Appointment by <b>Jack</b> </h5>
                            <p class="card-text">
                                <!-- using count() to calculate how many Appointments are there -->
                                <?php 
                                    $currentDate = date("Y-m-d");

                                    $appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentArtist = %s", "Jack");
                                    $appointmentCount = DB::count();
                                    
                                    echo '<h1>' . $appointmentCount . ' </h1>'
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of main content -->
    </div>

    <!-- Javascript -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatables JS -->
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>

</html>