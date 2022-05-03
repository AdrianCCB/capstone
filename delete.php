<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

// Fullcalendar delete PHP

if(isset($_POST["id"])){
    $id = $_POST['id'];
    DB::delete("appointment", "appointmentID = %i", $id);
    echo "Delete";
}

?>