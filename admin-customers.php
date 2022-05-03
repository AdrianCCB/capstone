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
    <title>Customers</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> -->
    <!-- Customs CSS -->
    <link rel="stylesheet" href="css/admin-page.css">
    <link rel="stylesheet" href="css/tooltip.css">
</head>

<body id="admin-bg">
    <div class="row">
        <!-- start of left side navbar -->
        <div class="col-lg-2 col-md-3 col-sm-3 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark"  style="height: 100vh;">
            <a href="admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="20" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
                <span class="fs-4">Admin Page</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin.php" class="nav-link text-white" aria-current="page">
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
                    <a href="admin-customers.php" class="nav-link text-white active">
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

        <!-- start of user's table -->
        <div class="container-fluid col-lg-8 col-md-8 col-sm-8 pt-4 ">
            <table class="table display" id="allUsers">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ID</th>
                        <!-- <th scope="col">Profile Image</th> -->
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // extract user data from DB and display in table format using DATATABLE
                    $userQuery = DB::query("SELECT * FROM user");
                    foreach($userQuery as $userResult){
                        $usingID = $userResult['userID'];
                        echo '<tr class="text-center">';
                            echo '<td scope="row">' . $userResult['userID'] . '</td>';
                            echo '<td>' . ucwords($userResult['userName']) . '</td>';
                            echo '<td>' . $userResult['userEmail'] . '</td>';
                            echo '<td> 
                                    <a href="../update.php?id=' . $userResult['userID'] .' "> <i class="fas fa-edit"></i> </a> 
                                    <a class="deleteUser" id="'. $usingID .'"><i  class="fas fa-trash-alt"></i></a> 
                                </td>';
                            
                        echo '</tr>';
                    }
                    ?>
                    
                    </tbody>
            </table>
        </div>
        <!-- end of user's table -->
    </div>

    <!-- Javascript -->
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e3904b02e6.js" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatables JS -->
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Datatable script -->
    <script>
        $(document).ready( function () {
            $('#allUsers').DataTable();
        } );       
    </script>
    
</body>

</html>