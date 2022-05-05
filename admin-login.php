<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(isLoggedIn()){
    header("Location: " . SITE_URL . "admin.php"); //redirect to dashboard
} 

$formName = $formPassword = $adminPassword = $userCount = "";
$formNameError = $formPasswordError = "";
$formNamePass = $formPasswordPass = "";

if(isset($_POST['login'])){
    $formName = input_validation($_POST['formName']);
    $formPassword = input_validation($_POST['formPassword']);

// Start of validation for the form
    # validate Name
    if (empty($formName)) {
        $formNameError = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $formName)) {
        $formNameError = "Only letters and white space allowed";
    } else {
        $formNamePass = true;
    }

    # validate Password 
    if (empty($formPassword)){
        $formPasswordError = "Password is required";
    } else {
        $formPasswordPass = true;
    }

    if ($formNamePass && $formPasswordPass == true){
        $userQuery = DB::query("SELECT * FROM adminaccount WHERE adminName = %s", $formName);
        $userCount = DB::count();
        
        if($userCount == 1){
            foreach($userQuery as $userResult){
                $adminID = $userResult["adminID"];
                $adminPassword = $userResult['adminPassword'];
            }
            if(password_verify($formPassword, $adminPassword)){
                # If Password matches
                # Set cookies
                setCookies($adminID);
                # set alertRedirect function to welcome admin
            } else {
                echo "<script>alert('Name and/or password mismatch');</script>";
                // if(!password_verify($formPassword, $adminPassword)){
                // };
            }
        } else {
            echo "<script>alert('Name and/or password mismatch');</script>";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login-styles.css">
</head>

<body id="login-bg">
    <section>
        <div class="container py-1 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form method="POST">
                                <div class="mb-md-1">

                                    <h2 class="fw-bold mb-2 text-uppercase">J.A.B Admin Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <div class="form-outline form-white mb-4">
                                        <span class="error"> <?php echo $formNameError ?></span>
                                        <input type="text" name="formName"  class="form-control form-control-lg" value="<?php echo $formName ?>"  />
                                        <label class="form-label" for="typeEmailX">Admin Name</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <span class="error"> <?php echo $formPasswordError ?></span>
                                        <input type="password" name="formPassword" id="typePasswordX" class="form-control form-control-lg"  value="<?php echo $formPassword ?>"  />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>
                                    <button id="bbtn" class="btn btn-outline-light btn-lg px-5" name="login" type="submit">Login</button>

                                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                        <a href="https://www.facebook.com" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                        <a href="https://www.twitter.com" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                        <a href="https://www.google.com" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                    </div>
                                </div>
                            </form>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
        if(password_verify($formPassword, $adminPassword)){
            alertRedirect('success', 'Welcome back', '', false, '1500', 'admin.php');
        } 
    ?>

</body>

</html>