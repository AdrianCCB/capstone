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
    <title>Appointments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
                    <a href="admin-customers.php" class="nav-link text-white">
                        <svg class="bi me-2" width="8" height="16">
                            <use xlink:href="#grid" />
                        </svg>
                        Customers
                    </a>
                </li>
                <li>
                  <a href="admin-appointments.php" class="nav-link text-white active">
                      <svg class="bi me-2" width="8" height="16">
                          <use xlink:href="#grid" />
                      </svg>
                      Appointments
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
            <table class="table display" id="allAppointments">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Artist</th>
                        <th scope="col">Service</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $appointmentQuery = DB::query("SELECT * FROM appointment");  // enquire data from appointment table
                    foreach($appointmentQuery as $appointmentResult){
                        $usingID = $appointmentResult['appointmentID'];
                        $userQuery = DB::query("SELECT * FROM user WHERE userID=%i", $usingID);  // enquire data from user table
                        foreach($userQuery as $userResult){
                            $userName = $userResult["userName"];
                            $userPhone = $userResult["userPhone"];
                            $userEmail = $userResult["userEmail"];
                            $userID = $userResult["userID"];
                            echo '<tr class="text-center">';
                            echo '<td>' . $usingID . '</td>';
                            echo '<td>' . ucwords($appointmentResult['appointmentStartDate']) . '</td>';
                            echo '<td>' . $userName . '</td>';
                            echo '<td>' . $userPhone . '</td>';
                            echo '<td>' . $appointmentResult['appointmentArtist'] . '</td>';
                            echo '<td>' . $appointmentResult['appointmentService'] . '</td>';
                            echo '<td>' . $appointmentResult['appointmentComments'] . '</td>';
                            echo '<td> 
                                    <a class="update-appointment" id="'. $usingID .'"><i class="fas fa-edit"></i> </a> 
                                </td>';
                            echo '</tr>';
                        }
                    }
                    // $userQuery = DB::query("SELECT * FROM user");  // enquire data from user table
                    // foreach($userQuery as $userResult){
                    //     $userID = $userResult['userID'];
                    //     $userName = $userResult["userName"];
                    //     $userPhone = $userResult["userPhone"];
                    //     $userEmail = $userResult["userEmail"];
                    //     $appointmentQuery = DB::query("SELECT * FROM appointment");  // enquire data from appointment table
                    //     foreach($appointmentQuery as $appointmentResult){
                    //         echo '<tr class="text-center">';
                    //         echo '<td>' . $appointmentResult['appointmentID'] . '</td>';
                    //         echo '<td>' . ucwords($appointmentResult['appointmentStartDate']) . '</td>';
                    //         echo '<td>' . $userName . '</td>';
                    //         echo '<td>' . $userPhone . '</td>';
                    //         echo '<td>' . $appointmentResult['appointmentArtist'] . '</td>';
                    //         echo '<td>' . $appointmentResult['appointmentService'] . '</td>';
                    //         echo '<td>' . $appointmentResult['appointmentComments'] . '</td>';
                    //         echo '<td> 
                    //                 <a class="update-appointment" id="'. $userID .'"><i class="fas fa-edit"></i> </a> 
                    //             </td>';
                    //         echo '</tr>';
                    //     }
                    // }
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
            $('#allAppointments').DataTable();
        } );       
    </script>

    <script>
        $(".update-appointment").click(function(){
            var element = $(this);
            var update_id = element.attr("id");

            $.ajax({
                type: "POST",
                url: "admin-appointments-onclick.php",
                data:{
                    id: update_id,
                },
                success: function(info){ 
                    var appointmentDetails = JSON.parse(info);
                    var appointmentStartDate = appointmentDetails.date;
                    var appointmentService = appointmentDetails.service;
                    var appointmentComment = appointmentDetails.comment;

                    Swal.fire({
                        title: 'Update Appointment Details',
                        html:
                            'Date: <input id="swal-input1" class="swal2-input" value="' + appointmentStartDate + '">' + '<br>' +
                            'Service: <input id="swal-input2" class="swal2-input" value="' + appointmentService + '">' + '<br>' +
                            'Comment: <input id="swal-input3" class="swal2-input" value="' + appointmentComment + '">',
                        focusConfirm: false,
                        preConfirm: () => {
                            var date = $('#swal-input1').val();
                            var service = $('#swal-input2').val();
                            var comment = $('#swal-input3').val();

                            return [
                                $.ajax({
                                    type: "POST",
                                    url: "admin-appointments-update.php",
                                    data:{
                                        date: date,
                                        service: service,
                                        comment: comment,
                                        id: update_id,
                                    },
                                    success: function(){ 
                                        Swal.fire(
                                            'Successfully updated details',
                                            'Please kindly check the details again',
                                            'success'
                                        ).then(function(){
                                            window.location.href = "admin-appointments.php";
                                        })
                                    }
                                })
                            ]
                        }
                    })
                }
            });
        });
    </script>

</body>

</html>