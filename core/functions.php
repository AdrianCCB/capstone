<?php
    # sweet alert pop up
    function alert1($icon, $title, $text, $confirm, $timer){
        echo "<script>
            Swal.fire({
                position: 'center',
                icon: '$icon',
                title: '$title',
                text: '$text',
                showConfirmButton: '$confirm',
                timer: $timer
              });
            </script>";
    }

    # sweet alert pop up and reset form
    function alertReset($icon, $title, $text, $confirm, $timer){
        echo "<script>
            Swal.fire({
                position: 'center',
                icon: '$icon',
                title: '$title',
                text: '$text',
                showConfirmButton: '$confirm',
                timer: $timer
                }).then(function(){
                    $('#appointment-form')[0].reset();
                });
            </script>";
    }
        

    # sweet alert pop up and redirect
    function alertRedirect($icon, $title, $text, $confirm, $timer, $redirect){
        echo "<script>
            Swal.fire({
                position: 'center',
                icon: '$icon',
                title: '$title',
                text: '$text',
                showConfirmButton: '$confirm',
                timer: $timer
                }).then(function(){
                window.location.href = '$redirect';
            });
            </script>";
    }

    # validate input value
    function input_validation($value) {
        $value = trim($value);      # Strip unnecessary characters (extra space, tab, newline) from the user input data
        $value = stripslashes($value);      #Remove backslashes (\) from the user input data
        $value = htmlspecialchars($value);      #converts special characters to HTML entities
        return $value;
    }

    # set Cookies with 30 days expiry
    function setCookies($adminID){
        setcookie("adminID", $adminID, time() + (86400 * 30)); 
        setcookie("isLoggedIn", true, time() + (86400 * 30)); 
    }

    # clear Cookies
    function clearCookies(){
        setcookie("adminID", "", time() - 3600); 
        setcookie("isLoggedIn", "", time() - 3600);  
    }

    # check if the user has logged in before
    function isLoggedIn(){
        if(isset($_COOKIE['adminID']) && isset($_COOKIE['isLoggedIn'])){
          $userQuery = DB::query("SELECT * FROM adminaccount WHERE adminID=%i", $_COOKIE['adminID']);
          $userCount = DB::count();
          if($userCount == 1){
              return true; //is logged in
          } else {
              return false; //is  NOT logged in
          }
        } else {
            return false; //is  NOT logged in
        }
    }    

    # similar to console.log
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Console log: " . $output . "' );</script>";
    }
?>