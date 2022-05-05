<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

$date = ($_POST['date']);
$service = ($_POST['service']);
$comment = ($_POST['comment']);
$id = ($_POST['id']);


DB::update('appointment', ['appointmentStartDate' => $name, 'appointmentService' => $service, 'appointmentComments' => $comment], "userID=%i", $_POST['id']);
             
$isSuccess = DB::affectedRows();

if ($isSuccess) {
    DB::commit();
} else {
    $rollBackError = DB::rollback();
}           


?>