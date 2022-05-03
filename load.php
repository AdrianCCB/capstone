<?php

include('core/config.php');
include('core/db.php');
include('core/functions.php');

$data = array();

$appointmentQuery = DB::query("SELECT * FROM appointment");  // enquire data from appointment table
foreach($appointmentQuery as $appointmentResult){
    $usingID = $appointmentResult['userID'];
    $userQuery = DB::query("SELECT * FROM user WHERE userID=%i", $usingID);  // enquire data from user table
    foreach($userQuery as $userResult){
        $userName = $userResult["userName"];
        $userPhone = $userResult["userPhone"];
        $userEmail = $userResult["userEmail"];
        $userID = $userResult["userID"];
    }
    $data[] = array(  
        'ID' => $appointmentResult["appointmentID"],
        'title' => $appointmentResult["appointmentService"],
        'start' => $appointmentResult["appointmentStartDate"],
        'artist' => $appointmentResult["appointmentArtist"],
        'userName' => $userName,
        'userPhone' => $userPhone,
        'userEmail' => $userEmail,
        'service' => $appointmentResult["appointmentService"]
    );
}

echo json_encode($data);

?>

