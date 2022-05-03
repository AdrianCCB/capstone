<?php 
include('core/config.php');
include('core/db.php');
include('core/functions.php');

clearCookies();

header("Location: " . SITE_URL . "admin-login.php"); 
exit();
?>