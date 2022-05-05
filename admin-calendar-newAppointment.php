<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

$name = ucwords($_POST['name']);
$phone = ($_POST['phone']);
$email = ($_POST['email']);
$artist = ($_POST['artist']);
$service = ($_POST['service']);
$date = ($_POST['date']);


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
$where->add('appointmentArtist=%s', $artist);
$where->add('appointmentStartDate=%t', $date);

// check if artist was booked on the date which customer selected
$artistQuery = DB::query("SELECT * FROM appointment WHERE %l", $where);
$artistCount = DB::count();

// if the date do not have the artist, will start register booking
if($artistCount == 0){

    DB::startTransaction();
    DB::insert("appointment", [
        'appointmentStartDate' => $date,
        'appointmentArtist' => $artist,
        'appointmentService' => $service,
        'userID' => $userID
    ]);
        
    $newUserID = DB::insertId();
    $isSuccess = DB::affectedRows();
    
    if ($isSuccess) {
        DB::commit();
        echo "success";
    } else {
        $rollBackError = DB::rollback();
    }
} else {
    echo "Not available";
} 


?>