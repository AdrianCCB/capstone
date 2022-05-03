<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

// Fullcalendar insert php

if(isset($_POST["title"])){
    $title = $_POST['title'];
    $start = $_POST['start'];
    $artist = $_POST['artist'];
    $customer = $_POST['customer'];

    DB::startTransaction();
    DB::insert('appointment', ['appointmentStartDate' => $start, 'appointmentService' => $title, 'appointmentArtist' => $artist]);
                
    $newUserID = DB::insertId();
    $isSuccess = DB::affectedRows();
    
    if ($isSuccess) {
        DB::commit();
    } else {
        $rollBackError = DB::rollback();
    }           
} 

?>