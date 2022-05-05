<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

$name = ucwords($_POST['name']);
$email = ($_POST['email']);
$phone = ($_POST['phone']);
$id = ($_POST['id']);


DB::update('user', ['userName' => $name, 'userPhone' => $phone, 'userEmail' => $email], "userID=%i", $_POST['id']);
             
$isSuccess = DB::affectedRows();

if ($isSuccess) {
    DB::commit();
} else {
    $rollBackError = DB::rollback();
}           


?>