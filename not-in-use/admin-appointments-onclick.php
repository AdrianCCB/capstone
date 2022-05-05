<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

$id = ($_POST['id']);

$appointmentQuery = DB::query("SELECT * FROM appointment WHERE appointmentID=%i", $id);
foreach($appointmentQuery as $appointmentResult){
    $date = $appointmentResult['appointmentStartDate'];
    $service = $appointmentResult['appointmentService'];
    $comment = $appointmentResult['appointmentComments'];
}
$Response = array('date' => $date, 'service' => $service, 'comment' => $comment);
echo json_encode($Response);


?>