<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

$id = ($_POST['id']);


$userQuery = DB::query("SELECT * FROM user WHERE userID=%i", $id);
foreach($userQuery as $userResult){
    $userName = $userResult['userName'];
    $userEmail = $userResult['userEmail'];
    $userPhone = $userResult['userPhone'];
}
$Response = array('userName' => $userName, 'userEmail' => $userEmail, 'userPhone' => $userPhone);
echo json_encode($Response);


?>