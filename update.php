<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

// Fullcalendar update php

if(isset($_POST["id"])){
    $title = $_POST['title'];
    $start = $_POST['start'];
    $id = $_POST['id'];
    $artist = $_POST['artist'];

    // combine artist and start date as condition
    $where = new WhereClause('and'); 
    $where->add('appointmentArtist=%s', $artist);
    $where->add('appointmentStartDate=%t', $start);

    // check if artist was booked on the date which customer selected
    $artistQuery = DB::query("SELECT * FROM appointment WHERE %l", $where);
    $artistCount = DB::count();

    if($artistCount == 0){
        DB::update('appointment', ['appointmentStartDate' => $start], 'appointmentID=%i', $id);
                 
        $isSuccess = DB::affectedRows();
        
        if ($isSuccess) {
            DB::commit();
            echo "success";
        } else {
            $rollBackError = DB::rollback();
        }   
    } else {
        echo "fail";
    }

   
}

?>